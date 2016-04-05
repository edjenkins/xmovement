<?php

Route::group(['middleware' => ['web']], function () {
    
	// View requirement
    Route::get('design/requirement/{module}', 'xmovement\requirement\RequirementController@view');

    // Save requirement module
    Route::post('design/requirement/store', 'xmovement\requirement\RequirementController@store');

    // Submit requirement
    Route::post('design/requirement/submit', 'xmovement\requirement\RequirementController@submit');

    // Withdraw requirement
    Route::post('design/requirement/withdraw', 'xmovement\requirement\RequirementController@withdraw');

});