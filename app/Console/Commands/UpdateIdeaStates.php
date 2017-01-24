<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Console\Command;

use App\Jobs\SendDesignPhaseOpenEmail;
use App\Jobs\SendProposalPhaseOpenEmail;
use App\Jobs\SendProposalPhaseCompleteEmail;
use App\Jobs\SendProposalPhaseFailedEmail;

use Carbon\Carbon;
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

		foreach ($ideas as $index => $idea)
		{
			// Check state

			$now = Carbon::now();

			$support_start = $idea->timescales('support', 'start');
			$support_end = $idea->timescales('support', 'end');

			$design_start = $idea->timescales('design', 'start');
			$design_end = $idea->timescales('design', 'end');

			$proposal_start = $idea->timescales('proposal', 'start');
			$proposal_end = $idea->timescales('proposal', 'end');

			$tender_start = $idea->timescales('tender', 'start');
			$tender_end = $idea->timescales('tender', 'end');

			/* Update states */

			// Support state

			if ((!$now->between($support_start, $support_end)) && ($idea->support_state == 'open'))
			{
				$idea->support_state = ($now->gt($support_end)) ? 'locked' : 'closed';
			}
			else if (($idea->support_state != 'open') && ($now->between($support_start, $support_end)))
			{
				$idea->support_state = 'open';
			}

			// Design state

			if ((!$now->between($design_start, $design_end)) && ($idea->design_state == 'open'))
			{
				$idea->design_state = ($now->gt($design_end)) ? 'locked' : 'closed';
			}
			else if (($idea->design_state != 'open') && ($now->between($design_start, $design_end)))
			{
				$idea->design_state = 'open';
				// Send design phase open email
				foreach ($idea->get_supporters() as $index => $supporter)
				{
					$job = (new SendDesignPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
					$this->dispatch($job);
				}
			}

			// Proposal state

			if ((!$now->between($proposal_start, $proposal_end)) && ($idea->proposal_state == 'open'))
			{
				$idea->proposal_state = ($now->gt($proposal_end)) ? 'locked' : 'closed';

				if ($idea->proposal_state == 'locked') {

					// Lock all states
					$idea->support_state = 'locked';
					$idea->design_state = 'locked';

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
			else if (($idea->proposal_state != 'open') && ($now->between($proposal_start, $proposal_end)))
			{
				$idea->proposal_state = 'open';
				// Send proposal phase open email
				foreach ($idea->get_supporters() as $index => $supporter)
				{
					$job = (new SendProposalPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
					$this->dispatch($job);
				}
			}

			// Tender state

			if ($progression_type == 'fixed')
			{
				if ((!$now->between($tender_start, $tender_end)) && ($idea->tender_state == 'open'))
				{
					$idea->tender_state = ($now->gt($tender_end)) ? 'locked' : 'closed';
				}
				else if (($idea->tender_state != 'open') && ($now->between($tender_start, $tender_end)))
				{
					$idea->tender_state = 'open';

					// TODO: Send tender phase open email
				}
			}
			else
			{
				if ((!$now->gt($tender_start)) && ($idea->tender_state == 'open'))
				{
					$idea->tender_state = ($now->gt($tender_start)) ? 'locked' : 'closed';
				}
				else if (($idea->tender_state != 'open') && ($now->gt($tender_start)))
				{
					$idea->tender_state = 'open';

					// TODO: Send tender phase open email
				}
			}

			// Update the idea
			$idea->save();

		}
	}
}
