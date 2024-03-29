<?php

namespace XMovement\Discussion;

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

class DiscussionController extends Controller
{

    public static function view($design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$discussion = $design_task->xmovement_task;

        return view('discussion::view', ['discussion' => $discussion, 'design_task' => $design_task]);
    }

    public function store(Request $request)
    {
		$user_id = Auth::user()->id;
		$idea_id = $request->idea_id;

		$validation['name'] = 'required|max:50|unique:design_tasks,name,NULL,id,idea_id,' . $idea_id;
		$validation['description'] = 'required|max:255';

		$this->validate($request, $validation);

		$discussion_id = Discussion::create([
			'user_id' => $user_id
		])->id;

		$design_task = DesignTask::create([
			'user_id' => $user_id,
			'idea_id' => $idea_id,
			'name' => $request->name,
			'description' => $request->description,
			'xmovement_task_id' => $discussion_id,
			'xmovement_task_type' => 'Discussion',
			'proposal_interactivity' => false,
			'pinned' => ($request->pinned) ? $request->pinned : false,
			'locked' => ($request->locked) ? $request->locked : false,
		]);

		// Load the design_task view
		return redirect()->action('\xmovement\discussion\DiscussionController@view', ['design_task' => $design_task]);
    }

    public function update(Request $request)
    {
    	return 'update';
    }

}
