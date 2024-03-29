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

class PollController extends Controller
{

    public static function view(Request $request, $design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$poll = $design_task->xmovement_task;

        // Order by locked first, then highest voted, then alphabetically
        $poll->pollOptions = collect($poll->pollOptions)->sortByDesc(function ($poll_option, $key) {
            return sprintf('%s', $poll_option->voteCount());
        })->values()->all();

		// The user is putting a proposal together
		$proposal_mode = ($request->session()->has('proposal.active')) ? $request->session()->get('proposal.active') : false;
		$proposal_task_index = ($request->session()->has('proposal.task_index')) ? $request->session()->get('proposal.task_index') : 0;
		$proposal_tasks = ($request->session()->has('proposal.tasks')) ? $request->session()->get('proposal.tasks') : [];
		$contributions = $request->session()->get('proposal.contributions');

        return view('poll::view', ['poll' => $poll, 'idea' => $poll->idea, 'design_task' => $design_task, 'proposal_mode' => $proposal_mode, 'proposal_task_index' => $proposal_task_index, 'proposal_tasks' => $proposal_tasks, 'contributions' => $contributions]);
    }

    public function vote(Request $request)
    {
		$response = new ResponseObject();

		$poll_option = PollOption::whereId($request->votable_id)->first();

		$design_task = DesignTask::where([['xmovement_task_type','Poll'],['xmovement_task_id',$poll_option->poll->id]])->get()->first();

		if (Gate::denies('contribute', $design_task))
        {
            array_push($response->errors, trans('flash_message.no_permission'));

			return Response::json($response);
        }
		else
		{
	        $value = ($request->vote_direction == 'up') ? 1 : -1;
			return $poll_option->addVote($value);
		}
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;
    	$voting_type = $request->voting_type;
    	$contribution_type = $request->contribution_type;

		$validation['name'] = 'required|max:50|unique:design_tasks,name,NULL,id,idea_id,' . $idea_id;
		$validation['description'] = 'required|max:255';

		$this->validate($request, $validation);

		$poll_id = Poll::create([
			'user_id' => $user_id,
			'contribution_type' => $contribution_type,
			'voting_type' => $voting_type,
		])->id;

		$design_task = DesignTask::create([
			'user_id' => $user_id,
			'idea_id' => $idea_id,
			'name' => $request->name,
			'description' => $request->description,
			'xmovement_task_id' => $poll_id,
			'xmovement_task_type' => 'Poll',
			'proposal_interactivity' => true,
			'pinned' => ($request->pinned) ? $request->pinned : false,
			'locked' => ($request->locked) ? $request->locked : false,
		]);

	    // Load the design_task view
		return redirect()->action('\xmovement\poll\PollController@view', ['design_task' => $design_task]);
    }

    public function submitOption(Request $request)
    {
        $response = new ResponseObject();

        $value = $request->submission;

        $poll = Poll::whereId($request->poll_id)->first();

		$design_task = DesignTask::where([['xmovement_task_type','Poll'],['xmovement_task_id',$poll->id]])->get()->first();

		if ($value == "") {
			array_push($response->errors, 'Please enter a poll option');
			return Response::json($response);
		}

		if (DB::table('xmovement_poll_options')->where([['value', $value],['xmovement_poll_id', $request->poll_id]])->get()) {
			array_push($response->errors, 'Someone has already submitted that option');
			return Response::json($response);
		}
		else
		{
	        $pollOption = $poll->addOption($value);

	        if ($pollOption)
	        {
	            $response->meta['success'] = true;
	            $response->data['element'] = View::make('xmovement.poll.poll-option', ['pollOption' => $pollOption, 'design_task' => $design_task])->render();
	        }
		}

        return Response::json($response);

    }

}
