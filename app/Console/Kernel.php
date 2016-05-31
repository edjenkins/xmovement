<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Scheduler;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command scheduler.
     *
     * @param  \Illuminate\Console\Scheduling\Scheduler  $scheduler
     * @return void
     */
    protected function scheduler(Scheduler $scheduler)
    {
        // $scheduler->command('inspire')
        //          ->hourly();
    }
}
