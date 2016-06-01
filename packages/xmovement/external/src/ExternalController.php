<?php

namespace XMovement\External;

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

class ExternalController extends Controller
{

    public static function view($design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$external = $design_task->xmovement_task;

        return view('external::view', ['external' => $external, 'design_task' => $design_task]);
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;
    	$embed_code = $request->embed_code;
    	$external_link = $request->external_link;

			$validation['name'] = 'required|max:255';
			$validation['description'] = 'required|max:255';
			$validation['embed_code'] = 'required_without:external_link';
			$validation['external_link'] = 'required_without:embed_code|max:2000';

			$this->validate($request, $validation);

      $external_id = External::create([
          'user_id' => $user_id,
          'embed_code' => $embed_code,
          'external_link' => $external_link,
      ])->id;

      $design_task_id = DesignTask::create([
          'user_id' => $user_id,
          'idea_id' => $idea_id,
          'name' => $request->name,
          'description' => $request->description,
          'xmovement_task_id' => $external_id,
          'xmovement_task_type' => 'External',
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