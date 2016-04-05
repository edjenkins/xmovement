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
        $contribution->contributionOptions = collect($contribution->contributionOptions)->sortByDesc(function ($contribution_option, $key) {
            return sprintf('%s', $contribution_option->voteCount());
        })->values()->all();

        return view('contribution::view', ['contribution' => $contribution, 'design_task' => $design_task]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $contribution_option = ContributionOption::whereId($request->votable_id)->first();

        if ($contribution_option->addVote($value))
        {
            $response->meta['success'] = true;
        }
        
        $response->data['vote_count'] = $contribution_option->voteCount();
        
        return Response::json($response);
    }

    public function store(Request $request)
    {
    	$user_id = Auth::user()->id;
    	$idea_id = $request->idea_id;
    	$voting_type = $request->voting_type;
    	$contribution_type = $request->contribution_type;

        $contribution_id = Contribution::create([
            'user_id' => $user_id,
            'contribution_type' => $contribution_type,
            'voting_type' => $voting_type,
        ])->id;

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
		return $this->view($design_task_id);
    }

    public function update(Request $request)
    {
    	return 'update';
    }

    public function submitOption(Request $request)
    {
        $response = new ResponseObject();

        $value = $request->submission;

        $contribution = Contribution::whereId($request->contribution_id)->first();

        $contributionOption = $contribution->addOption($value);

        if ($contributionOption)
        {
            $response->meta['success'] = true;
            $response->data['element'] = View::make('xmovement.contribution.contribution-option', ['contributionOption' => $contributionOption])->render();
        }
        
        return Response::json($response);

    }

}