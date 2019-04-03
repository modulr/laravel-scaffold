<?php
Route::group(['namespace' => 'Address'], function() {
    Route::middleware('auth')->group(function () {
        // views
        Route::group(['prefix' => 'address'], function() {
            Route::view('/', 'address.index')->middleware('permission:read-address');
        });
        // api
        Route::group(['prefix' => 'api/address'], function() {
            Route::get('/byClient/{clientId?}', 'AddressController@byClient')->middleware('permission:read-address');
            Route::post('/store/{clientId?}', 'AddressController@store')->middleware('permission:create-address');
            Route::delete('/{address}', 'AddressController@destroy')->middleware('permission:delete-address');
        });
    });
});
