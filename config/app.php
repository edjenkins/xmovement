<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

		// Image Manipulation
		Intervention\Image\ImageServiceProvider::class,

		// Translations
		App\Providers\TranslateMateProvider::class,

		// Dynamic Config
		App\Providers\DynamicConfigProvider::class,

        /*
         * Custom Service Providers...
         */

		BrainSocket\BrainSocketServiceProvider::class,
		App\Providers\CustomBrainSocketServiceProvider::class,

		// Auth
        Laravel\Socialite\SocialiteServiceProvider::class,
		Artesaos\LinkedIn\LinkedinServiceProvider::class,

		Torann\LaravelMetaTags\MetaTagsServiceProvider::class,
		Bugsnag\BugsnagLaravel\BugsnagServiceProvider::class,

		App\Providers\ResourceImageProvider::class,

		// Deployment Service Provider
		Deployment\Deployment\DeploymentServiceProvider::class,

        // XMovement Design Modules
        XMovement\Poll\PollServiceProvider::class,
        XMovement\Discussion\DiscussionServiceProvider::class,
        XMovement\Requirement\RequirementServiceProvider::class,
        XMovement\Contribution\ContributionServiceProvider::class,
        XMovement\External\ExternalServiceProvider::class,
        XMovement\Scheduler\SchedulerServiceProvider::class,

		Propaganistas\LaravelPhone\LaravelPhoneServiceProvider::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
        'Auth'      => Illuminate\Support\Facades\Auth::class,
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
        // 'Config'    => Illuminate\Support\Facades\Config::class,
		'Config'    => Larapack\ConfigWriter\Facade::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Input'     => Illuminate\Support\Facades\Input::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,

		// Auth
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
		'LinkedIn'  => \Artesaos\LinkedIn\Facades\LinkedIn::class,

		'MetaTag'   => Torann\LaravelMetaTags\Facades\MetaTag::class,
		'Bugsnag' => Bugsnag\BugsnagLaravel\Facades\Bugsnag::class,

		'BrainSocket'     => BrainSocket\BrainSocketFacade::class,
		'CustomBrainSocket'     => CustomBrainSocket\Facades\BrainSocket::class,

		'TranslateMate'     => TranslateMate\Facades\TranslateMate::class,
		'DynamicConfig'     => DynamicConfig\Facades\DynamicConfig::class,

		'Image'     => Intervention\Image\Facades\Image::class,
		'ResourceImage' => ResourceImage\Facades\ResourceImage::class,

		// Deployment Service Provider
		'DeploymentServiceProvider' => Deployment\Deployment\DeploymentServiceProvider::class,

        'PollServiceProvider' => XMovement\Poll\PollServiceProvider::class,
        'Poll' => XMovement\Poll\Poll::class,

        'DiscussionServiceProvider' => XMovement\Discussion\DiscussionServiceProvider::class,
        'Discussion' => XMovement\Discussion\Discussion::class,

        'RequirementServiceProvider' => XMovement\Requirement\RequirementServiceProvider::class,
        'Requirement' => XMovement\Requirement\Requirement::class,

        'ContributionServiceProvider' => XMovement\Contribution\ContributionServiceProvider::class,
        'Contribution' => XMovement\Contribution\Contribution::class,

        'ExternalServiceProvider' => XMovement\External\ExternalServiceProvider::class,
        'External' => XMovement\External\External::class,

        'SchedulerServiceProvider' => XMovement\Scheduler\SchedulerServiceProvider::class,
        'Scheduler' => XMovement\Scheduler\Scheduler::class

    ],

];
