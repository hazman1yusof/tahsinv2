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
Route::get('/login','SessionController@index')->name('login');
Route::post('/login','SessionController@login');
Route::get('/logout','SessionController@destroy');
Route::get('/register','SessionController@register')->name('register');
Route::post('/register','SessionController@register_user');

Route::get('/','DashboardController@dashboard');
Route::get('/dashboard','DashboardController@dashboard');
Route::get('/upd_user','DashboardController@upd_user')->name('upd_user');
Route::post('/upd_user','DashboardController@upd_user_post');

Route::get('/setup_user','SetupController@setup_user');
Route::get('/setup_kelas','SetupController@setup_kelas');
Route::get('/setup_jadual','SetupController@setup_jadual');
Route::get('/setup_tilawah','SetupController@setup_tilawah');
Route::post('/setup/form','SetupController@form');
Route::get('/setup/table','SetupController@table');

Route::get('/kelas','KelasController@kelas');
Route::get('/kelas_detail','KelasController@kelas_detail');
Route::post('/kelas/form','KelasController@form');
Route::get('/kelas/table','KelasController@table');

Route::get('/pengajar','PengajarController@pengajar');
Route::get('/pengajar_detail','PengajarController@pengajar_detail');
Route::get('/mark','PengajarController@mark');
Route::post('/pengajar/form','PengajarController@form');
Route::get('/pengajar/table','PengajarController@table');

Route::get('/tilawah','TilawahController@tilawah');
Route::get('/tilawah_detail','TilawahController@tilawah_detail');
Route::get('/tilawah/form','TilawahController@form');
Route::get('/tilawah/table','TilawahController@table');