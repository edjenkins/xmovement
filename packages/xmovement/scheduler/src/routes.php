<?php

Route::group(['middleware' => ['web']], function () {

	// View scheduler
    Route::get('design/scheduler/{module}', 'xmovement\scheduler\SchedulerController@view');


    Route::post('design/scheduler/store', 'xmovement\scheduler\SchedulerController@store');
    Route::post('design/scheduler/update', 'xmovement\scheduler\SchedulerController@update');

    // Submit scheduler option
    Route::post('design/scheduler/option/submit', 'xmovement\scheduler\SchedulerController@submitOption');

    // Vote on scheduler option
    Route::post('/vote/scheduler', 'xmovement\scheduler\SchedulerController@vote');

});
