<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Console\Command;

use App\Jobs\SendProposalPhaseUpdatesEmail;

use Carbon\Carbon;
use App\Idea;
use Log;

class ProposalPhaseUpdates extends Command
{
	use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proposal-phase-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send update email for proposal phase';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		Log::info('Sending proposal phase updates');

		$ideas = Idea::where('proposal_state', 'open');

		foreach ($ideas as $index => $idea)
		{
			foreach ($idea->get_supporters() as $index => $supporter)
			{
				$job = (new SendProposalPhaseUpdatesEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
				$this->dispatch($job);
			}
		}
    }
}
