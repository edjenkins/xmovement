<?php

namespace XMovement\Contribution;

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

class ContributionController extends Controller
{

    public static function view(Request $request, $design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$contribution = $design_task->xmovement_task;

        // Order by locked first, then highest voted, then alphabetically
        $contribution->contributionSubmissions = collect($contribution->contributionSubmissions)->sortByDesc(function ($contribution_submission, $key) {
            return sprintf('%s', $contribution_submission->voteCount());
        })->values()->all();

		// The user is putting a proposal together
		$proposal_mode = ($request->session()->has('proposal.active')) ? $request->session()->get('proposal.active') : false;
		$proposal_task_index = ($request->session()->has('proposal.task_index')) ? $request->session()->get('proposal.task_index') : 0;
		$proposal_tasks = ($request->session()->has('proposal.tasks')) ? $request->session()->get('proposal.tasks') : [];
		$contributions = $request->session()->get('proposal.contributions');

        return view('contribution::view', ['contribution' => $contribution, 'design_task' => $design_task, 'proposal_mode' => $proposal_mode, 'proposal_task_index' => $proposal_task_index, 'proposal_tasks' => $proposal_tasks, 'contributions' => $contributions]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $contribution_submission = ContributionSubmission::whereId($request->votable_id)->first();

        if ($contribution_submission->addVote($value))
        {
            $response->meta['success'] = true;
        }

        $response->data['vote_count'] = $contribution_submission->voteCount();

        return Response::json($response);
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

		$contribution_id = Contribution::create([
			'user_id' => $user_id,
			'contribution_type' => $contribution_type,
			'voting_type' => $voting_type,
		])->id;

		ContributionType::create([
			'xmovement_contribution_id' => $contribution_id,
			'id' => $contribution_type,
		]);

		$design_task = DesignTask::create([
			'user_id' => $user_id,
			'idea_id' => $idea_id,
			'name' => $request->name,
			'description' => $request->description,
			'xmovement_task_id' => $contribution_id,
			'xmovement_task_type' => 'Contribution',
			'proposal_interactivity' => true,
			'pinned' => ($request->pinned) ? $request->pinned : false,
			'locked' => ($request->locked) ? $request->locked : false,
		]);

	    // Load the design_task view
		return redirect()->action('\xmovement\contribution\ContributionController@view', ['design_task' => $design_task]);
    }

    public function submitSubmission(Request $request)
    {
        $response = new ResponseObject();

        $value = $request->submission;

		$submission_type = $request->submission_type;

        $contribution = Contribution::whereId($request->contribution_id)->first();

		$design_task = DesignTask::where([['xmovement_task_type','Contribution'],['xmovement_task_id',$contribution->id]])->get()->first();

		// TODO: Check if submission exists
		if (DB::table('xmovement_contribution_submissions')->where([['value', $value],['xmovement_contribution_id', $request->contribution_id]])->get()) {
			array_push($response->errors, 'Someone has already submitted that contribution');
		}
		else
		{
	        $contributionSubmission = $contribution->addSubmission($submission_type, $value);

	        if ($contributionSubmission)
	        {
	            $response->meta['success'] = true;
	            $response->data['element'] = View::make('xmovement.contribution.contribution-submission', ['contributionSubmission' => $contributionSubmission, 'design_task' => $design_task])->render();
	        }
		}

        return Response::json($response);

    }

}
