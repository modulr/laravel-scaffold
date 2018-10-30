<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'modules'], function() {
        // api
        Route::group(['prefix' => 'api/modules'], function() {
            Route::get('/getModules', 'ModuleController@getModules');
        });
    });
});
