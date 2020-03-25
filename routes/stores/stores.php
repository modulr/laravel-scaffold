<?php
Route::group(['namespace' => 'Stores'], function() {
    Route::get('api/stores/getStoresRandom', 'StoreController@getStoresRandom');
    Route::get('api/stores/getStoresLevel1', 'StoreController@getStoresLevel1');
    Route::get('api/stores/getStoresLevel23', 'StoreController@getStoresLevel23');
    Route::post('api/stores/filters', 'StoreController@filter');

    Route::middleware('auth')->group(function () {
      // views
      Route::group(['prefix' => 'stores'], function() {
          Route::view('/', 'stores.index')->middleware('permission:read-stores');
          Route::view('/create', 'stores.create')->middleware('permission:create-stores');
          Route::view('/{user}/edit', 'stores.edit')->middleware('permission:update-stores');
      });

      // api
      Route::group(['prefix' => 'api/stores'], function() {
          Route::post('/filter', 'StoreController@filter')->middleware('permission:read-stores');
          Route::post('/uploadAvatar', 'StoreController@uploadAvatar')->middleware('permission:update-stores');
          Route::post('/uploadBanner', 'StoreController@uploadBanner')->middleware('permission:update-stores');

          Route::get('/{user}', 'StoreController@show')->middleware('permission:read-stores');
          Route::post('/store', 'StoreController@store')->middleware('permission:create-stores');
          Route::put('/update/{user}', 'StoreController@update')->middleware('permission:update-stores');
          Route::delete('/{user}', 'StoreController@destroy')->middleware('permission:delete-stores');
      });
    });
});
