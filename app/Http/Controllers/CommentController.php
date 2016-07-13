<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
		$response = new ResponseObject();

		$url = $request->url;

		$comments = Comment::where('url', $url)->get();

		$response->meta['success'] = true;

		$response->data['comments'] = $comments;

		$user_id = (Auth::user()) ? Auth::user()->id : null;

		foreach ($comments as $index => $comment)
		{
			$comment['view'] = View::make('discussion.comment', ['comment' => $comment, 'authenticated_user_id' => $user_id])->render();
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
}
