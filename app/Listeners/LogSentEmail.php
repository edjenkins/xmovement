<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Log;

use App\User;
use App\EmailLog;

class LogSentEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSending  $event
     * @return void
     */
    public function handle($message)
	{
		$email_log = new EmailLog();

		$to = array_keys($message->message->getTo());

		$user = User::where('email', array_shift($to))->first();

		$email_log->user_id = ($user) ? $user->id : NULL;
	    $email_log->to = ($user) ? $user->email : NULL;
	    $email_log->subject = $message->message->getSubject();
	    $email_log->cc = $message->message->getCc();
	    $email_log->bcc = $message->message->getBcc();
	    $email_log->body = $message->message->getBody();
	    $email_log->headers = serialize($message->message->getHeaders());

	    $email_log->save();
	}
}
