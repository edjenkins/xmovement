<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('design/poll/{module}', 'xmovement\poll\PollController@view');
});