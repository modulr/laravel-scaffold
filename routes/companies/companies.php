<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Companies'], function() {
        // views
        Route::group(['prefix' => 'companies'], function() {
            Route::view('/', 'companies.index')->middleware('permission:read-companies');
            Route::view('/create', 'companies.create')->middleware('permission:create-companies');
            Route::view('/{company}/edit', 'companies.edit')->middleware('permission:update-companies');
        });

        // api
        Route::group(['prefix' => 'api/companies'], function() {
            Route::post('/filter', 'CompanyController@filter')->middleware('permission:read-companies');
            Route::get('/{company}', 'CompanyController@show')->middleware('permission:read-companies');
            Route::post('/store', 'CompanyController@store')->middleware('permission:create-companies');
            Route::put('/update/{company}', 'CompanyController@update')->middleware('permission:update-companies');
            Route::delete('/{company}', 'CompanyController@destroy')->middleware('permission:delete-companies');
        });
    });
});
