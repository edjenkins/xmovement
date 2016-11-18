<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Mail\Events\MessageSending' => [
			'App\Listeners\LogSentEmail',
		],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

		Event::listen('generic.event',function($client_data){
		    return BrainSocket::message('generic.event',array('message'=>'A message from a generic event fired in Laravel!'));
		});

		Event::listen('app.success',function($client_data){
		    return BrainSocket::success(array('There was a Laravel App Success Event!'));
		});

		Event::listen('app.error',function($client_data){
		    return BrainSocket::error(array('There was a Laravel App Error!'));
		});
    }
}
