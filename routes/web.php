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
Route::get('/tiendas/{tag?}', function () {
    return view('stores');
});

Route::get('/dashboard', 'DashboardController@index');

require __DIR__ . '/profile/profile.php';
require __DIR__ . '/users/users.php';
require __DIR__ . '/roles/roles.php';
require __DIR__ . '/roles/permissions.php';
require __DIR__ . '/modules/modules.php';
require __DIR__ . '/orders/orders.php';
require __DIR__ . '/address/address.php';
require __DIR__ . '/rates/rates.php';
require __DIR__ . '/clients/clients.php';
require __DIR__ . '/dealers/dealers.php';
require __DIR__ . '/stores/stores.php';
require __DIR__ . '/configs/configs.php';
