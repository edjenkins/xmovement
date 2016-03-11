<?php

namespace XMovement\Poll;

use Illuminate\Support\ServiceProvider;

class PollServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'poll');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/xmovement/poll'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('XMovement\Poll\PollController');
        $this->app->make('XMovement\Poll\Poll');
    }

}
