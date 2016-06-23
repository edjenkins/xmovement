<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Jobs\SendDesignPhaseOpenEmail;
use App\Jobs\SendProposalPhaseOpenEmail;

use Carbon\Carbon;
use App\Idea;
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
		Log::info('Updating idea states');

		$ideas = Idea::all();

		foreach ($ideas as $index => $idea)
		{
			// Check state

			$now = Carbon::now();

			$created = Carbon::parse($idea->created_at);

			$support_start = $idea->timescales('support', 'start');
			$support_duration = $idea->timescales('support', 'duration');
			$support_end = $idea->timescales('support', 'end');

			$design_start = $idea->timescales('design', 'start');
			$design_duration = $idea->timescales('design', 'duration');
			$design_end = $idea->timescales('design', 'end');

			$proposal_start = $idea->timescales('proposal', 'start');
			$proposal_duration = $idea->timescales('proposal', 'duration');
			$proposal_end = $idea->timescales('proposal', 'end');


			/* Update states */

			// Support state

			if ((!$now->between($support_start, $support_end)) && ($idea->support_state == 'open'))
			{
				$idea->support_state = ($now->lt($support_start)) ? 'closed';
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
					$job = (new SendDesignPhaseOpenEmail($supporter->user, $idea, true))->delay(5)->onQueue('emails');
					$this->dispatch($job);
				}
			}

			// Proposal state

			if ((!$now->between($proposal_start, $proposal_end)) && ($idea->proposal_state == 'open'))
			{
				$idea->proposal_state = ($now->gt($proposal_end)) ? 'locked' : 'closed';
			}
			else if (($idea->proposal_state != 'open') && ($now->between($proposal_start, $proposal_end)))
			{
				$idea->proposal_state = 'open';
				// Send proposal phase open email
				foreach ($idea->get_supporters() as $index => $supporter)
				{
					$job = (new SendProposalPhaseOpenEmail($supporter->user, $idea, true))->delay(5)->onQueue('emails');
					$this->dispatch($job);
				}
			}

			// Update the idea
			$idea->save();

		}
    }
}
