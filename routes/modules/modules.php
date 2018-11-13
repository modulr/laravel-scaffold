<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Modules'], function() {
        // api
        Route::group(['prefix' => 'api/modules'], function() {
            Route::get('/getModulesPermissions', 'ModuleController@getModulesPermissions');
        });
    });
});
