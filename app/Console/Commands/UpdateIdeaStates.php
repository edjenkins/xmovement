<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Console\Command;

use App\Jobs\SendSupportPhaseFailedEmail;
use App\Jobs\SendDesignPhaseOpenEmail;
use App\Jobs\SendProposalPhaseOpenEmail;
use App\Jobs\SendProposalPhaseCompleteEmail;
use App\Jobs\SendProposalPhaseFailedEmail;

use Carbon\Carbon;
use App\CommentTarget;
use App\Idea;
use DynamicConfig;
use Log;

class UpdateIdeaStates extends Command
{
	use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-idea-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the states of ideas';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$progression_type = DynamicConfig::fetchConfig('PROGRESSION_TYPE', 'fixed');

		Log::info('Updating idea states for progression type - ' . $progression_type);

		$ideas = Idea::all();

		/* Update states */
		foreach ($ideas as $index => $idea)
		{
			// Support state
			if ($idea->support_state != $idea->support_state())
			{
				$idea->support_state = $idea->support_state();

				if ($idea->support_state == 'failed')
				{
					// Idea isn't going to progress (lack of support)

					// Send idea failed email
					foreach ($idea->get_supporters() as $index => $supporter)
					{
						$job = (new SendSupportPhaseFailedEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
						$this->dispatch($job);
					}
				}
			}

			// Design state
			if ($idea->design_state != $idea->design_state())
			{
				$idea->design_state = $idea->design_state();

				if ($idea->design_state == 'open')
				{
					// Lock/Unlock discussion design tasks
					CommentTarget::where('idea_id', $idea->id)->where('target_type', 'DesignTask')->update(['locked' => ($idea->design_state != 'open')]);

					// Send design phase open email
					foreach ($idea->get_supporters() as $index => $supporter)
					{
						$job = (new SendDesignPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
						$this->dispatch($job);
					}
				}
			}

			// Proposal state (Plan)
			if ($idea->proposal_state != $idea->proposal_state())
			{
				$idea->proposal_state = $idea->proposal_state();

				if ($idea->proposal_state == 'open')
				{
					// Send proposal phase open email
					foreach ($idea->get_supporters() as $index => $supporter)
					{
						$job = (new SendProposalPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
						$this->dispatch($job);
					}
				}

				if ($idea->proposal_state == 'locked') {

					// Get winning proposal
					$proposal = $idea->winning_proposal();

					// Send proposal phase complete email
					foreach ($idea->get_supporters() as $index => $supporter)
					{
						if ($proposal)
						{
							// There was a winning proposal, let people know
							$job = (new SendProposalPhaseCompleteEmail($supporter->user, $idea, $proposal))->delay(5)->onQueue('emails');
							$this->dispatch($job);
						}
						else
						{
							// No winning proposal (send email to explain)
							$job = (new SendProposalPhaseFailedEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
							$this->dispatch($job);
						}
					}
				}
			}

			// Tender state (Plan)

			if ($idea->tender_state != $idea->tender_state())
			{
				$idea->tender_state = $idea->tender_state();

				if ($idea->tender_state != 'open')
				{
					// TODO: Send tender phase open email
				}
			}










			if (!DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false))
			{
				$idea->tender_state = 'closed';
			}

			// Update the idea
			$idea->save();

		}
	}
}
