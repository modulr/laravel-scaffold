<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Roles'], function() {
        // views
        Route::group(['prefix' => 'roles'], function() {
            Route::view('/', 'roles.index')->middleware('permission:read-roles');
            Route::view('/create', 'roles.create')->middleware('permission:create-roles');
            Route::view('/{role}/edit', 'roles.edit')->middleware('permission:update-roles');
        });

        // api
        Route::group(['prefix' => 'api/roles'], function() {
            Route::get('/count', 'RoleController@count');
            Route::get('/all', 'RoleController@all');
            Route::get('/getRoleModulesPermissions/{role}','RoleController@getRoleModulesPermissions');
            Route::post('/filter', 'RoleController@filter')->middleware('permission:read-roles');

            Route::get('/{role}', 'RoleController@show')->middleware('permission:read-roles');
            Route::post('/store', 'RoleController@store')->middleware('permission:create-roles');
            Route::put('/update/{role}', 'RoleController@update')->middleware('permission:update-roles');
            Route::delete('/{user}', 'RoleController@destroy')->middleware('permission:delete-roles');
        });
    });
});
