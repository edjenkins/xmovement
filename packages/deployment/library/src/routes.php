<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('competition', 'deployment\deployment\PageController@competition');

});
