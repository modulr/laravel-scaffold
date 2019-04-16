<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Stores'], function() {
        // views
        Route::group(['prefix' => 'stores'], function() {
            Route::view('/', 'stores.index')->middleware('permission:read-stores');
        });

        // api
        Route::group(['prefix' => 'api/stores'], function() {
            Route::post('/filter', 'StoreController@filter')->middleware('permission:read-stores');
            Route::put('/updateScore/{store}', 'StoreController@updateScore')->middleware('permission:update-stores');

            Route::get('/all', 'StoreController@all')->middleware('permission:read-stores');
            Route::post('/store', 'StoreController@store')->middleware('permission:create-stores');
            Route::put('/update/{store}', 'StoreController@update')->middleware('permission:update-stores');
            Route::delete('/{store}', 'StoreController@destroy')->middleware('permission:delete-stores');
        });
    });
});
