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
        $design_tasks = $idea->designTasks;

        foreach ($design_tasks as $index => $design_task)
        {
            $design_task['xmovement_task'] = $design_task->xmovement_task;            

            $design_task['user_vote'] = $design_task->userVote();
        }
        
        return view('design.dashboard', [
            'idea' => $idea,
            'design_tasks' => $design_tasks,
        ]);
    }

    public function add(Request $request, Idea $idea)
    {
        return view('design.add', [
            'idea' => $idea,
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
        
        return Response::json($response);
    }
}