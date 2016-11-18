<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Mail;

use App\Message;
use App\User;


class SendDirectMessageEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $sender;
    protected $receiver;
    protected $direct_message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $receiver, Message $direct_message)
    {
        $this->sender = $sender;
		$this->receiver = $receiver;
        $this->direct_message = $direct_message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.direct-message', ['sender' => $this->sender, 'receiver' => $this->receiver, 'direct_message' => $this->direct_message], function ($message) {

            $message->to($this->receiver->email)->subject(Lang::get('emails.direct_message_subject', ['user_name' => $this->sender->name]));

        });
    }
}
