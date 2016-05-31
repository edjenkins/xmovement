<?php

Route::group(['middleware' => ['web']], function () {

	// View schedule
    Route::get('design/schedule/{module}', 'xmovement\schedule\ScheduleController@view');

    Route::post('design/schedule/store', 'xmovement\schedule\ScheduleController@store');
    Route::post('design/schedule/update', 'xmovement\schedule\ScheduleController@update');

});
