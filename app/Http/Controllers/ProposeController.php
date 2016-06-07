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
        if (Gate::denies('propose', $idea))
        {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

            return redirect()->back();
        }

		// Get out of proposal mode
		$request->session()->put('proposal.active', false);

        // Fetch proposals
        $proposals = Proposal::get();

        return view('propose.index', [
            'idea' => $idea,
            'proposals' => $proposals,
        ]);
    }

    public function view(Request $request, Proposal $proposal)
    {
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
			Session::flash('flash_type', 'flash-warning');
		}
		else
		{
			$proposal->delete();

			Session::flash('flash_message', trans('flash_message.proposal_deleted'));
			Session::flash('flash_type', 'flash-danger');
		}

        return redirect()->action('ProposeController@index', $proposal->idea);
    }

	private function fetchDesignTasks($selected_tasks, $proposal_contributions)
	{
		$design_tasks = DesignTask::with('xmovement_task')
            ->whereIn('id', $selected_tasks)
            ->get();

		foreach ($design_tasks as $index => $design_task)
		{
			$contributions = $proposal_contributions[$design_task->id];

			$contribution_ids = explode(',', $contributions);;

			$design_task->contribution_ids = $contribution_ids;

			switch ($design_task->xmovement_task_type) {
				case 'Poll':
					$design_task->contributions = \XMovement\Poll\PollOption::whereIn('id', $contribution_ids)->get();
					break;

				case 'Contribution':
					$design_task->contributions = \XMovement\Contribution\ContributionSubmission::whereIn('id', $contribution_ids)->get();
					break;
			}

		}
		return $design_tasks;
	}

	public function review(Request $request, Idea $idea)
	{
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
		$user = Auth::user();

		// Validate the proposal
	    $this->validate($request, [
	        'description' => 'required|max:500'
	    ]);

	    // Create the idea
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
        // Order by locked first, then highest voted, then alphabetically
        $design_tasks = collect($idea->designTasks)->sortByDesc(function ($design_task, $key) {
            return sprintf('%s%s', $design_task->locked, $design_task->voteCount());
        })->values()->all();

        return view('propose.tasks', [
            'idea' => $idea,
            'design_tasks' => $design_tasks,
        ]);
    }

    public function select(Request $request, Idea $idea)
    {
		// Save selected tasks to session
		$selected_tasks = json_decode($request->selected_tasks);

		$request->session()->put('proposal.active', true);
		$request->session()->put('proposal.tasks', $selected_tasks);
		$request->session()->put('proposal.task_index', 0);
		$request->session()->put('proposal.idea_id', $idea->id);
		$request->session()->put('proposal.contributions');

		// Find the first design task
		$design_task = DesignTask::find($selected_tasks[0]);

		// Redirect to first design task
		return redirect("/design/" . strtolower($design_task->xmovement_task_type) . "/" . $design_task->id);
	}

    public function previous(Request $request)
    {
		// Get selected tasks
		$selected_tasks = $request->session()->get('proposal.tasks');

		// Get current task index
		$task_index = ($request->session()->get('proposal.task_index') - 1);

		// Redirect to next design task
		if ($task_index < 0)
		{
			$idea = Idea::find($request->session()->get('proposal.idea_id'));
			return redirect()->action('ProposeController@tasks', $idea);
		}
		else
		{
			// Put new index value in session
			$request->session()->put('proposal.task_index', $task_index);

			// Find the next design task
			$design_task = DesignTask::find($selected_tasks[$task_index]);

			return redirect("/design/" . strtolower($design_task->xmovement_task_type) . "/" . $design_task->id );
		}

	}

	public function next(Request $request)
	{
		// Get selected tasks
		$selected_tasks = $request->session()->get('proposal.tasks');

		// Get current task index
		$task_index = $request->session()->get('proposal.task_index');

		// Update proposal contributions
		$proposal_contributions = $request->session()->get('proposal.contributions');

		$string_index = (String)$task_index;

		$key = (String)$selected_tasks[$string_index];

		$proposal_contributions[$key] = $request->selected_contributions;

		$request->session()->put('proposal.contributions', $proposal_contributions);

        Log::info('Proposal contributions - ', $proposal_contributions);

		// Update task index
		$task_index++;

		// Put new index value in session
		$request->session()->put('proposal.task_index', $task_index);


		if ($task_index >= count($selected_tasks))
		{
			$idea = Idea::find($request->session()->get('proposal.idea_id'));
			return redirect()->action('ProposeController@review', $idea);
		}
		else
		{
			// Find the next design task
			$design_task = DesignTask::find($selected_tasks[$task_index]);

			// Redirect to next design task
			return redirect("/design/" . strtolower($design_task->xmovement_task_type) . "/" . $design_task->id );
		}
	}
}
