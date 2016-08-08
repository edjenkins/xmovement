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
use App\Proposal;


class SendProposalPhaseFailedEmail extends Job implements ShouldQueue
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
        Mail::send('emails.proposal-phase-failed', ['user' => $this->user, 'idea' => $this->idea], function ($message) {

            $message->to($this->user->email)->subject(Lang::get('emails.proposal_phase_failed_subject'));

        });
    }
}
