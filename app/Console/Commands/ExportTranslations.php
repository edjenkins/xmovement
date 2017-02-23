<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;
use Illuminate\Queue\SerializesModels;

use App\Jobs\ExportAllTranslations;

use Carbon\Carbon;
use App\Idea;
use Log;

class ExportTranslations extends Command
{
	use SerializesModels;
	use DispatchesJobs;

	protected $manager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:exportall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports all of the translations in the database into application readable files';

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
		$this->info('Exporting translations...');

		$this->manager->exportAllTranslations();
    }
}
