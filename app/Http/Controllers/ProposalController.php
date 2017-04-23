<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Gate;
use Response;
use Input;
use Log;
use Session;

use App\Idea;
use App\Supporter;
use App\User;
use App\Proposal;
use App\DesignModule;
use App\DesignTask;
use App\DesignTaskVote;

class ResponseObject
{
    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class ProposalController extends Controller
{
    public function index(Request $request, Idea $idea)
    {
        $user = Auth::user();

        $is_existing_supporter = ($user) ? Supporter::where('user_id', $user->id)->where('idea_id', $idea->id)->exists() : false;

        if ($idea->visibility == 'private' && !$is_existing_supporter) {
            Session::flash('flash_message', trans('flash_message.proposal_phase_closed'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $idea);
        }

        // Order by locked first, then highest voted, then alphabetically
        $proposals = collect($idea->proposals)->sortByDesc(function ($proposal, $key) {
            return sprintf('%s', $proposal->voteCount());
        })->values()->all();

        return view('proposal.index', [
            'idea' => $idea,
            'proposals' => $proposals,
        ]);
    }

    public function view(Request $request, Proposal $proposal)
    {
        $user = Auth::user();

        $is_existing_supporter = ($user) ? Supporter::where('user_id', $user->id)->where('idea_id', $proposal->idea->id)->exists() : false;

        if ($proposal->idea->visibility == 'private' && !$is_existing_supporter) {
            Session::flash('flash_message', trans('flash_message.design_phase_closed'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $proposal->idea);
        }

        $user = Auth::user();

        $proposal->document = [];

        $proposal_items = json_decode($proposal->body);

        $design_tasks = [];

        foreach ($proposal_items as $index => $proposal_item) {
            switch ($proposal_item->type) {
                case 'task':

                    $design_task = DesignTask::whereId($proposal_item->id)->first();

                    $contribution_ids = json_decode($proposal_item->contribution_ids);

                    switch ($proposal_item->xmovement_task_type) {
                        case 'Poll':
                            $design_task->contributions = \XMovement\Poll\PollOption::whereIn('id', $contribution_ids)->get();
                            break;

                        case 'Contribution':
                            $design_task->contributions = \XMovement\Contribution\ContributionSubmission::whereIn('id', $contribution_ids)->get();
                            break;

                        case 'Scheduler':
                            $design_task->contributions = \XMovement\Scheduler\SchedulerOption::whereIn('id', $contribution_ids)->get();
                            break;
                    }

                    $proposal_item->design_task = $design_task;

                    break;

                case 'text':

                    $text = $proposal_item->text;

                    $proposal_item->text = $text;

                    break;
            }
        }

        return view('proposal.view', [
            'proposal' => $proposal,
            'proposal_items' => $proposal_items
        ]);
    }

    public function destroy(Request $request, Proposal $proposal)
    {
        if (Gate::denies('destroy', $proposal)) {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $proposal->idea);
        }

        $proposal->delete();

        Session::flash('flash_message', trans('flash_message.proposal_deleted'));
        Session::flash('flash_type', 'flash-danger');

        return redirect()->action('ProposalController@index', $proposal->idea);
    }

    public function add(Request $request, Idea $idea)
    {
        // Get out of proposal mode
        $request->session()->put('proposal.active', false);

        $user = Auth::user();

        $selected_tasks = $request->session()->get('proposal.tasks');
        $proposal_contributions = $request->session()->get('proposal.contributions');

        // $design_tasks = $this->fetchDesignTasks($selected_tasks, $proposal_contributions);

        return view('proposal.add', [
            'user' => $user,
            'idea' => $idea,
            // 'design_tasks' => $design_tasks
        ]);
    }

    public function submit(Request $request)
    {
        $idea = Idea::find($request->session()->get('proposal.idea_id'));

        if (Gate::denies('add_proposal', $idea)) {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $idea);
        }

        $user = Auth::user();

        // Validate the proposal
        $this->validate($request, [
            'description' => 'required|max:2000'
        ]);

        // Create the proposal
        $proposal = Proposal::create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'description' => $request->description,
            'body' => $request->proposal
        ]);

        return redirect()->action('ProposalController@view', $proposal);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $proposal = Proposal::whereId($request->votable_id)->first();

        if ($proposal->addVote($value)) {
            $response->meta['success'] = true;
        }

        $response->data['vote_count'] = $proposal->voteCount();

        return Response::json($response);
    }
}
