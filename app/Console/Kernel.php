<?php
namespace App\Console;

// require 'vendor/autoload.php';

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\Scheduler;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use App\Idea;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function () {

			$ideas = Idea::all();

			foreach ($ideas as $index => $idea)
			{
				// Check state

				$now = Carbon::now();

				$created = Carbon::parse($idea->created_at);

				$support_start = $design_start = $proposal_start = $created->copy();

				$support_end = $design_end = $proposal_end = Carbon::now();

				$idea_duration_in_hours = ($idea->duration * 24);

				if (($idea->design_during_support) && ($idea->proposals_during_design))
				{
					$support_duration = $design_duration = $proposal_duration = $idea_duration_in_hours;

					$support_end = $design_end = $proposal_end = $created->copy()->addHours($idea_duration_in_hours);
				}
				else if ($idea->design_during_support)
				{
					$support_duration = $design_duration = $proposal_duration = ($idea_duration_in_hours / 2);

					$proposal_start = $created->copy()->addHours($support_duration);

					$support_end = $support_start->copy()->addHours($support_duration);
					$design_end = $design_start->copy()->addHours($design_duration);
					$proposal_end = $design_end->copy()->addHours($proposal_duration);
				}
				else if ($idea->proposals_during_design)
				{
					$support_duration = $design_duration = $proposal_duration = ($idea_duration_in_hours / 2);

					$design_start = $proposal_start = $created->copy()->addHours($support_duration);

					$support_end = $support_start->copy()->addHours($support_duration);
					$design_end = $support_end->copy()->addHours($design_duration);
					$proposal_end = $support_end->copy()->addHours($proposal_duration);
				}
				else
				{
					$support_duration = $design_duration = $proposal_duration = ($idea_duration_in_hours / 3);

					$design_start = $support_start->copy()->addHours($support_duration);
					$proposal_start = $design_start->copy()->addHours($design_duration);

					$support_end = $created->copy()->addHours($support_duration);
					$design_end = $support_end->copy()->addHours($design_duration);
					$proposal_end = $design_end->copy()->addHours($proposal_duration);
				}

				// Update states

				if (($idea->support_state != 'open') && ($now->between($support_start, $support_end)))
				{
					$idea->support_state = 'open';
					// Send support phase open email
				}
				if (($idea->design_state != 'open') && ($now->between($design_start, $design_end)))
				{
					$idea->design_state = 'open';
					// Send design phase open email
				}
				if (($idea->proposal_state != 'open') && ($now->between($proposal_start, $proposal_end)))
				{
					$idea->proposal_state = 'open';
					// Send proposal phase open email
				}

				// Update the idea
				$idea->save();

			}

        })->everyMinute();
    }

    /**
     * Define the application's command scheduler.
     *
     * @param  \Illuminate\Console\Scheduling\Scheduler  $scheduler
     * @return void
     */
    protected function scheduler(Scheduler $scheduler)
    {
	}
}
