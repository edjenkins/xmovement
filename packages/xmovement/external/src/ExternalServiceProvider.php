<?php

namespace XMovement\External;

use Illuminate\Support\ServiceProvider;

class ExternalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'external');

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
            __DIR__.'/views' => base_path('resources/views/xmovement/external'),
        ], 'views');

        $this->publishes([
            __DIR__.'/stylus' => base_path('resources/assets/stylus/xmovement/external'),
        ], 'public');

        $this->publishes([
            __DIR__.'/js' => base_path('public/js/xmovement/external'),
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
        $this->app->make('XMovement\External\ExternalController');
    }

}
