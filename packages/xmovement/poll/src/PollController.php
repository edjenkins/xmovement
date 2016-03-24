<?php

namespace XMovement\Poll;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
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
 
class PollController extends Controller
{
 
    public static function view($design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();
    	
    	$poll = $design_task->xmovement_task;

        return view('poll::view', ['poll' => $poll, 'design_task' => $design_task]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $poll_option = PollOption::whereId($request->votable_id)->first();

        if ($poll_option->addVote($value))
        {
            $response->meta['success'] = true;
        }
        
        return Response::json($response);
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;
    	$voting_type = $request->voting_type;
    	$contribution_type = $request->contribution_type;

        $poll_id = Poll::create([
            'user_id' => $user_id,
            'contribution_type' => $contribution_type,
            'voting_type' => $voting_type,
        ])->id;

        $design_task_id = DesignTask::create([
            'user_id' => $user_id,
            'idea_id' => $idea_id,
            'name' => $request->name,
            'description' => $request->description,
            'xmovement_task_id' => $poll_id,
            'xmovement_task_type' => 'Poll',
            'locked' => $request->locked,
        ])->id;

	    // Load the design_task view
		return $this->view($design_task_id);
    }

    public function update(Request $request)
    {
    	return 'update';
    }

}