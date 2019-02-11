<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Files'], function() {
        // api
        Route::group(['prefix' => 'api/files'], function() {
            Route::post('/upload', 'StageController@upload')->middleware('permission:update-files');
            Route::delete('/destroy/{file}', 'StageController@destroy')->middleware('permission:delete-files');
        });
    });
});
