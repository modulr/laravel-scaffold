<?php
Route::group(['namespace' => 'Configs'], function() {
    Route::get('api/configs/first', 'ConfigController@first');
});
