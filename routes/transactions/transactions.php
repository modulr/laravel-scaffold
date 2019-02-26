<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Transactions'], function() {
        // views
        Route::group(['prefix' => 'transactions'], function() {
            Route::view('/', 'transactions.index')->middleware('permission:read-transactions');
            Route::view('/create', 'transactions.create')->middleware('permission:create-transactions');
            Route::view('/{transaction}/edit', 'transactions.edit')->middleware('permission:read-transactions');
        });

        // api
        Route::group(['prefix' => 'api/transactions'], function() {
            Route::post('/filter', 'TransactionController@filter')->middleware('permission:read-transactions');
            Route::post('/count', 'TransactionController@count')->middleware('permission:read-transactions');
            Route::get('/stats', 'TransactionController@stats')->middleware('permission:read-transactions');
            Route::put('/toggleFinished/{transaction}', 'TransactionController@toggleFinished')->middleware('permission:update-transactions');
            Route::put('/attachCompany/{transaction}', 'TransactionController@attachCompany')->middleware('permission:update-transactions');
            Route::put('/detachCompany/{transaction}/{company}', 'TransactionController@detachCompany')->middleware('permission:update-transactions');

            Route::get('/{transaction}', 'TransactionController@show')->middleware('permission:read-transactions');
            Route::post('/store', 'TransactionController@store')->middleware('permission:create-transactions');
            Route::put('/update/{transaction}', 'TransactionController@update')->middleware('permission:update-transactions');
            Route::delete('/{transaction}', 'TransactionController@destroy')->middleware('permission:delete-transactions');
        });
    });
});
