<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use DB;
use Mail;
use Log;

use App\User;
use App\Idea;
use App\Proposal;

use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Jobs\SendCreateIdeaEmail;
use App\Jobs\SendInviteEmail;
use App\Jobs\SendDidSupportEmail;
use App\Jobs\SendSupportPhaseUpdatesEmail;
use App\Jobs\SendDesignPhaseUpdatesEmail;
use App\Jobs\SendProposalPhaseUpdatesEmail;
use App\Jobs\SendDesignPhaseOpenEmail;
use App\Jobs\SendProposalPhaseOpenEmail;
use App\Jobs\SendProposalPhaseCompleteEmail;
use App\Jobs\SendProposalPhaseFailedEmail;
use App\Jobs\SendXMovementRequirementInviteEmail;

class SendTestEmails extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		Log::info('Sending test emails');

		$user = User::where('id', 1)->first();
		$idea = Idea::where('id', 1)->first();
		$proposal = Proposal::where('id', 1)->first();

		$sender = $user;
		$receiver = $user;

		$name = $user->name;
		$email = $user->email;

		$personal_message = 'This is a personal message';
		$link = action('PageController@home');

		//$job = (new SendWelcomeEmail($user, true))->delay(30)->onQueue('emails');
		$job = (new SendWelcomeEmail($user, false))->onQueue('emails');
		dispatch($job);

		//$job = (new SendCreateIdeaEmail($user, $idea))->delay(30)->onQueue('emails');
		$job = (new SendCreateIdeaEmail($user, $idea))->onQueue('emails');
		$this->dispatch($job);

		$receiver = ['name' => $user->name, 'email' => $user->email];
		//$job = (new SendInviteEmail($user, $receiver, $idea))->onQueue('emails');//->delay(30)
		$job = (new SendInviteEmail($user, $receiver, $idea))->onQueue('emails');//->delay(30)
		$this->dispatch($job);

		$receiver = $user;
		//$job = (new SendDidSupportEmail($idea->user, $receiver, $idea))->onQueue('emails');
		$job = (new SendDidSupportEmail($user, $receiver, $idea))->onQueue('emails');
		$this->dispatch($job);

		//$job = (new SendSupportPhaseUpdatesEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
		$job = (new SendSupportPhaseUpdatesEmail($user, $idea))->onQueue('emails');
		$this->dispatch($job);

		//$job = (new SendDesignPhaseUpdatesEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
		$job = (new SendDesignPhaseUpdatesEmail($user, $idea))->onQueue('emails');
		$this->dispatch($job);

		//$job = (new SendProposalPhaseUpdatesEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
		$job = (new SendProposalPhaseUpdatesEmail($user, $idea))->onQueue('emails');
		$this->dispatch($job);



		//$job = (new SendDesignPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
		$job = (new SendDesignPhaseOpenEmail($user, $idea))->onQueue('emails');
		$this->dispatch($job);

		//$job = (new SendProposalPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
		$job = (new SendProposalPhaseOpenEmail($user, $idea))->onQueue('emails');
		$this->dispatch($job);

		//$job = (new SendProposalPhaseCompleteEmail($supporter->user, $idea, $proposal))->delay(5)->onQueue('emails');
		$job = (new SendProposalPhaseCompleteEmail($user, $idea, $proposal))->onQueue('emails');
		$this->dispatch($job);



		//$job = (new SendXMovementRequirementInviteEmail($name, $email, $personal_message, $link, $user))->onQueue('emails');
		$job = (new SendXMovementRequirementInviteEmail($name, $email, $personal_message, $link, $user))->onQueue('emails');
		$this->dispatch($job);
    }
}
