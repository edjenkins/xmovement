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
use App\CommentTarget;

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
    use \App\PostsComments;

	public function view(Request $request)
	{
		$response = new ResponseObject();

		$url = $request->url;

		$url = preg_replace("(^https?://)", "", $url);

		$comment_target = CommentTarget::where('url', $url)->first();

		if ($comment_target)
		{
			$comment_target->target_id = $request->target_id;
			$comment_target->target_type = $request->target_type;
			$comment_target->idea_id = $request->idea_id;

			$comment_target->save();
		}

		if (!$comment_target)
		{
			$comment_target = CommentTarget::create([
	            'target_id' => $request->target_id,
	            'target_type' => $request->target_type,
				'idea_id' => $request->idea_id,
				'url' => $url,
				'locked' => false
	        ]);
        }

		$comments = Comment::where([['comment_target_id', $comment_target->id], ['in_reply_to_comment_id', null]])->get();

		$response->meta['success'] = true;

		$response->data['comments'] = $comments;

		$response->data['comment_target'] = $comment_target;

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

	public function post(Request $request)
	{
		$response = new ResponseObject();

		if (Auth::guest())
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{

			$url = $request->url;
			$text = $request->comment;
			$in_reply_to_comment_id = isset($request->in_reply_to_comment_id) ? $request->in_reply_to_comment_id : NULL;
			$user_id = Auth::user()->id;

			$comment = $this->postComment($text, $url, $in_reply_to_comment_id, $user_id);

			if ($comment)
			{
				$response->data = $comment;
				$response->view = View::make('discussion.comment', ['comment' => $comment, 'authenticated_user' => Auth::user()])->render();

				$response->meta['success'] = true;
			}

			return Response::json($response);
		}
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
