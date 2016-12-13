<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DynamicConfig\DynamicConfig;

class DynamicConfigProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DynamicConfig', function () {
            return new DynamicConfig;
        });
    }
}
