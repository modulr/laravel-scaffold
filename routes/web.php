<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();
Route::get('auth/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', function () {
    return redirect('/');
});

Route::get('/dashboard', 'DashboardController@index');
Route::get('/address', function () {
    return view('address');
});

require __DIR__ . '/profile/profile.php';
require __DIR__ . '/users/users.php';
require __DIR__ . '/roles/roles.php';
require __DIR__ . '/roles/permissions.php';
require __DIR__ . '/modules/modules.php';
require __DIR__ . '/orders/orders.php';
