<?php

namespace Deployment\Deployment;

use Illuminate\Support\ServiceProvider;

use DB;

class DeploymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'deployment');

        // $this->publishes([
        //     __DIR__ . '/migrations' => base_path('database/migrations'),
        // ], 'migrations');

        // $this->publishes([
        //     __DIR__ . '/seeds' => base_path('database/seeds'),
        // ], 'seeds');

        // $this->publishes([
        //     __DIR__ . '/factories' => base_path('database/factories'),
        // ], 'factories');

        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/deployment'),
        // ], 'views');

        $this->publishes([
            __DIR__.'/stylus' => base_path('resources/assets/stylus/deployment'),
        ], 'public');

	    // $this->publishes([
	    //     __DIR__.'/config/custom-pages.php' => config_path('custom-pages.php')
	    // ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('Deployment\Deployment\PageController');
    }

}
