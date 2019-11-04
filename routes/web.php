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


Route::get('testa', function () {
    // print_r(Flysystem::connection('webdav')->listContents('remote.php/webdav/'));
    
    $data = Flysystem::connection('webdav')->put('test.txt', 'hai hai');
    print_r("udahan");
    die();
});

Route::group(['middleware' => ['role:superadmin']], function () {    
    Route::resource('uker','UkerController');
    Route::resource('type_kredit','TypeKreditController');
    Route::resource('rincian_kredit','RincianKreditController');
    Route::resource('angka_kredit','AngkaKreditController');
    Route::resource('user','UserController');

    //SPATIE
    Route::resource('role','RoleController');
    Route::resource('permission','PermissionController');
    Route::resource('user_role','UserRoleController');
});


Route::group(['middleware' => ['role:superadmin|tatausaha']], function () {    
    Route::resource('jadwal_dinas','JadwalDinasController');
});


Route::group(['middleware' => ['role:superadmin|tatausaha']], function () {    
    Route::resource('master_barang','MasterBarangController');
    Route::resource('opname_persediaan','OpnamePersediaanController')->except(['show']);
    Route::post('opname_persediaan/data_ckp', 'CkpController@dataCkp');
});

Route::resource('surat_km','SuratKmController');
Route::post('surat_km/nomor_urut','SuratKmController@getNomorUrut');
Route::resource('log_book','LogBookController');
Route::post('log_book/data_log_book', 'LogBookController@dataLogBook');
Route::post('surat_km/nomor_urut','SuratKmController@getNomorUrut');
Route::post('log_book/komentar', 'LogBookController@dataKomentar');
Route::post('log_book/save_komentar', 'LogBookController@saveKomentar');

Route::resource('ckp','CkpController')->except(['show']);

// Route::resource('attribute_pos','AttributePosController')->except(['show']);
Route::post('ckp/data_ckp', 'CkpController@dataCkp');
// Route::get('ckp/print', 'CkpController@print');
Route::post('ckp/print',array('as'=>'print','uses'=>'CkpController@print'));

Route::resource('pegawai_anda','PegawaiAndaController');
Route::get('pegawai_anda/{id}/profile', 'PegawaiAndaController@profile');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('guest', 'HomeController@guest')->name('guest');
