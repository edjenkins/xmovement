<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Gate;
use Log;
use Lang;
use MetaTag;
use Response;
use Session;

use App\Comment;
use App\CommentVote;
use App\DesignTask;
use App\Idea;
use App\Message;
use App\Proposal;
use App\ProposalVote;
use App\Supporter;
use App\Update;
use App\User;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class AnalyticsController extends Controller
{
    public function index()
    {
		# META
		MetaTag::set('title', Lang::get('meta.analytics_title'));
		MetaTag::set('description', Lang::get('meta.analytics_description'));
		# META

		if (Gate::denies('view_analytics', Auth::user()))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}
		else
		{
			return view('analytics.index');
		}
    }

	// API routes
	public function api_overview()
	{
		$response = new ResponseObject();

		if (Gate::denies('view_analytics', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$overview = [
				'comment_count' => Comment::count(),
				'comment_vote_count' => CommentVote::count(),
				'design_task_count' => DesignTask::count(),
				'idea_count' => Idea::count(),
				'message_count' => Message::count(),
				'proposal_count' => Proposal::count(),
				'proposal_vote_count' => ProposalVote::count(),
				'supporter_count' => Supporter::count(),
				'update_count' => Update::count(),
				'user_count' => User::count(),
			];

			$response->data['overview'] = $overview;

			return Response::json($response);
		}
	}

	public function api_users()
	{
		$response = new ResponseObject();

		if (Gate::denies('view_analytics', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$users = User::with('ideas')
			->with('comments')
			->with('design_tasks')
			->with('design_task_votes')
			->with('proposals')
			->get();

			$response->data['users'] = $users;

			return Response::json($response);
		}
	}

	public function api_ideas()
	{
		$response = new ResponseObject();

		if (Gate::denies('view_analytics', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$ideas = Idea::with('user')
			->with('designTasks')
			// ->with('designTaskVotes')
			->with('actions')
			->with('supporters')
			->with('proposals')
			->get();

			Log::error('Fetching comments');

			foreach ($ideas as $idea)
			{
				// Get comments
				$idea['comments'] = $idea->getComments();

				// Get share button click actions
				$idea['share_button_clicks'] = $idea->getShareButtonClicks();
			}

			$response->data['ideas'] = $ideas;

			return Response::json($response);
		}
	}

}
