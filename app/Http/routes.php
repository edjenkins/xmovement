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

    // Auth routes
	Route::auth();

    Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

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

    // Idea routes
    Route::get('/explore', 'IdeaController@index');
    Route::get('/idea/create', 'IdeaController@add');
    Route::get('/idea/invite/{idea}', 'IdeaController@invite');
    Route::post('/idea/invites/send', 'IdeaController@sendInvites');
    Route::get('/idea/edit/{idea}', 'IdeaController@edit');
    Route::post('/idea/update', 'IdeaController@update');
    Route::post('/idea/store', 'IdeaController@store');
    Route::get('/idea/{idea}', 'IdeaController@view');
    Route::delete('/idea/{idea}', 'IdeaController@destroy');

    // Design routes
    Route::get('/design/{idea}', 'DesignController@dashboard');
    Route::get('/design/add/{idea}', 'DesignController@add');
    Route::delete('/design/task/destroy/{design_task}', 'DesignController@destroyTask');


    // Vote routes (Design task)
    Route::post('/vote/design_task', 'DesignController@vote');

    // API routes
    Route::post('/api/support', 'IdeaController@support');

    // File upload
    Route::post('/upload', 'UploadController@upload');

		// Images
		Route::get('/uploads/images/{size}/{type}', function($size, $type)
		{
			$img = Image::canvas(800, 800, '#e1e1e1');

			switch ($type) {
				case 'placeholder':
					$img->circle(100, 200, 400, function ($draw) {
							$draw->background('#f2f2f2');
					});
					$img->circle(100, 400, 400, function ($draw) {
							$draw->background('#f2f2f2');
					});
					$img->circle(100, 600, 400, function ($draw) {
							$draw->background('#f2f2f2');
					});
					break;

				case 'avatar':
					$img->circle(350, 400, 300, function ($draw) {
							$draw->background('#f2f2f2');
					});
					$img->circle(600, 400, 750, function ($draw) {
							$draw->background('#f2f2f2');
					});
					break;
			}

			return $img->response('jpg');
		});

		Route::get('/uploads/images/{size}/', function($size)
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
