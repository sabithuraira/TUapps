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
Route::group(['middleware' => ['role:superadmin']], function () {
    Route::resource('uker', 'UkerController');
    Route::resource('uker4', 'Uker4Controller');
    Route::resource('type_kredit', 'TypeKreditController');
    Route::resource('rincian_kredit', 'RincianKreditController');
    Route::resource('angka_kredit', 'AngkaKreditController');
    Route::resource('user', 'UserController');

    Route::get('opname_persediaan/aeik', 'OpnamePersediaanController@aeik');
    Route::get('ckp/{month}/{year}/aeik', 'CkpController@aeik');

    //SPATIE
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::resource('user_role', 'UserRoleController');

    Route::get('sp2020sls/import_some', 'Sp2020SlsController@upload_some');
    Route::post('sp2020sls/import_some', 'Sp2020SlsController@import_some');
});

Route::group(['middleware' => ['role:superadmin|subbag-umum']], function () {
    Route::resource('master_barang', 'MasterBarangController');
    Route::resource('opname_persediaan', 'OpnamePersediaanController')->except(['show']);
    Route::post('opname_persediaan/load_data', 'OpnamePersediaanController@loadData');
    Route::post('opname_persediaan/load_rincian', 'OpnamePersediaanController@loadRincian');
    Route::post('opname_persediaan/store_barang_keluar', 'OpnamePersediaanController@storeBarangKeluar');
    Route::post('opname_persediaan/store_barang_masuk', 'OpnamePersediaanController@storeBarangMasuk');
    Route::post('opname_persediaan/delete_barang_keluar', 'OpnamePersediaanController@deleteBarangKeluar');
    Route::post('opname_persediaan/delete_barang_masuk', 'OpnamePersediaanController@deleteBarangMasuk');
    Route::get('opname_persediaan/kartu_kendali', 'OpnamePersediaanController@kartu_kendali');
    Route::post('opname_persediaan/load_kartukendali', 'OpnamePersediaanController@loadKartukendali');
    Route::post('opname_persediaan/print_persediaan', array('as' => 'print_persediaan', 'uses' => 'OpnamePersediaanController@print_persediaan'));
    Route::post('opname_persediaan/print_kartukendali', array('as' => 'print_kartukendali', 'uses' => 'OpnamePersediaanController@print_kartukendali'));
});

Route::group(['middleware' => ['role:superadmin|subbag-umum|subbag-keuangan']], function () {
    Route::resource('pemegang_bmn', 'PemegangBmnController');
});

Route::group(['middleware' => ['role:superadmin|kepegawaian']], function () {
    Route::get('ckp/pemantau_ckp', 'CkpController@pemantau_ckp');
    Route::get('ckp/rekap_ckp', 'CkpController@rekap_ckp');
    Route::post('ckp/data_rekap_ckp', 'CkpController@data_rekap_ckp');

    Route::resource('jabatan_fungsional', 'JabatanFungsionalController');
    Route::post('jabatan_fungsional/tambah_jabatan', 'JabatanFungsionalController@tambah_jabatan');
    Route::post('jabatan_fungsional/hapus_jabatan', 'JabatanFungsionalController@hapus_jabatan');
    Route::post('jabatan_fungsional/tambah_row', 'JabatanFungsionalController@tambah_row');
    Route::post('jabatan_fungsional/edit_judul', 'JabatanFungsionalController@edit_judul');
    Route::post('jabatan_fungsional/edit_subjudul', 'JabatanFungsionalController@edit_subjudul');
    Route::post('jabatan_fungsional/edit_kegiatan', 'JabatanFungsionalController@edit_kegiatan');
    Route::post('jabatan_fungsional/edit_subkegiatan', 'JabatanFungsionalController@edit_subkegiatan');
    Route::post('jabatan_fungsional/hapus', 'JabatanFungsionalController@hapus');
});


Route::group(['middleware' => ['role:superadmin']], function () {
    Route::resource('pok', 'PokController')->except(['show']);

    Route::get('pok/import_pok', 'PokController@upload_pok');
    Route::post('pok/import_pok', 'PokController@import_pok');
});

Route::group(['middleware' => ['role:superadmin|tatausaha']], function () {
    // Route::resource('jadwal_dinas','JadwalDinasController');
    Route::get('mata_anggaran/index', 'MataAnggaranController@index');
    Route::get('mata_anggaran/import_some', 'MataAnggaranController@upload_some');
    Route::post('mata_anggaran/import_some', 'MataAnggaranController@import_some');
    Route::resource('mata_anggaran', 'MataAnggaranController')->except(['show']);

    //Cuti
    Route::resource('cuti', 'CutiController')->except(['show']);
    Route::post('cuti/set_status_atasan', 'CutiController@set_status_atasan');
    Route::post('cuti/set_status_pejabat', 'CutiController@set_status_pejabat');
    Route::get('cuti/{id}/print_cuti', 'CutiController@print_cuti');
    Route::get('cuti/{id}/delete', 'CutiController@destroy');

    /////////////////SURAT TUGAS TUGAS
    Route::resource('surat_tugas', 'SuratTugasController')->except(['show']);
    Route::post('surat_tugas/calendar', 'SuratTugasController@calendar');
    Route::post('surat_tugas/list_pegawai', 'SuratTugasController@listPegawai');
    Route::post('surat_tugas/list_kegiatan', 'SuratTugasController@listKegiatan');
    Route::post('surat_tugas/set_status', 'SuratTugasController@set_status');
    Route::post('surat_tugas/set_pejabat_spd', 'SuratTugasController@set_pejabat_spd');
    Route::post('surat_tugas/set_aktif', 'SuratTugasController@set_aktif');
    Route::get('surat_tugas/edit_unit_kerja', 'SuratTugasController@edit_unit_kerja');
    Route::post('surat_tugas/edit_unit_kerja', 'SuratTugasController@update_unit_kerja');
    Route::get('surat_tugas/{id}/print_st', 'SuratTugasController@print_st');
    Route::get('surat_tugas/{id}/print_st_pelatihan', 'SuratTugasController@print_st_pelatihan');
    Route::get('surat_tugas/{id}/print_spd', 'SuratTugasController@print_spd');
    Route::get('surat_tugas/{id}/print_spd_pelatihan', 'SuratTugasController@print_spd_pelatihan');
    Route::get('surat_tugas/{id}/print_kwitansi', 'SuratTugasController@print_kwitansi');
    Route::get('surat_tugas/{id}/print_kwitansi_pelatihan', 'SuratTugasController@print_kwitansi_pelatihan');
    Route::post('surat_tugas/is_available', 'SuratTugasController@is_available');
    Route::get('surat_tugas/{id}/insert_kwitansi', 'SuratTugasController@insert_kwitansi');
    Route::post('surat_tugas/{id}/insert_kwitansi', 'SuratTugasController@store_kwitansi');
    Route::get('surat_tugas/{id}/destroy_kwitansi', 'SuratTugasController@destroy_kwitansi');
    Route::get('surat_tugas/{id}/insert_kwitansi_pelatihan', 'SuratTugasController@insert_kwitansi_pelatihan');
    Route::post('surat_tugas/{id}/insert_kwitansi_pelatihan', 'SuratTugasController@store_kwitansi_pelatihan');
    Route::get('surat_tugas/create_tim', 'SuratTugasController@create_tim');
    Route::post('surat_tugas/create_tim', 'SuratTugasController@store_tim');
    Route::get('surat_tugas/create_pelatihan', 'SuratTugasController@create_pelatihan');
    Route::post('surat_tugas/create_pelatihan', 'SuratTugasController@store_pelatihan');
    /////////////////
});

Route::group(['middleware' => ['role:superadmin|admin_uker|pemberi_tugas']], function () {    
    //
    Route::resource('penugasan', 'PenugasanController')->except('show');
    Route::get('penugasan/{id}/show', 'PenugasanController@show');
    Route::get('penugasan/{id}/detail', 'PenugasanController@detail');
    Route::get('penugasan/{id}/progres', 'PenugasanController@progres');
    Route::post('penugasan/{id}/destroy_participant', 'PenugasanController@destroy_participant');
    Route::post('penugasan/{id}/store_progres', 'PenugasanController@store_progres');
});

Route::group(['middleware' => ['role:superadmin|admin_uker']], function () {    
    Route::get('penugasan/user_role', 'PenugasanController@user_role');
    Route::get('penugasan/{id}/user_role_edit', 'PenugasanController@user_role_edit');
    Route::patch('penugasan/{id}/user_role_update', 'PenugasanController@user_role_update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('penugasan/anda', 'PenugasanController@anda');
    Route::post('penugasan/storeLapor', 'PenugasanController@storeLapor');
    Route::get('penugasan/rekap', 'PenugasanController@rekap');
    Route::post('penugasan/data_rekap', 'PenugasanController@dataRekap');
    //
    Route::get('surat_tugas/daftar', 'SuratTugasController@daftar');
    ////////////////////
    Route::resource('surat_km', 'SuratKmController');
    Route::post('surat_km/nomor_urut', 'SuratKmController@getNomorUrut');
    Route::get('surat_km/{id}/print', 'SuratKmController@print');

    //////////////////////////
    Route::resource('log_book', 'LogBookController')->except(['show']);
    Route::post('log_book/data_log_book', 'LogBookController@dataLogBook');
    Route::post('surat_km/nomor_urut', 'SuratKmController@getNomorUrut');
    Route::post('log_book/komentar', 'LogBookController@dataKomentar');
    Route::post('log_book/save_komentar', 'LogBookController@saveKomentar');
    Route::post('log_book/send_to_ckp', 'LogBookController@send_to_ckp');
    Route::get('log_book/rekap_pegawai', 'LogBookController@rekap_pegawai');
    Route::get('log_book/destroy_logbook/{id}', 'LogBookController@destroy_logbook');
    Route::get('log_book/download/{tanggal}/{unit_kerja}', 'LogBookController@downloadExcel');
    Route::post('log_book/download_wfh', 'LogBookController@downloadExcelWfh');
    Route::get('log_book/laporan_wfh', 'LogBookController@laporan_wfh');

    //CKP
    Route::resource('ckp', 'CkpController');
    Route::post('ckp/data_ckp', 'CkpController@dataCkp');
    Route::post('ckp/data_profile', 'CkpController@dataProfile');
    Route::post('ckp/data_unit_kerja', 'CkpController@dataUnitKerja');
    Route::post('ckp/print', array('as' => 'print', 'uses' => 'CkpController@print'));

    //SKP
    Route::resource('skp', 'SkpController')->only('index', 'create');
    // Route::get('skp/{id}/edit', 'SkpController@edit');
    Route::post('skp/store_target', 'SkpController@store_target');
    Route::post('skp/store_pengukuran', 'SkpController@store_pengukuran');
    Route::get('skp/{id}/data_skp', 'SkpController@dataSkp');
    Route::post('skp/data_profile', 'SkpController@dataProfile');
    Route::post('skp/data_unit_kerja', 'SkpController@dataUnitKerja');
    Route::post('skp/print', array('as' => 'print', 'uses' => 'SkpController@print'));

    //IKI
    // Route::post('iki','IkiController@store');
    Route::resource('iki', 'IkiController')->except(['show']);
    Route::post('iki/store_master', 'IkiController@store_master');
    Route::get('iki/list_json', 'IkiController@list_json');

    //PEGAWAI ANDA
    Route::resource('pegawai_anda', 'PegawaiAndaController');
    Route::get('pegawai_anda/{id}/profile', 'PegawaiAndaController@profile');
    Route::post('pegawai_anda/{id}/store', 'PegawaiAndaController@store');

    Route::resource('meeting', 'MeetingController')->except(['show']);
    Route::get('meeting/{id}/detail', 'MeetingController@detail');
    Route::get('meeting/kalender', 'MeetingController@kalender');
    Route::post('meeting/load_pegawai', 'MeetingController@loadPegawai');
    Route::get('meeting/{id}/destroy_peserta', 'MeetingController@destroy_peserta');
    Route::post('meeting/data_peserta', 'MeetingController@data_peserta');

    Route::resource('vicon', 'ViconController')->except(['show']);
    Route::get('vicon/{id}/detail', 'ViconController@detail');
    ///
    Route::get('hai', 'HomeController@hai')->name('hai');
    Route::get('dashboard/index', 'DashboardController@index');
    Route::get('dashboard/rekap_dl', 'DashboardController@rekap_dl');
    Route::get('dashboard/{id}/profile', 'DashboardController@profile');
    Route::get('download_sp2020', 'HomeController@downloadSp2020');
});

Auth::routes();

Route::get('/d4ft4r_2612', 'HomeController@d4ft4r_2612');
Route::get('/', 'HomeController@index')->name('home');
Route::get('guest', 'HomeController@guest')->name('guest');
// Route::post('telegram/sp2020', 'TelegramController@sp2020');
Route::post('telegram/sp2020lf', 'TelegramController@sp2020lf');
