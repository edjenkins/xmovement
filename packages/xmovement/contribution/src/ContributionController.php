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

    public static function view($design_task_id)
    {
    	$design_task = DesignTask::where('id', $design_task_id)->get()->first();

    	$contribution = $design_task->xmovement_task;

        // Order by locked first, then highest voted, then alphabetically
        $contribution->contributionSubmissions = collect($contribution->contributionSubmissions)->sortByDesc(function ($contribution_submission, $key) {
            return sprintf('%s', $contribution_submission->voteCount());
        })->values()->all();

        return view('contribution::view', ['contribution' => $contribution, 'design_task' => $design_task]);
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

			$validation['name'] = 'required|max:255';
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

      $design_task_id = DesignTask::create([
          'user_id' => $user_id,
          'idea_id' => $idea_id,
          'name' => $request->name,
          'description' => $request->description,
          'xmovement_task_id' => $contribution_id,
          'xmovement_task_type' => 'Contribution',
          'locked' => $request->locked,
      ])->id;

	    // Load the design_task view
      return redirect()->action('DesignController@dashboard', $idea_id);
    }

    public function update(Request $request)
    {
    	return 'update';
    }

    public function submitSubmission(Request $request)
    {
        $response = new ResponseObject();

        $value = $request->submission;
        $submission_type = $request->submission_type;

        $contribution = Contribution::whereId($request->contribution_id)->first();

        return $contribution->addSubmission($submission_type, $value, $response);
    }

}
