<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Orders'], function() {
        // views
        Route::group(['prefix' => 'orders'], function() {
            Route::view('/', 'orders.index')->middleware('permission:read-orders');
            Route::view('/availables', 'orders.availables')->middleware('permission:read-orders');
            Route::view('/dealer', 'orders.dealer')->middleware('permission:read-orders');
            Route::view('/create', 'orders.create')->middleware('permission:create-orders');
            Route::view('/{order}', 'orders.order')->middleware('permission:read-orders');
        });

        // api
        Route::group(['prefix' => 'api/orders'], function() {
            Route::get('/status', 'OrderController@status')->middleware('permission:read-orders');
            Route::get('/availables', 'OrderController@availables')->middleware('permission:read-orders');
            Route::get('/byUser/{user}', 'OrderController@byUser')->middleware('permission:read-orders');
            Route::get('/byDealer/{user}', 'OrderController@byDealer')->middleware('permission:read-orders');

            Route::put('/updateStatus/{order}', 'OrderController@updateStatus')->middleware('permission:update-orders');
            Route::put('/updateScoreClient/{order}', 'OrderController@updateScoreClient')->middleware('permission:update-orders');
            Route::put('/updateScoreDealer/{order}', 'OrderController@updateScoreDealer')->middleware('permission:update-orders');
            Route::put('/takeOrder/{order}', 'OrderController@takeOrder')->middleware('permission:update-orders');

            Route::get('/{order}', 'OrderController@show')->middleware('permission:read-orders');
            Route::post('/store', 'OrderController@store')->middleware('permission:create-orders');
        });
    });
});
