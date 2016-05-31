<?php

namespace XMovement\Scheduler;

use Illuminate\Support\ServiceProvider;

class SchedulerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'scheduler');

        $this->publishes([
            __DIR__ . '/migrations' => base_path('database/migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/seeds' => base_path('database/seeds'),
        ], 'seeds');

        $this->publishes([
            __DIR__ . '/factories' => base_path('database/factories'),
        ], 'factories');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/xmovement/scheduler'),
        ], 'views');

        $this->publishes([
            __DIR__.'/stylus' => base_path('resources/assets/stylus/xmovement/scheduler'),
        ], 'public');

        $this->publishes([
            __DIR__.'/js' => base_path('public/js/xmovement/scheduler'),
        ], 'public');

        $this->publishes([
            __DIR__.'/lang/en' => base_path('resources/lang/en'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('XMovement\Scheduler\SchedulerController');
    }

}
