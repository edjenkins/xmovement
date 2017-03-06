<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('guidelines', 'deployment\deployment\PageController@guidelines');
    Route::get('blog', 'deployment\deployment\PageController@blog');

});
