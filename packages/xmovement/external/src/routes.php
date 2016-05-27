<?php

Route::group(['middleware' => ['web']], function () {

	// View external
    Route::get('design/external/{module}', 'xmovement\external\ExternalController@view');

    Route::post('design/external/store', 'xmovement\external\ExternalController@store');
    Route::post('design/external/update', 'xmovement\external\ExternalController@update');

});
