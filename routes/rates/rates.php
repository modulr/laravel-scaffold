<?php
Route::group(['namespace' => 'Rates'], function() {
    Route::middleware('auth')->group(function () {
        // views
        Route::group(['prefix' => 'rates'], function() {
            Route::view('/', 'rates.index')->middleware('permission:read-rates');
        });
        // api
        Route::group(['prefix' => 'api/rates'], function() {
            Route::get('/all', 'RateController@all')->middleware('permission:read-rates');
            Route::post('/store', 'RateController@store')->middleware('permission:create-rates');
        });
    });
    Route::get('api/rates/day', 'RateController@day');
});
