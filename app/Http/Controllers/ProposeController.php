<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Gate;
use Response;
use Input;
use Log;
use Session;

use App\Idea;
use App\Supporter;
use App\User;
use App\Proposal;
use App\DesignModule;
use App\DesignTask;
use App\DesignTaskVote;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class ProposeController extends Controller
{
    public function index(Request $request, Idea $idea)
    {
		$user = Auth::user();

		$is_existing_supporter = ($user) ? Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists() : false;

		if ($idea->visibility == 'private' && !$is_existing_supporter)
		{
	        Session::flash('flash_message', trans('flash_message.proposal_phase_closed'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

		// Get out of proposal mode
		$request->session()->put('proposal.active', false);

        // Order by locked first, then highest voted, then alphabetically
        $proposals = collect($idea->proposals)->sortByDesc(function ($proposal, $key) {
            return sprintf('%s', $proposal->voteCount());
        })->values()->all();

        return view('propose.index', [
            'idea' => $idea,
            'proposals' => $proposals,
        ]);
    }

    public function view(Request $request, Proposal $proposal)
    {
		$user = Auth::user();

		$is_existing_supporter = ($user) ? Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists() : false;

		if ($idea->visibility == 'private' && !$is_existing_supporter)
		{
	        Session::flash('flash_message', trans('flash_message.design_phase_closed'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $proposal->idea);
		}

		// Get out of proposal mode
		$request->session()->put('proposal.active', false);

		$user = Auth::user();

		$proposal->document = [];

		$proposal_items = json_decode($proposal->body);

		$design_tasks = [];

		foreach ($proposal_items as $index => $proposal_item) {

			switch ($proposal_item->type) {
				case 'task':

					$design_task = DesignTask::whereId($proposal_item->id)->first();

					$contribution_ids = json_decode($proposal_item->contribution_ids);

					switch ($proposal_item->xmovement_task_type) {
						case 'Poll':
							$design_task->contributions = \XMovement\Poll\PollOption::whereIn('id', $contribution_ids)->get();
							break;

						case 'Contribution':
							$design_task->contributions = \XMovement\Contribution\ContributionSubmission::whereIn('id', $contribution_ids)->get();
							break;

						case 'Scheduler':
							$design_task->contributions = \XMovement\Scheduler\SchedulerOption::whereIn('id', $contribution_ids)->get();
							break;
					}

					$proposal_item->design_task = $design_task;

					break;

				case 'text':

					$text = $proposal_item->text;

					$proposal_item->text = $text;

					break;
			}

		}

		return view('propose.view', [
			'proposal' => $proposal,
			'proposal_items' => $proposal_items
		]);
    }

    public function add(Request $request, Idea $idea)
    {
		if (Gate::denies('add_proposal', $idea))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

        // Fetch proposals
        $proposals = Proposal::get();

        return view('propose.add', [
            'idea' => $idea,
            'proposals' => $proposals,
        ]);
    }

    public function destroy(Request $request, Proposal $proposal)
    {
		if (Gate::denies('destroy', $proposal))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $proposal->idea);
		}

		$proposal->delete();

		Session::flash('flash_message', trans('flash_message.proposal_deleted'));
		Session::flash('flash_type', 'flash-danger');

        return redirect()->action('ProposeController@index', $proposal->idea);
    }

	private function fetchDesignTasks($selected_tasks, $proposal_contributions)
	{
		$collection = collect($selected_tasks);

		$plucked = $collection->pluck('id');

		$selected_task_ids = $plucked->all();

		$design_tasks = DesignTask::with('xmovement_task')
            ->whereIn('id', $selected_task_ids)
            ->get();

		foreach ($design_tasks as $index => $design_task)
		{
			if (array_key_exists($design_task->id, $proposal_contributions))
			{

				$contributions = $proposal_contributions[$design_task->id];

				$design_task->contribution_ids = $contributions;

				switch ($design_task->xmovement_task_type) {
					case 'Poll':
						$design_task->contributions = \XMovement\Poll\PollOption::whereIn('id', $design_task->contribution_ids)->get();
						break;

					case 'Contribution':
						$design_task->contributions = \XMovement\Contribution\ContributionSubmission::whereIn('id', $design_task->contribution_ids)->get();
						break;

					case 'Scheduler':
						$design_task->contributions = \XMovement\Scheduler\SchedulerOption::whereIn('id', $design_task->contribution_ids)->get();
						break;
				}
			}

		}
		return $design_tasks;
	}

	public function review(Request $request, Idea $idea)
	{
		// Get out of proposal mode
		$request->session()->put('proposal.active', false);

		$user = Auth::user();

		$selected_tasks = $request->session()->get('proposal.tasks');
		$proposal_contributions = $request->session()->get('proposal.contributions');

		$design_tasks = $this->fetchDesignTasks($selected_tasks, $proposal_contributions);

		return view('propose.review', [
			'user' => $user,
			'idea' => $idea,
			'design_tasks' => $design_tasks
		]);
	}

	public function submit(Request $request)
	{
		$idea = Idea::find($request->session()->get('proposal.idea_id'));

		if (Gate::denies('add_proposal', $idea))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

		$user = Auth::user();

		// Validate the proposal
	    $this->validate($request, [
	        'description' => 'required|max:500'
	    ]);

	    // Create the proposal
	    Proposal::create([
	        'idea_id' => $idea->id,
	        'user_id' => $user->id,
	        'description' => $request->description,
	        'body' => $request->proposal
	    ]);

		return redirect()->action('ProposeController@index', $idea);
	}

	// workflow

    public function tasks(Request $request, Idea $idea)
    {
		if ($request->isMethod('get'))
		{
	        // Order by locked first, then highest voted, then alphabetically
	        $design_tasks = collect($idea->designTasks)->sortByDesc(function ($design_task, $key) {
	            return sprintf('%s%s', $design_task->locked, $design_task->voteCount());
	        })->values()->all();

	        return view('propose.tasks', [
	            'idea' => $idea,
	            'design_tasks' => $design_tasks,
	        ]);
		}

		if ($request->isMethod('post'))
		{
			// Save selected tasks to session
			$selected_tasks = json_decode($request->selected_tasks);

			$request->session()->put('proposal.tasks', $selected_tasks);
			$request->session()->put('proposal.task_index', -1);
			$request->session()->put('proposal.idea_id', $idea->id);
			$request->session()->put('proposal.contributions', []);

			return $this->loadTask($request, 1);
		}
    }

    public function previous(Request $request)
    {
		return $this->loadTask($request, -1);

	}

	public function next(Request $request)
	{
		return $this->loadTask($request, 1);
	}

	private function loadTask(Request $request, $direction)
	{
		$request->session()->put('proposal.active', true);

		// Get selected tasks
		$selected_tasks = $request->session()->get('proposal.tasks');

		// Get current task index
		$task_index = $request->session()->get('proposal.task_index');

		// Update proposal contributions
		$proposal_contributions = $request->session()->get('proposal.contributions');

		// Save selected contributions
		if ($request->current_task)
		{
			$proposal_contributions[$request->current_task] = explode(',', $request->selected_contributions);
			$request->session()->put('proposal.contributions', $proposal_contributions);
		}

		// Put new index value in session
		$task_index = $task_index + $direction;

		$request->session()->put('proposal.task_index', $task_index);

		$idea = Idea::find($request->session()->get('proposal.idea_id'));

		$skipping = true;

		while ($skipping)
		{
			if ($task_index >= count($selected_tasks))
			{
				$skipping = false;
				return redirect()->action('ProposeController@review', $idea);
			}
			else if ($task_index < 0)
			{
				$skipping = false;
				return redirect()->action('ProposeController@tasks', $idea);
			}
			else
			{
				// Find the next design task
				$design_task = DesignTask::find($selected_tasks[$task_index]->id);

				if ($design_task->proposal_interactivity)
				{
					// Redirect to next design task
					$skipping = false;
					return redirect("/design/" . strtolower($design_task->xmovement_task_type) . "/" . $design_task->id );
				}
				else
				{
					// No interaction so contrinue / skip
					$task_index = $task_index + $direction;
					$request->session()->put('proposal.task_index', $task_index);
				}
			}
		}

	}

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $proposal = Proposal::whereId($request->votable_id)->first();

        if ($proposal->addVote($value))
        {
            $response->meta['success'] = true;
        }

        $response->data['vote_count'] = $proposal->voteCount();

        return Response::json($response);
    }
}
