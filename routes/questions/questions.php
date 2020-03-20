<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Questions'], function() {

        // views
        Route::view('/test', 'questions.questions')->middleware('permission:read-profile');

        // api
        Route::group(['prefix' => 'api/questions'], function() {
            Route::get('/setQuestions', 'QuestionController@setQuestions')->middleware('permission:read-profile');
            Route::get('/getQuestions', 'QuestionController@getQuestions')->middleware('permission:read-profile');
            Route::put('/saveQuestions', 'QuestionController@saveQuestions')->middleware('permission:read-profile');
        });
    });
});
