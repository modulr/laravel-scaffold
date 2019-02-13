<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Stages'], function() {
        // api
        Route::group(['prefix' => 'api/stages'], function() {
            Route::post('/filter', 'StageController@filter')->middleware('permission:read-stages');
            Route::put('/toggleAuthorized/{stage}', 'StageController@toggleAuthorized')->middleware('permission:update-stages');
            
            Route::get('/{stage}', 'StageController@show')->middleware('permission:read-stages');
            Route::post('/store', 'StageController@store')->middleware('permission:create-stages');
            Route::put('/update/{stage}', 'StageController@update')->middleware('permission:update-stages');
            Route::delete('/{stage}', 'StageController@destroy')->middleware('permission:delete-stages');
        });
    });
});
