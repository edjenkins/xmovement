<?php

Route::group(['middleware' => ['web']], function () {
    
	// View poll
    Route::get('design/poll/{module}', 'xmovement\poll\PollController@view');

    // Vote on poll option
    Route::post('/vote/poll', 'xmovement\poll\PollController@vote');
    
});