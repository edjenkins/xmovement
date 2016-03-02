<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

use App\User;
use App\Idea;


class SendInviteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $sender;
    protected $receiver;
    protected $idea;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $sender, Array $receiver, Idea $idea)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->idea = $idea;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.invite', ['sender' => $this->sender, 'receiver' => $this->receiver, 'idea' => $this->idea], function ($message) {

            $message->to($this->receiver['email'])->subject($this->sender->name . ' has sent you an invitation');

        });
    }
}
