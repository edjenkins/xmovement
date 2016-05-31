<?php

namespace XMovement\Schedule;

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

class ScheduleController extends Controller
{

    public static function view($design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$schedule = $design_task->xmovement_task;

        return view('schedule::view', ['schedule' => $schedule, 'design_task' => $design_task]);
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;

			$validation['name'] = 'required|max:255';
			$validation['description'] = 'required|max:255';

			$this->validate($request, $validation);

      $schedule_id = Schedule::create([
          'user_id' => $user_id,
      ])->id;

      $design_task_id = DesignTask::create([
          'user_id' => $user_id,
          'idea_id' => $idea_id,
          'name' => $request->name,
          'description' => $request->description,
          'xmovement_task_id' => $schedule_id,
          'xmovement_task_type' => 'Schedule',
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
