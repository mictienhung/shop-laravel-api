<?php

// Route::group(['middleware' => ['cors']], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
    });
    
    Route::group(['middleware' => ['jwt-auth']], function () {
        Route::group(['namespace' => 'Auth'], function () {
            Route::get('getAuthUser', 'AuthController@getAuthUser');
            Route::post('changePassword', 'AuthController@changePassword');
        });
    });
// });
