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

		foreach ($comments as $index => $comment)
		{
			$comment['view'] = View::make('discussion.comment', ['comment' => $comment])->render();
		}

		return Response::json($response);
	}
}
