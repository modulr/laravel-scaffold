<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Roles'], function() {

        // api
        Route::group(['prefix' => 'api/permissions'], function() {
            Route::get('/count', 'PermissionController@count');
        });
    });
});
