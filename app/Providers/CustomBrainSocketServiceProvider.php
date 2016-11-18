<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use CustomBrainSocket\BrainSocket;
use App;

class CustomBrainSocketServiceProvider extends ServiceProvider
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
		$this->app['command.brainsocket.start'] = $this->app->share(function($app)
		{
			return new BrainSocket();
		});
    }
}
