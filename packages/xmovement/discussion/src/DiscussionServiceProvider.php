<?php

namespace XMovement\Discussion;

use Illuminate\Support\ServiceProvider;

class DiscussionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'discussion');

        $this->publishes([
            __DIR__ . '/migrations' => base_path('database/migrations'),
        ], 'migrations');

        // $this->publishes([
        //     __DIR__ . '/seeds' => base_path('database/seeds'),
        // ], 'seeds');

        // $this->publishes([
        //     __DIR__ . '/factories' => base_path('database/factories'),
        // ], 'factories');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/xmovement/discussion'),
        ], 'views');

        $this->publishes([
            __DIR__.'/stylus' => base_path('resources/assets/stylus/xmovement/discussion'),
        ], 'public');

        $this->publishes([
            __DIR__.'/js' => base_path('public/js/xmovement/discussion'),
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
        $this->app->make('XMovement\Discussion\DiscussionController');
    }

}
