<?php

Route::group(['middleware' => ['web']], function () {
    
	// View contribution
    Route::get('design/contribution/{module}', 'xmovement\contribution\ContributionController@view');


    Route::post('design/contribution/store', 'xmovement\contribution\ContributionController@store');
    Route::post('design/contribution/update', 'xmovement\contribution\ContributionController@update');

    // Submit contribution option
    Route::post('design/contribution/option/submit', 'xmovement\contribution\ContributionController@submitOption');

    // Vote on contribution option
    Route::post('/vote/contribution', 'xmovement\contribution\ContributionController@vote');

});