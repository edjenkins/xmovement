<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('design/poll/{module_id}', 'xmovement\poll\PollController@view');
});