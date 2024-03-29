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
use App\DesignModule;
use App\DesignTask;
use App\DesignTaskVote;
use App\Supporter;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class DesignController extends Controller
{
    public function dashboard(Request $request, Idea $idea)
    {
		$user = Auth::user();

		$is_existing_supporter = ($user) ? Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists() : false;

		if ($idea->visibility == 'private' && !$is_existing_supporter)
		{
	        Session::flash('flash_message', trans('flash_message.design_phase_closed'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

		// Get out of proposal mode
		$request->session()->put('proposal.active', false);

        // Order by locked first, then highest voted, then alphabetically
        $design_tasks = collect($idea->designTasks)->sortByDesc(function ($design_task, $key) {
            return sprintf('%s%s', $design_task->pinned, $design_task->voteCount());
        })->values()->all();

        return view('design.dashboard', [
            'idea' => $idea,
            'design_tasks' => $design_tasks,
        ]);
    }

    public function add(Request $request, Idea $idea)
    {
		if (Gate::denies('contribute', $idea))
		{
	        Session::flash('flash_message', trans('flash_message.design_phase_closed'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

        // Fetch available design modules
        $all_design_modules = DesignModule::where('available','1')->get();

		$design_modules = Array();

		foreach ($all_design_modules as $index => $design_module)
		{
			if ($design_module->isAvailable())
			{
				array_push($design_modules, $design_module);
			}
		}
		
        return view('design.add', [
            'idea' => $idea,
            'design_modules' => $design_modules,
        ]);
    }

    public function vote(Request $request)
    {
		$response = new ResponseObject();

		$design_task = DesignTask::whereId($request->votable_id)->first();

        if (Gate::denies('design', $design_task->idea))
        {
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
        }

        $value = ($request->vote_direction == 'up') ? 1 : -1;
		return $design_task->addVote($value);
    }

    public function destroyTask(Request $request, DesignTask $design_task)
    {
		if (Gate::denies('destroy', $design_task))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

        $design_task->delete();

        Session::flash('flash_message', trans('flash_message.design_task_deleted'));
        Session::flash('flash_type', 'flash-success');

        return redirect()->action('DesignController@dashboard', $design_task->idea_id);
    }
}
