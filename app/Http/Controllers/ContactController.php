<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Jobs\SendContactEmail;

use Log;
use Session;

class ContactController extends Controller
{
    public function send(Request $request)
	{
		$name = $request->name;
		$email = $request->email;
		$text = $request->text;

		// Validate

		$this->validate($request, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'text' => 'required'
		]);

		// Send

		$job = (new SendContactEmail($name, $email, $text))->delay(5)->onQueue('emails');
		$this->dispatch($job);

		// Respond

		Session::flash('flash_message', trans('flash_message.contact_message_sent'));
		Session::flash('flash_type', 'flash-success');

		return redirect()->action('PageController@contact');
	}
}
