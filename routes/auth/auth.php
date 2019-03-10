<?php

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });

    Route::group([
        'middleware' => ['auth:api','role_or_permission:super-admin' ]
    ], function() {
        Route::delete('destroy/{id}', 'AuthController@destroy');
    });
});
