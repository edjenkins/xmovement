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

use App\Jobs\SendDirectMessageEmail;
use App\Jobs\SendQuoteEmail;

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
		// Check if users are being spammed
		$direct_messages_count = Message::where([['user_id', $request->user_id], ['sender_id', Auth::user()->id], ['created_at', '>=', Carbon::now()->subHour()]])->count();

		Log::info('Messages sent in the past hour - ' . $direct_messages_count);

		if ($direct_messages_count < 30)
		{
			// Save message

			$message = Message::create([
				'user_id' => $request->user_id,
				'sender_id' => Auth::user()->id,
				'text' => nl2br(htmlentities($request->text, ENT_QUOTES, 'UTF-8'))
			]);

			Session::flash('flash_message', trans('flash_message.direct_message_sent'));
			Session::flash('flash_type', 'flash-success');
		}
		else
		{
			Log::error('Can only send 30 messages per hour');
		}

		if ($direct_messages_count < 10)
		{
			// Notify users via email

			$job = (new SendDirectMessageEmail(Auth::user(), $message->user, $message))->delay(5)->onQueue('emails');
			$this->dispatch($job);

			Session::flash('flash_message', trans('flash_message.direct_message_sent_via_email'));
			Session::flash('flash_type', 'flash-success');
		}
		else
		{
			Log::error('Can only send 10 messages per hour via email');
		}

		return redirect()->action('UserController@profile', $request->user_id);
	}

	public function sendQuote(Request $request, User $user)
	{
		// Send quote via email

		$job = (new SendQuoteEmail(Auth::user()))->onQueue('emails');
		$this->dispatch($job);

		Session::flash('flash_message', trans('flash_message.quote_sent_via_email'));
		Session::flash('flash_type', 'flash-success');

		return redirect()->action('UserController@profile');
	}

}
