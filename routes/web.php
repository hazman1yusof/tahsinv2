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
Route::get('/','DashboardController@dashboard');
Route::get('/dashboard','DashboardController@dashboard');

Route::get('/setup_user','SetupController@setup_user');
Route::post('/setup_user/form','SetupController@form');
Route::get('/setup_user/table','SetupController@table');

Route::get('/setup_kelas','SetupController@setup_kelas');
Route::post('/setup_kelas/form','SetupController@form');
Route::get('/setup_kelas/table','SetupController@table');