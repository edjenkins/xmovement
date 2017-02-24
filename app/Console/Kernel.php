<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
		\App\Console\Commands\PopulateDesignTasks::class,
        \App\Console\Commands\UpdateIdeaStates::class,
        \App\Console\Commands\SupportPhaseUpdates::class,
        \App\Console\Commands\DesignPhaseUpdates::class,
        \App\Console\Commands\ProposalPhaseUpdates::class,
		\App\Console\Commands\ImportTranslations::class,
		\App\Console\Commands\ExportTranslations::class
    ];

	protected function schedule(Schedule $schedule)
	{
		// Update the states of ideas
		$schedule->command('update-idea-states')->everyTenMinutes()->withoutOverlapping();

		// Send support phase update emails (at 11am every 3 days)
		$schedule->command('support-phase-updates')->cron('0 11 */3 * *')->withoutOverlapping();

		// Send design phase update emails (at 11am every 3 days)
		$schedule->command('design-phase-updates')->cron('0 11 */3 * *')->withoutOverlapping();

		// Send proposal phase update emails (at 11am every 3 days)
		$schedule->command('proposal-phase-updates')->cron('0 11 */3 * *')->withoutOverlapping();
    }
}
