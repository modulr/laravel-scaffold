<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Comments'], function() {
        // api
        Route::group(['prefix' => 'api/comments'], function() {
            Route::get('/byStage/{stage}', 'CommentController@byStage')->middleware('permission:read-comments');
            Route::post('/store', 'CommentController@store')->middleware('permission:create-comments');
        });
    });
});
