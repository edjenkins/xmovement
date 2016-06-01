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

    // Propose routes
    Route::get('/propose/{idea}', 'ProposeController@index');
		Route::get('/propose/view/{proposal}', 'ProposeController@view');
    Route::get('/propose/add/{idea}', 'ProposeController@add');
    // Route::delete('/propose/destroy/{proposal}', 'ProposeController@destroyTask');


    // Vote routes (Design task)
    Route::post('/vote/design_task', 'DesignController@vote');

    // API routes
    Route::post('/api/support', 'IdeaController@support');

    // File upload
    Route::post('/upload', 'UploadController@upload');

		Route::get('/test', function()
		{
		    $img = Image::make('http://xm.local/uploads/4b0e7aec952b1a1124dd85fc1105f90fba5d9c7e.jpeg')->fit(800, 360);

		    return $img->response('jpg');
		});

});
