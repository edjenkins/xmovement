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
        if (Gate::denies('design', $idea))
        {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

            return redirect()->back();
        }

		// Get out of proposal mode
		$request->session()->put('proposal.active', false);

        // Order by locked first, then highest voted, then alphabetically
        $design_tasks = collect($idea->designTasks)->sortByDesc(function ($design_task, $key) {
            return sprintf('%s%s', $design_task->locked, $design_task->voteCount());
        })->values()->all();

        return view('design.dashboard', [
            'idea' => $idea,
            'design_tasks' => $design_tasks,
        ]);
    }

    public function add(Request $request, Idea $idea)
    {
        // Fetch available design modules
        $design_modules = DesignModule::get();

        return view('design.add', [
            'idea' => $idea,
            'design_modules' => $design_modules,
        ]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $design_task = DesignTask::whereId($request->votable_id)->first();

        if ($design_task->addVote($value))
        {
            $response->meta['success'] = true;
        }

        $response->data['vote_count'] = $design_task->voteCount();

        return Response::json($response);
    }

    public function destroyTask(Request $request, DesignTask $design_task)
    {
        if (Gate::denies('destroy', $design_task))
        {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-warning');
        }
        else
        {
            $design_task->delete();

            Session::flash('flash_message', trans('flash_message.design_task_deleted'));
            Session::flash('flash_type', 'flash-danger');
        }

        return redirect()->action('DesignController@dashboard', $design_task->idea_id);
    }
}
