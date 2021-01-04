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
    Route::resource('uker4','Uker4Controller');
    Route::resource('type_kredit','TypeKreditController');
    Route::resource('rincian_kredit','RincianKreditController');
    Route::resource('angka_kredit','AngkaKreditController');
    Route::resource('user','UserController');

    Route::get('opname_persediaan/aeik', 'OpnamePersediaanController@aeik');
    Route::get('ckp/{month}/{year}/aeik', 'CkpController@aeik');

    //SPATIE
    Route::resource('role','RoleController');
    Route::resource('permission','PermissionController');
    Route::resource('user_role','UserRoleController');

    Route::get('sp2020sls/import_some','Sp2020SlsController@upload_some');
    Route::post('sp2020sls/import_some','Sp2020SlsController@import_some');
});

Route::group(['middleware' => ['role:superadmin|subbag-umum']], function () {    
    Route::resource('master_barang','MasterBarangController');
    Route::resource('opname_persediaan','OpnamePersediaanController')->except(['show']);
    Route::post('opname_persediaan/load_data', 'OpnamePersediaanController@loadData');
    Route::post('opname_persediaan/load_rincian', 'OpnamePersediaanController@loadRincian');
    Route::post('opname_persediaan/store_barang_keluar', 'OpnamePersediaanController@storeBarangKeluar');
    Route::post('opname_persediaan/store_barang_masuk', 'OpnamePersediaanController@storeBarangMasuk');
    Route::post('opname_persediaan/delete_barang_keluar', 'OpnamePersediaanController@deleteBarangKeluar');
    Route::post('opname_persediaan/delete_barang_masuk', 'OpnamePersediaanController@deleteBarangMasuk');
    Route::get('opname_persediaan/kartu_kendali', 'OpnamePersediaanController@kartu_kendali');
    Route::post('opname_persediaan/load_kartukendali', 'OpnamePersediaanController@loadKartukendali');
    Route::post('opname_persediaan/print_persediaan',array('as'=>'print_persediaan','uses'=>'OpnamePersediaanController@print_persediaan'));
    Route::post('opname_persediaan/print_kartukendali',array('as'=>'print_kartukendali','uses'=>'OpnamePersediaanController@print_kartukendali'));
});

Route::group(['middleware' => ['role:superadmin|subbag-umum|subbag-keuangan']], function () {    
    Route::resource('pemegang_bmn','PemegangBmnController');
});


Route::group(['middleware' => ['role:superadmin|kepegawaian']], function () {    
    Route::get('ckp/pemantau_ckp', 'CkpController@pemantau_ckp');
    Route::get('ckp/rekap_ckp', 'CkpController@rekap_ckp');
    Route::post('ckp/data_rekap_ckp', 'CkpController@data_rekap_ckp');
});

Route::group(['middleware' => ['role:superadmin|tatausaha']], function () {    
    // Route::resource('jadwal_dinas','JadwalDinasController');
    Route::get('mata_anggaran/index','MataAnggaranController@index');
    Route::get('mata_anggaran/import_some','MataAnggaranController@upload_some');
    Route::post('mata_anggaran/import_some','MataAnggaranController@import_some');
    // Route::resource('mata_anggaran','MataAnggaranController')->except(['show']);
    
    /////////////////SURAT TUGAS TUGAS
    Route::resource('surat_tugas','SuratTugasController')->except(['show']);
    Route::post('surat_tugas/calendar', 'SuratTugasController@calendar');
    Route::post('surat_tugas/list_pegawai', 'SuratTugasController@listPegawai');
    Route::post('surat_tugas/list_kegiatan', 'SuratTugasController@listKegiatan');
    Route::post('surat_tugas/set_lpd', 'SuratTugasController@set_lpd');
    Route::post('surat_tugas/set_kelengkapan', 'SuratTugasController@set_kelengkapan');
    Route::post('surat_tugas/set_pembayaran', 'SuratTugasController@set_pembayaran');
    Route::post('surat_tugas/set_aktif', 'SuratTugasController@set_aktif');
    Route::get('surat_tugas/edit_unit_kerja', 'SuratTugasController@edit_unit_kerja');
    Route::post('surat_tugas/edit_unit_kerja', 'SuratTugasController@update_unit_kerja');
    /////////////////
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('surat_tugas/daftar', 'SuratTugasController@daftar');
    ////////////////////
    Route::resource('surat_km','SuratKmController');
    Route::post('surat_km/nomor_urut','SuratKmController@getNomorUrut');

    //////////////////////////
    Route::resource('log_book','LogBookController')->except(['show']);
    Route::post('log_book/data_log_book', 'LogBookController@dataLogBook');
    Route::post('surat_km/nomor_urut','SuratKmController@getNomorUrut');
    Route::post('log_book/komentar', 'LogBookController@dataKomentar');
    Route::post('log_book/save_komentar', 'LogBookController@saveKomentar');
    Route::post('log_book/send_to_ckp', 'LogBookController@send_to_ckp');
    Route::get('log_book/rekap_pegawai', 'LogBookController@rekap_pegawai');
    Route::get('log_book/destroy_logbook/{id}', 'LogBookController@destroy_logbook');
    Route::get('log_book/download/{tanggal}/{unit_kerja}', 'LogBookController@downloadExcel');
    Route::post('log_book/download_wfh', 'LogBookController@downloadExcelWfh');
    Route::get('log_book/laporan_wfh', 'LogBookController@laporan_wfh');

    //CKP
    Route::resource('ckp','CkpController');
    Route::post('ckp/data_ckp', 'CkpController@dataCkp');
    Route::post('ckp/data_profile', 'CkpController@dataProfile');
    Route::post('ckp/data_unit_kerja', 'CkpController@dataUnitKerja');
    Route::post('ckp/print',array('as'=>'print','uses'=>'CkpController@print'));

    //IKI
    // Route::post('iki','IkiController@store');
    Route::resource('iki','IkiController')->except(['show']);
    Route::post('iki/store_master', 'IkiController@store_master');
    Route::get('iki/list_json', 'IkiController@list_json');

    //PEGAWAI ANDA
    Route::resource('pegawai_anda','PegawaiAndaController');
    Route::get('pegawai_anda/{id}/profile', 'PegawaiAndaController@profile');
    Route::post('pegawai_anda/{id}/store', 'PegawaiAndaController@store');

    Route::resource('meeting','MeetingController')->except(['show']);
    Route::get('meeting/{id}/detail','MeetingController@detail');
    Route::get('meeting/kalender','MeetingController@kalender');
    Route::post('meeting/load_pegawai','MeetingController@loadPegawai');
    Route::get('meeting/{id}/destroy_peserta', 'MeetingController@destroy_peserta');
    Route::post('meeting/data_peserta', 'MeetingController@data_peserta');

    ///
    Route::get('hai', 'HomeController@hai')->name('hai');
    Route::get('download_sp2020', 'HomeController@downloadSp2020');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('guest', 'HomeController@guest')->name('guest');
Route::post('telegram/sp2020', 'TelegramController@sp2020');