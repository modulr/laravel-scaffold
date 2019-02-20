<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Files'], function() {
        // api
        Route::group(['prefix' => 'api/files'], function() {
            Route::post('/upload', 'FileController@upload')->middleware('permission:update-files');
            Route::delete('/destroy/{file}', 'FileController@destroy')->middleware('permission:delete-files');
        });
    });
});
