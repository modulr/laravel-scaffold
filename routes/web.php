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
    //return view('welcome');
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::get('/home', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', 'DashboardController@index')->name('home');

require __DIR__ . '/profile/profile.php';
require __DIR__ . '/users/users.php';
require __DIR__ . '/roles/roles.php';
require __DIR__ . '/roles/permissions.php';
require __DIR__ . '/modules/modules.php';
require __DIR__ . '/companies/companies.php';
require __DIR__ . '/transactions/transactions.php';
require __DIR__ . '/stages/stages.php';
require __DIR__ . '/files/files.php';
require __DIR__ . '/comments/comments.php';
