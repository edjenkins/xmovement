<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

use App\Jobs\PrePopulateDesignTasks;

use Carbon\Carbon;
use App\Idea;
use Log;

class PopulateDesignTasks extends Command
{
	use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate-design-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates the design tasks for a given idea';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$idea_id = $this->ask('Please enter the id for the idea you wish to populate');

		$idea = Idea::where('id', $idea_id)->first();

		if ($idea)
		{
			$this->info('Populating design tasks for idea - ' . $idea->name);

			$job = (new PrePopulateDesignTasks($idea))->delay(5);
			$this->dispatch($job);
		}
		else
		{
			$this->info('No idea found for given id - ' . $idea_id);
		}
    }
}
