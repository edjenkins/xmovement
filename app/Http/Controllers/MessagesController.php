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
use Session;
use View;
use Carbon\Carbon;

// use App\Jobs\SendDirectMessageEmail;

use App\Idea;
use App\User;
use App\Message;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class MessagesController extends Controller
{
	public function send(Request $request, User $user)
	{
		// Save message

		$message = Message::create([
			'user_id' => $request->user_id,
			'sender_id' => Auth::user()->id,
			'text' => nl2br(htmlentities($request->text, ENT_QUOTES, 'UTF-8'))
		]);

		// Notify users via email

		// Check if users are being spammed
		// $direct_messages_count = Message::where([['receiver_id', $message->id], ['created_at', '>=', Carbon::now()->subDay()]])->count();

		// Log::info('Messages sent today - ' . $direct_messages_count);
		//
		// if ($recent_update_count < 2)
		// {
		// 	foreach ($idea->get_supporters() as $index => $supporter)
		// 	{
		// 		$job = (new SendUpdatePostedEmail(Auth::user(), $supporter->user, $idea, $update))->delay(5)->onQueue('emails');
		// 		$this->dispatch($job);
		// 	}
		// }
		// else
		// {
		// 	Log::error('Can only send 2 updates per day');
		// }

		Session::flash('flash_message', trans('flash_message.direct_messages_sent'));
		Session::flash('flash_type', 'flash-success');

		return redirect()->action('UserController@profile', $request->user_id);

		// Return JSON response

		// $response = new ResponseObject();
		//
		// $response->meta['success'] = true;
		//
		// return Response::json($response);
	}

}
