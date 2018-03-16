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

Route::group([
    'namespace' => 'Auth',
], function () {
    Route::get('login', 'AuthController@showLoginForm');
    Route::post('login', 'AuthController@doLogin')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/home', 'HomeController@index')->name('home');