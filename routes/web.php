<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::middleware('auth')
    ->group(function () {
        Route::post('/', 'DashboardController@store')->name('dashboard.store');
        Route::get('/decrypt-password', 'DashboardController@decrypt_password');
        Route::post('/autocomplete/fetch_projects', 'AutocompleteController@fetch_projects');
        Route::post('/autocomplete/fetch_services', 'AutocompleteController@fetch_services');
    });
