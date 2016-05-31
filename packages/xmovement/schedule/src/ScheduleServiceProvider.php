<?php

namespace XMovement\Schedule;

use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'schedule');

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
            __DIR__.'/views' => base_path('resources/views/xmovement/schedule'),
        ], 'views');

        $this->publishes([
            __DIR__.'/stylus' => base_path('resources/assets/stylus/xmovement/schedule'),
        ], 'public');

        $this->publishes([
            __DIR__.'/js' => base_path('public/js/xmovement/schedule'),
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
        $this->app->make('XMovement\Schedule\ScheduleController');
    }

}
