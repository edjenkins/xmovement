<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\Idea;
use Log;

class ImportTranslations extends Command
{
	use SerializesModels;
	use DispatchesJobs;

	protected $manager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all of the translations from the database';

	public function __construct(\TranslateMate\Manager $manager)
	{
		parent::__construct();

		$this->manager = $manager;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->info('Importing translations...');

		$this->manager->importTranslations(true);
    }
}
