<?php

namespace XMovement\Contribution;

use Illuminate\Support\ServiceProvider;

class ContributionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'contribution');

        $this->publishes([
            __DIR__ . '/policies' => base_path('app/Policies'),
        ], 'policies');

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
            __DIR__.'/views' => base_path('resources/views/xmovement/contribution'),
        ], 'views');

        $this->publishes([
            __DIR__.'/stylus' => base_path('resources/assets/stylus/xmovement/contribution'),
        ], 'public');

        $this->publishes([
            __DIR__.'/js' => base_path('public/js/xmovement/contribution'),
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
        $this->app->make('XMovement\Contribution\ContributionController');
        $this->app->make('XMovement\Contribution\Contribution');
    }

}
