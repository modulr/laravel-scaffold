<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'roles'], function() {
        // views
        Route::group(['prefix' => 'roles'], function() {
            Route::view('/', 'roles.index');
            Route::view('/create', 'roles.create');
            Route::view('/{role}/edit', 'roles.edit');
        });

        // api
        Route::group(['prefix' => 'api/roles'], function() {
            Route::get('/count', 'RoleController@count');
            Route::get('/getRoleModulesPermissions/{role}','RoleController@getRoleModulesPermissions');
            Route::post('/filter', 'RoleController@filter');
            Route::get('/{role}', 'RoleController@show');
            Route::post('/store', 'RoleController@store');
            Route::put('/update/{role}', 'RoleController@update');
            Route::delete('/{user}', 'RoleController@destroy');
        });
    });
});
