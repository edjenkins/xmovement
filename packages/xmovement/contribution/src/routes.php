<?php

Route::group(['middleware' => ['web']], function () {
    
	// View contribution
    Route::get('design/contribution/{module}', 'xmovement\contribution\ContributionController@view');


    Route::post('design/contribution/store', 'xmovement\contribution\ContributionController@store');
    Route::post('design/contribution/update', 'xmovement\contribution\ContributionController@update');

    // Submit contribution submission
    Route::post('design/contribution/submission/submit', 'xmovement\contribution\ContributionController@submitSubmission');

    // Vote on contribution submission
    Route::post('/vote/contribution', 'xmovement\contribution\ContributionController@vote');

});