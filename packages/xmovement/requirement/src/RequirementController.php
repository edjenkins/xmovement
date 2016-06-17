<?php

namespace XMovement\Requirement;

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
use View;

use App\Idea;
use App\User;
use App\DesignTask;
use App\DesignTaskVote;

use App\Jobs\SendXMovementRequirementInviteEmail;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class RequirementController extends Controller
{

    public static function view($design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$requirement = $design_task->xmovement_task;

        return view('requirement::view', ['requirement' => $requirement, 'design_task' => $design_task]);
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;

			$validation['name'] = 'required|max:50';
			$validation['description'] = 'required|max:255';
			$validation['item'] = 'required|max:255';
			$validation['count'] = 'required|integer|between:0,10000';

			$this->validate($request, $validation);

      $requirement_id = Requirement::create([
          'user_id' => $user_id,
          'item' => $request->item,
          'count' => $request->count,
      ])->id;

      $design_task_id = DesignTask::create([
          'user_id' => $user_id,
          'idea_id' => $idea_id,
          'name' => $request->name,
          'description' => $request->description,
          'xmovement_task_id' => $requirement_id,
          'xmovement_task_type' => 'Requirement',
          'proposal_interactivity' => false,
		  'pinned' => ($request->pinned) ? $request->pinned : false,
		  'locked' => ($request->locked) ? $request->locked : false,
      ])->id;

	    // Load the design_task view
			return $this->view($design_task_id);
    }

    public function submit(Request $request)
    {
        $response = new ResponseObject();

        $requirement_id = $request->requirement_id;
        $submission_type = $request->submission_type;

        $requirement = Requirement::whereId($request->requirement_id)->first();

        if ($submission_type == 'fill')
        {
            $response->data['requirement_filled_id'] = $requirement->fillRequirement()->id;

            $response->meta['success'] = true;
        }
        else if ($submission_type == 'invite')
        {
            // Send email

            $name = $request->name;
            $email = $request->email;
            $personal_message = $request->message;
            $link = $request->link;

            $user = Auth::user();

            $job = (new SendXMovementRequirementInviteEmail($name, $email, $personal_message, $link, $user))->onQueue('emails');

            $this->dispatch($job);

            $response->meta['success'] = true;
        }

        return Response::json($response);
    }

    public function withdraw(Request $request)
    {
        $response = new ResponseObject();

        $requirement_filled = RequirementFilled::whereId($request->requirement_filled_id)->first();

        if ($requirement_filled->withdraw())
        {
            $response->meta['success'] = true;
        }

        return Response::json($response);
    }

}
