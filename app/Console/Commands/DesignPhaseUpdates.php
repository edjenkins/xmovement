<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Jobs\SendDesignPhaseUpdatesEmail;

use Carbon\Carbon;
use App\Idea;
use Log;

class DesignPhaseUpdates extends Command
{
	use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'design-phase-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send update email for design phase';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		Log::info('Sending design phase updates');

		$ideas = Idea::where('design_state', 'open');

		foreach ($ideas as $index => $idea)
		{
			foreach ($idea->get_supporters() as $index => $supporter)
			{
				$job = (new SendDesignPhaseUpdatesEmail($supporter->user, $idea, true))->delay(5)->onQueue('emails');
				$this->dispatch($job);
			}
		}
    }
}