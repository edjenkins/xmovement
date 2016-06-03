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

    public function view(Request $request, Idea $idea)
    {
        // Do nothing
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

	public function review(Request $request, Idea $idea)
	{
		$user = Auth::user();
		
		$proposal = [];

		// $request->session()->put('proposal.active', true);
		// $request->session()->put('proposal.task_index', 0);
		// $request->session()->put('proposal.idea_id', $idea->id);

		$selected_tasks = $request->session()->get('proposal.tasks');

		$design_tasks = DB::table('design_tasks')
            ->whereIn('id', $selected_tasks)
            ->get();

		return view('propose.review', [
			'user' => $user,
			'idea' => $idea,
			'proposal' => $proposal,
			'design_tasks' => $design_tasks
		]);
	}

	public function submit(Request $request)
	{
		$idea = Idea::find($request->session()->get('proposal.idea_id'));

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
		$task_index = $request->session()->get('proposal.task_index') + 1;

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
