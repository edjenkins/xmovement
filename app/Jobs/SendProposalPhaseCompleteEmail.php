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


class SendProposalPhaseCompleteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $idea;
    protected $proposal;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Idea $idea, Proposal $proposal)
    {
        $this->user = $user;
        $this->idea = $idea;
        $this->proposal = $proposal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.proposal-phase-complete', ['user' => $this->user, 'idea' => $this->idea, 'proposal' => $this->proposal], function ($message) {

            $message->to($this->user->email)->subject(Lang::get('emails.proposal_phase_complete_subject'));

        });
    }
}
