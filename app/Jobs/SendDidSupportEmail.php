<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Mail;

use App\User;
use App\Idea;


class SendDidSupportEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $creator;
    protected $receiver;
    protected $idea;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $creator, User $receiver, Idea $idea)
    {
        $this->creator = $creator;
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
        Mail::send('emails.support', ['creator' => $this->creator, 'receiver' => $this->receiver, 'idea' => $this->idea], function ($message) {

            $message->to($this->receiver['email'])->subject(Lang::get('emails.support_subject', ['idea' => $this->idea->name]));

        });
    }
}
