<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Artisan;
use Auth;
use Gate;
use Response;
use Input;
use Lang;
use Log;
use View;
use Carbon\Carbon;

use App\Jobs\SendUpdatePostedEmail;

use App\Idea;
use App\User;
use App\Comment;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class CommentController extends Controller
{
	public function view(Request $request)
	{
		// Attempt to start brainsocket incase it has stopped

		Artisan::call('brainsocket:start', ['-q' => true, '--port' => getenv('BRAINSOCKET_PORT')]);

		$response = new ResponseObject();

		$url = $request->url;

		$comments = Comment::where([['url', $url], ['in_reply_to_comment_id', null]])->get();

		$response->meta['success'] = true;

		$response->data['comments'] = $comments;

		$authenticated_user = (Auth::user()) ? Auth::user() : null;

		foreach ($comments as $index => $comment)
		{
			$comment['view'] = View::make('discussion.comment', ['comment' => $comment, 'authenticated_user' => $authenticated_user])->render();
		}

		return Response::json($response);
	}

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $comment = Comment::whereId($request->votable_id)->first();

        if ($comment->addVote($value))
        {
            $response->meta['success'] = true;
        }
		else
		{
			array_push($response->errors, Lang::get('flash_message.vote_twice_error'));
		}

        $response->data['vote_count'] = $comment->voteCount();

        return Response::json($response);
    }

	public function destroy(Request $request)
	{
		$comment = Comment::whereId($request->comment_id)->first();

		$response = new ResponseObject();

		if (Gate::denies('destroy', $comment))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$comment->delete();

			$response->meta['success'] = true;

			return Response::json($response);
		}

	}
}
