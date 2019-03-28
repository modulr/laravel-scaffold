<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Orders'], function() {
        // views
        Route::group(['prefix' => 'orders'], function() {
            Route::view('/', 'orders.index')->middleware('permission:read-orders');
            //Route::view('/create', 'transactions.create')->middleware('permission:create-orders');
            Route::view('/{order}', 'orders.order')->middleware('permission:read-orders');
        });

        // api
        Route::group(['prefix' => 'api/orders'], function() {
            Route::get('/byUser/{user}', 'OrderController@byUser')->middleware('permission:read-orders');
            Route::get('/{order}', 'OrderController@show')->middleware('permission:read-orders');
            Route::post('/store', 'OrderController@store')->middleware('permission:create-orders');
        });
    });
});
