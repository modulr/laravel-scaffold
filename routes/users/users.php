<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'users'], function() {
        // views
        Route::group(['prefix' => 'users'], function() {
            Route::view('/', 'users.index');
            Route::view('/create', 'users.create');
            Route::view('/{user}/edit', 'users.edit');
        });

        // api
        Route::group(['prefix' => 'api/users'], function() {
            Route::get('/count', 'UserController@count');
            Route::post('/filter', 'UserController@filter');
            Route::get('/{user}', 'UserController@show');
            Route::post('/store', 'UserController@store');
            Route::put('/update/{user}', 'UserController@update');
            Route::delete('/{user}', 'UserController@destroy');
        });
    });
});
