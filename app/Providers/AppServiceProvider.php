<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\Logging\Log;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
		    'idea' => \App\Idea::class,
			'tender' => \App\Tender::class,
		]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->alias('bugsnag.logger', Log::class);
		$this->app->alias('bugsnag.logger', LoggerInterface::class);
    }
}
