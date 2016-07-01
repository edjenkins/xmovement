<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Jobs\SendSupportPhaseUpdatesEmail;

use Carbon\Carbon;
use App\Idea;
use Log;

class SupportPhaseUpdates extends Command
{
	use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support-phase-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send update email for support phase';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		Log::info('Sending support phase updates');

		$ideas = Idea::where('support_state', 'open')->get();

		foreach ($ideas as $index => $idea)
		{
			Log::info('Idea - ' . $idea->id);
			foreach ($idea->get_supporters() as $index => $supporter)
			{
				Log::info('Supporter - ' . $supporter->id);
				$job = (new SendSupportPhaseUpdatesEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
				$this->dispatch($job);
			}
		}
    }
}
