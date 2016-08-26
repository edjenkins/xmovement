<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'PageController@home');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

	$middleware = [];

	if (Config::get('app.debug'))
	{
		array_push($middleware, ['middleware' => 'clearcache']);
	}

    // Auth routes
	Route::auth();

    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
    // Route::get('auth/linkedin', 'Auth\AuthController@redirectToProvider');
    // Route::get('auth/linkedin/callback', 'Auth\AuthController@handleProviderCallback');

    // User routes
    Route::get('/profile/{user?}', 'UserController@profile');
    Route::get('/details', 'UserController@showDetails');
    Route::post('/details', 'UserController@addDetails');

    // Page routes
    Route::get('/', 'PageController@home');
    Route::get('/home', 'PageController@home');
    Route::get('/about', 'PageController@about');
    Route::get('/contact', 'PageController@contact');
    Route::get('/terms', 'PageController@terms');

	// Admin routes
	Route::get('/admin/email/test', 'AdminController@emailTest');

	// Translation routes
    Route::get('/translate', 'TranslationController@index');

	// Analytics routes
    Route::get('/analytics', 'AnalyticsController@index');

    // Inspiration routes
    Route::get('/inspiration', 'InspirationController@index');

    // Idea routes
    Route::get('/explore', 'IdeaController@index');
    Route::get('/idea/create', 'IdeaController@add');
    Route::get('/idea/invite/{idea}', 'IdeaController@invite');
    Route::post('/idea/invites/send', 'IdeaController@sendInvites');
    Route::get('/idea/edit/{idea}', 'IdeaController@edit');
    Route::post('/idea/update', 'IdeaController@update');
    Route::post('/idea/store', 'IdeaController@store');
    Route::get('/idea/{idea}/{slug?}', 'IdeaController@view');
    Route::post('/idea/open_design_phase/{idea}', 'IdeaController@openDesignPhase');
    Route::delete('/idea/{idea}', 'IdeaController@destroy');

    // Design routes
    Route::get('/design/{idea}', 'DesignController@dashboard');
    Route::get('/design/add/{idea}', 'DesignController@add');
    Route::delete('/design/task/destroy/{design_task}', 'DesignController@destroyTask');

    // Propose routes
    Route::get('/propose/{idea}', 'ProposeController@index');
	Route::get('/propose/view/{proposal}', 'ProposeController@view');
    Route::get('/propose/add/{idea}', 'ProposeController@add');

	Route::get('/propose/workflow/tasks/{idea}', 'ProposeController@tasks');
	Route::post('/propose/workflow/tasks/{idea}', 'ProposeController@tasks');
	Route::get('/propose/task/{design_task}', 'ProposeController@task');
	Route::post('/propose/previous', 'ProposeController@previous');
	Route::post('/propose/next', 'ProposeController@next');
	Route::get('/propose/review/{idea}', 'ProposeController@review');
	Route::post('/propose/submit', 'ProposeController@submit');
    Route::delete('/propose/destroy/{proposal}', 'ProposeController@destroy');

    // Vote routes
	Route::post('/vote/design_task', 'DesignController@vote'); // Design task
    Route::post('/vote/proposal', 'ProposeController@vote'); // Proposal
	Route::post('/vote/comment', 'CommentController@vote'); // Comment

    // Contact routes
	Route::post('/contact/send', 'ContactController@send');

    // API routes

		// Inspiration routes
		Route::get('/api/inspirations', 'InspirationController@api_index');
		Route::get('/api/inspiration', 'InspirationController@api_view');
		Route::post('/api/inspiration/add', 'InspirationController@add');
		Route::post('/api/inspiration/favourite', 'InspirationController@favourite');
		Route::post('/api/inspiration/delete', 'InspirationController@destroy');

		// Idea routes
		Route::get('/api/ideas', 'IdeaController@api_index');

		// Action routes
		Route::post('/api/action/log', 'ActionController@log');

		// Support routes
	    Route::post('/api/support', 'IdeaController@support');

		// Updates routes
	    Route::post('/api/update/add', 'UpdatesController@add');
	    Route::delete('/api/update/destroy', 'UpdatesController@destroy');

		// Message routes
		Route::post('/api/messages/send', 'MessagesController@send');

		// Discussion routes
		Route::get('/api/comment/view', 'CommentController@view');
	    Route::delete('/api/comment/destroy', 'CommentController@destroy');

		// Report routes
		Route::post('/api/report', 'ReportController@add');

		// Translation routes
		Route::get('/api/translations', 'TranslationController@api_index');
		Route::get('/api/translations/find', 'TranslationController@api_find');
		Route::post('/api/translation/update', 'TranslationController@api_update');
		Route::get('/api/translations/export', 'TranslationController@api_export');

		// Analytics routes
		Route::get('api/analytics/overview', 'AnalyticsController@api_overview');
		Route::get('api/analytics/users', 'AnalyticsController@api_users');
		Route::get('api/analytics/ideas', 'AnalyticsController@api_ideas');

    // File upload
    Route::post('/upload', 'UploadController@upload');

	// Dynamic Images
	Route::get('/dynamic/avatar/{size}', function($size)
	{
		$img = Image::canvas(800, 800, '#e1e1e1');

		$img->circle(350, 400, 300, function ($draw) {
				$draw->background('#fff');
		});
		$img->circle(600, 400, 750, function ($draw) {
				$draw->background('#fff');
		});

		$name = Input::get("name");

		if ($name)
		{
			$name = urldecode($name);

			if(preg_match_all('/\b(\w)/',strtoupper($name),$m)) {
			    $name_acronymn = implode('',$m[1]); // $v is now SOQTU
			}

			$img->text($name_acronymn, 600, 600, function($font) {
			    $font->file('fonts/sourcesanspro-bold-webfont.ttf');
			    $font->size(100);
			    $font->color('#e1e1e1');
			    $font->align('right');
			    $font->valign('center');
			});
		}

		return $img->response('jpg');
	});

	Route::get('/dynamic/placeholder/{size}', function($size)
	{
		$img = Image::canvas(800, 800, '#e1e1e1');
		$img->circle(100, 200, 400, function ($draw) {
				$draw->background('#f2f2f2');
		});
		$img->circle(100, 400, 400, function ($draw) {
				$draw->background('#f2f2f2');
		});
		$img->circle(100, 600, 400, function ($draw) {
				$draw->background('#f2f2f2');
		});
		return $img->response('jpg');
	});
});
