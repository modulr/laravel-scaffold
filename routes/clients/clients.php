<?php
Route::group(['namespace' => 'Clients'], function() {
    Route::middleware('auth')->group(function () {
        // views
        Route::group(['prefix' => 'clients'], function() {
            Route::view('/', 'clients.index')->middleware('permission:read-clients');
            Route::view('/create', 'clients.create')->middleware('permission:create-clients');
            Route::view('/{user}/edit', 'clients.edit')->middleware('permission:update-clients');
        });

        // api
        Route::group(['prefix' => 'api/clients'], function() {
            Route::post('/filter', 'ClientController@filter')->middleware('permission:read-clients');
            Route::post('/uploadAvatar', 'ClientController@uploadAvatar')->middleware('permission:update-clients');

            Route::get('/{user}', 'ClientController@show')->middleware('permission:read-clients');
            Route::post('/store', 'ClientController@store')->middleware('permission:create-clients');
            Route::put('/update/{user}', 'ClientController@update')->middleware('permission:update-clients');
            Route::delete('/{user}', 'ClientController@destroy')->middleware('permission:delete-clients');
        });
    });
});
