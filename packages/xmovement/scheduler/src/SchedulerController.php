<?php

namespace XMovement\Scheduler;

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

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class SchedulerController extends Controller
{

    public static function view(Request $request, $design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$scheduler = $design_task->xmovement_task;

        // Order by locked first, then highest voted, then alphabetically
        $scheduler->schedulerOptions = collect($scheduler->schedulerOptions)->sortByDesc(function ($scheduler_option, $key) {
            return sprintf('%s', $scheduler_option->voteCount());
        })->values()->all();

		// The user is putting a proposal together
		$proposal_mode = ($request->session()->has('proposal.active')) ? $request->session()->get('proposal.active') : false;
		$proposal_task_index = ($request->session()->has('proposal.task_index')) ? $request->session()->get('proposal.task_index') : 0;
		$proposal_tasks = ($request->session()->has('proposal.tasks')) ? $request->session()->get('proposal.tasks') : [];
		$contributions = $request->session()->get('proposal.contributions');

        return view('scheduler::view', ['scheduler' => $scheduler, 'design_task' => $design_task, 'proposal_mode' => $proposal_mode, 'proposal_task_index' => $proposal_task_index, 'proposal_tasks' => $proposal_tasks, 'contributions' => $contributions]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $scheduler_option = SchedulerOption::whereId($request->votable_id)->first();

        if ($scheduler_option->addVote($value))
        {
            $response->meta['success'] = true;
        }

        $response->data['vote_count'] = $scheduler_option->voteCount();

        return Response::json($response);
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;
    	$voting_type = $request->voting_type;

			$validation['name'] = 'required|max:50';
			$validation['description'] = 'required|max:255';

			$this->validate($request, $validation);

      $scheduler_id = Scheduler::create([
          'user_id' => $user_id,
          'voting_type' => $voting_type,
      ])->id;

      $design_task = DesignTask::create([
          'user_id' => $user_id,
          'idea_id' => $idea_id,
          'name' => $request->name,
          'description' => $request->description,
          'xmovement_task_id' => $scheduler_id,
          'xmovement_task_type' => 'Scheduler',
          'proposal_interactivity' => true,
		  'pinned' => ($request->pinned) ? $request->pinned : false,
		  'locked' => ($request->locked) ? $request->locked : false,
      ]);

	    // Load the design_task view
		return redirect()->action('\xmovement\scheduler\SchedulerController@view', ['design_task' => $design_task]);
    }

    public function update(Request $request)
    {
    	return 'update';
    }

    public function submitOption(Request $request)
    {
        $response = new ResponseObject();

        $value = $request->submission;

        $scheduler = Scheduler::whereId($request->scheduler_id)->first();

		if (DB::table('xmovement_scheduler_options')->where('value', $value)->get()) {
			array_push($response->errors, 'Someone has already submitted that time/date');
			return Response::json($response);
		}
		else
		{
	        $schedulerOption = $scheduler->addOption($value);

	        if ($schedulerOption)
	        {
	            $response->meta['success'] = true;
	            $response->data['element'] = View::make('xmovement.scheduler.scheduler-option', ['schedulerOption' => $schedulerOption])->render();
	        }
		}

        return Response::json($response);

    }

}
