<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

use App\User;
use App\Idea;


class SendDesignPhaseOpenEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $idea;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Idea $idea)
    {
        $this->user = $user;
        $this->idea = $idea;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.design-phase-open', ['user' => $this->user, 'idea' => $this->idea], function ($message) {

            $message->to($this->user->email)->subject('Start designing');

        });
    }
}
