<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Mail;

use App\Idea;
use App\Update;
use App\User;


class SendUpdatePostedEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $sender;
    protected $receiver;
    protected $idea;
    protected $update;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $receiver, Idea $idea, Update $update)
    {
        $this->sender = $sender;
		$this->receiver = $receiver;
        $this->idea = $idea;
        $this->update = $update;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.update-posted', ['idea' => $this->idea, 'sender' => $this->sender, 'receiver' => $this->receiver, 'update' => $this->update], function ($message) {

            $message->to($this->receiver->email)->subject(Lang::get('emails.update_posted_subject', ['user_name' => $this->sender->name]));

        });
    }
}
