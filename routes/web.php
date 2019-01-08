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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('uker','UkerController');
Route::resource('type_kredit','TypeKreditController');
Route::resource('rincian_kredit','RincianKreditController');
Route::resource('angka_kredit','AngkaKreditController');
Route::resource('user','UserController');
Route::resource('ckp','CkpController');
Route::post('ckp/data_ckp', 'CkpController@dataCkp');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
