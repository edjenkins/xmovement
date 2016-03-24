<?php

Route::group(['middleware' => ['web']], function () {
    
	// View poll
    Route::get('design/poll/{module}', 'xmovement\poll\PollController@view');


    Route::post('design/poll/store', 'xmovement\poll\PollController@store');
    Route::post('design/poll/update', 'xmovement\poll\PollController@update');

    // Vote on poll option
    Route::post('/vote/poll', 'xmovement\poll\PollController@vote');

});