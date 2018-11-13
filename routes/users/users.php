<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Users'], function() {
        // views
        Route::group(['prefix' => 'users'], function() {
            Route::view('/', 'users.index')->middleware('permission:read-users');
            Route::view('/create', 'users.create')->middleware('permission:create-users');
            Route::view('/{user}/edit', 'users.edit')->middleware('permission:update-users');
        });

        // api
        Route::group(['prefix' => 'api/users'], function() {
            Route::get('/getUserRoles/{user}', 'UserController@getUserRoles');
            Route::get('/count', 'UserController@count');
            Route::post('/filter', 'UserController@filter')->middleware('permission:read-users');

            Route::get('/{user}', 'UserController@show')->middleware('permission:read-users');
            Route::post('/store', 'UserController@store')->middleware('permission:create-users');
            Route::put('/update/{user}', 'UserController@update')->middleware('permission:update-users');
            Route::delete('/{user}', 'UserController@destroy')->middleware('permission:delete-users');
        });
    });
});
