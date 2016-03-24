<?php

Route::group(['middleware' => ['web']], function () {
    
	// View discussion
    Route::get('design/discussion/{module}', 'xmovement\discussion\DiscussionController@view');

    Route::post('design/discussion/store', 'xmovement\discussion\DiscussionController@store');
    Route::post('design/discussion/update', 'xmovement\discussion\DiscussionController@update');

});