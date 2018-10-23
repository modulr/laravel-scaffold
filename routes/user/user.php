<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'users'], function() {

        Route::view('/users', 'users.index');
        Route::view('/users/create', 'users.create');
        Route::view('/users/{user}/edit', 'users.edit');

        // api
        Route::group(['prefix' => 'api/users'], function() {
            Route::post('/filter', 'UserController@filter');
            Route::get('/{user}', 'UserController@show');
            Route::post('/store', 'UserController@store');
            Route::put('/update/{user}', 'UserController@update');
            Route::delete('/{user}', 'UserController@destroy');
        });
    });
});
