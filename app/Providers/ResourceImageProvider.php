<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ResourceImage\ResourceImage;

class ResourceImageProvider extends ServiceProvider
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
        $this->app->bind('ResourceImage', function () {
            return new ResourceImage;
        });
    }
}
