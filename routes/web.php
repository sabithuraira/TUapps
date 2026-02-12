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

use App\Http\Controllers\IkiMasterController;
use App\Http\Controllers\MasterPekerjaanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:superadmin']], function () {
    Route::resource('uker', 'UkerController');
    Route::resource('uker4', 'Uker4Controller');
    Route::resource('type_kredit', 'TypeKreditController');
    Route::resource('rincian_kredit', 'RincianKreditController');
    Route::resource('angka_kredit', 'AngkaKreditController');
    Route::get('user_riwayat', 'UserController@riwayat');
    Route::get('user_load_data_pegawai', 'UserController@load_data_pegawai');

    Route::get('opname_persediaan/aeik', 'OpnamePersediaanController@aeik');
    Route::get('ckp/{month}/{year}/aeik', 'CkpController@aeik');

    //SPATIE
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::resource('user_role', 'UserRoleController');

    Route::get('sp2020sls/import_some', 'Sp2020SlsController@upload_some');
    Route::post('sp2020sls/import_some', 'Sp2020SlsController@import_some');
    Route::get('sp2020sls/import_pengganti', 'Sp2020SlsController@upload_pengganti');
    Route::post('sp2020sls/import_pengganti', 'Sp2020SlsController@import_pengganti');
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
    Route::get('opname_persediaan/kartu_kendali_q', 'OpnamePersediaanController@kartu_kendali_q');
    Route::post('opname_persediaan/load_kartukendali', 'OpnamePersediaanController@loadKartukendali');
    Route::post('opname_persediaan/print_persediaan', array('as' => 'print_persediaan', 'uses' => 'OpnamePersediaanController@print_persediaan'));
    Route::post('opname_persediaan/print_kartukendali', array('as' => 'print_kartukendali', 'uses' => 'OpnamePersediaanController@print_kartukendali'));
    Route::post('opname_persediaan/print_kartukendali_q', array('as' => 'print_kartukendali_q', 'uses' => 'OpnamePersediaanController@print_kartukendali_q'));
    Route::post('opname_persediaan/update_unit_kerja', 'OpnamePersediaanController@update_unit_kerja');
});

Route::group(['middleware' => ['kdkab:00']], function () {
    Route::resource('opname_permintaan', 'OpnamePermintaanController')->except(['show', 'destroy']);
    Route::post('opname_permintaan/load_data', 'OpnamePermintaanController@loadData');
    Route::post('opname_permintaan/destroy', 'OpnamePermintaanController@destroy');
    Route::get('opname_permintaan/print/{id}', 'OpnamePermintaanController@print');
});

Route::group(['middleware' => ['role:superadmin|subbag-umum', 'kdkab:00']], function () {
    Route::get('opname_permintaan/proses', 'OpnamePermintaanController@proses');
    Route::post('opname_permintaan/load_data_proses', 'OpnamePermintaanController@loadDataProses');
    Route::post('opname_permintaan/update_proses', 'OpnamePermintaanController@updateProses');
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

    Route::resource('fungsional_definitif', 'FungsionalDefinitifController');
    Route::get('fungsional_definitif_export', 'FungsionalDefinitifController@export');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('pok', 'PokController')->only(['index']);
    Route::get('pok/show_transaksi/{id}', 'PokController@show_transaksi');
    Route::get('pok/revisi', 'PokController@revisi');
    Route::post('pok/revisi', 'PokController@store_revisi');
    Route::get('pok/create_revisi', 'PokController@create_revisi');
    Route::post('pok/save_transaksi', 'PokController@save_transaksi');
    Route::post('pok/delete_transaksi', 'PokController@delete_transaksi');
    Route::get('pok/download/{jenis}/{file_name}', 'PokController@download');
    Route::delete('pok/{id}/destroy_revisi', 'PokController@destroy_revisi');
    Route::post('pok/{id}/approve_revisi', 'PokController@approve_revisi');

    Route::resource('tim', 'TimController')->except('show');
    Route::get('tim/{id}/detail_iki', 'TimController@detail_iki');
    Route::get('tim/{id}/detail', 'TimController@detail');
    Route::post('tim/{id}/destroy_participant', 'TimController@destroy_participant');
});

Route::group(['middleware' => ['role:superadmin']], function () {
    Route::get('pok/import_pok', 'PokController@upload_pok');
    Route::post('pok/import_pok', 'PokController@import_pok');
});

Route::group(['middleware' => ['role:superadmin|kuasa_anggaran']], function () {
    Route::post('pok/save_pj', 'PokController@save_pj');
    Route::resource('pok_versi', 'PokVersiController');
    Route::post('pok/get_list_pok', 'PokController@get_list_pok');
    Route::post('pok/save_new_pok', 'PokController@save_new_pok');
    Route::post('pok/save_pok', 'PokController@save_pok');
    Route::get('pok/simpan_revisi', 'PokController@simpan_revisi');
    Route::post('pok/delete_revisi', 'PokController@delete_revisi');
    Route::post('pok/save_revisi', 'PokController@save_revisi');
});

Route::group(['middleware' => ['role:superadmin|tatausaha']], function () {
    // Route::resource('jadwal_dinas','JadwalDinasController');
    Route::get('mata_anggaran/index', 'MataAnggaranController@index');
    Route::get('mata_anggaran/import_some', 'MataAnggaranController@upload_some');
    Route::post('mata_anggaran/import_some', 'MataAnggaranController@import_some');
    Route::resource('mata_anggaran', 'MataAnggaranController')->except(['show']);

    Route::resource('user', 'UserController');

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


Route::get('izin_keluar/index_eks', 'IzinKeluarController@index_eks');
Route::post('izin_keluar/index_eks', 'IzinKeluarController@store_eks');
Route::post('izin_keluar/data_izin_keluar', 'IzinKeluarController@dataIzinKeluar');
// Route::post('izin_keluar/data_izin_keluar', 'IzinKeluarController@dataIzinKeluar');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('sira', 'SiraController')->except(['show']);
    Route::get('sira/{id}/show', 'SiraController@show');
    Route::get('sira/syncall', 'SiraController@syncAll');
    Route::get('sira/{kode_mak}/get_akun', 'SiraController@getAkun');
    Route::get('sira/create_akun', 'SiraController@create_akun');
    Route::post('sira/create_akun', 'SiraController@store_akun');
    Route::get('sira/{id}/edit_akun', 'SiraController@edit_akun');
    Route::post('sira/{id}/edit_akun', 'SiraController@update_akun');
    Route::get('sira/import_akun', 'SiraController@import_akun');
    Route::post('sira/import_akun', 'SiraController@upload_akun');

    Route::get('sira/{id}/create_realisasi', 'SiraController@create_realisasi');
    Route::post('sira/{id}/create_realisasi', 'SiraController@store_realisasi');
    Route::get('sira/{id}/edit_realisasi', 'SiraController@edit_realisasi');
    Route::post('sira/{id}/edit_realisasi', 'SiraController@update_realisasi');
    Route::get('sira/get_dashboard', 'SiraController@getDashboard');
    Route::post('sira/{id}/destroy_rincian', 'SiraController@destroy_rincian');

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
    Route::post('surat_km/nomor_urut', 'SuratKmController@getNomorUrut');

    //////////////////////////
    Route::resource('log_book', 'LogBookController')->except(['show']);
    Route::post('log_book/data_log_book', 'LogBookController@dataLogBook');
    Route::post('log_book/komentar', 'LogBookController@dataKomentar');
    Route::post('log_book/save_komentar', 'LogBookController@saveKomentar');
    Route::post('log_book/send_to_ckp', 'LogBookController@send_to_ckp');
    Route::get('log_book/rekap_pegawai', 'LogBookController@rekap_pegawai');
    Route::get('log_book/rekap_uker_perbulan', 'LogBookController@rekap_uker_perbulan');
    Route::get('log_book/destroy_logbook/{id}', 'LogBookController@destroy_logbook');
    Route::get('log_book/download/{tanggal}/{unit_kerja}', 'LogBookController@downloadExcel');
    Route::post('log_book/download_wfh', 'LogBookController@downloadExcelWfh');
    Route::get('log_book/laporan_wfh', 'LogBookController@laporan_wfh');

    //////////////////////////Izin Keluar
    Route::resource('izin_keluar', 'IzinKeluarController')->only(['index', 'store']);
    Route::get('izin_keluar/rekap', 'IzinKeluarController@rekap');
    Route::post('izin_keluar/data_rekap', 'IzinKeluarController@data_rekap');
    Route::get('izin_keluar/rekap_today', 'IzinKeluarController@rekap_today');
    Route::post('izin_keluar/data_rekap_today', 'IzinKeluarController@data_rekap_today');
    // Route::get('izin_keluar/destroy_izinkeluar/{id}', 'IzinKeluarController@destroy_IzinKeluar');

    ///////////////
    Route::resource('rencana_kerja', 'RencanaKerjaController')->except(['show']);
    Route::post('rencana_kerja/data_rencana_kerja', 'RencanaKerjaController@dataRencanaKerja');
    Route::post('rencana_kerja/send_to_logbook', 'RencanaKerjaController@send_to_logbook');
    Route::get('rencana_kerja/rekap_pegawai', 'RencanaKerjaController@rekap_pegawai');
    Route::get('rencana_kerja/destroy_rencana_kerja/{id}', 'RencanaKerjaController@destroy_rencana_kerja');
    //////////////////

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
    Route::resource('iki_pegawai', 'IkiMasterController');
    Route::post('iki_pegawai_bukti', [IkiMasterController::class, 'store_bukti']);
    Route::put('iki_pegawai_bukti/{id}', [IkiMasterController::class, 'update_bukti']);
    Route::delete('iki_pegawai_bukti/{id}', [IkiMasterController::class, 'destroy_bukti']);

    Route::resource('iki_report', 'IkiReportController');

    Route::resource('master_pekerjaan', 'MasterPekerjaanController');
    Route::post('master_pekerjaan_import', [MasterPekerjaanController::class, 'import']);
    Route::post('master_pekerjaan/search_data', 'MasterPekerjaanController@search_data');


    //PEGAWAI ANDA
    Route::resource('pegawai_anda', 'PegawaiAndaController')->except(['show']);
    Route::get('pegawai_anda/{id}/profile', 'PegawaiAndaController@profile');
    Route::post('pegawai_anda/{id}/store', 'PegawaiAndaController@store');
    Route::get('pegawai_anda/penilaian_anda', 'PegawaiAndaController@penilaian_anda');
    Route::post('pegawai_anda/data_ckp_tim', 'PegawaiAndaController@dataCkpTim');
    Route::post('pegawai_anda/store_tim', 'PegawaiAndaController@store_tim');

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
    Route::get('dashboard/pes_st2023', 'DashboardController@pes_st2023');
    Route::get('dashboard/st2023', 'DashboardController@st2023');
    Route::get('dashboard/umkm', 'DashboardController@umkm');
    Route::get('dashboard/waktu', 'DashboardController@waktu');
    Route::get('dashboard/lokasi', 'DashboardController@lokasi');
    Route::get('dashboard/target', 'DashboardController@target');
    Route::get('dashboard/koseka', 'DashboardController@koseka');
    Route::get('dashboard/pendampingan', 'DashboardController@pendampingan');
    Route::get('dashboard/petugas', 'DashboardController@petugas');
    Route::get('dashboard/daftar_ruta', 'DashboardController@daftar_ruta');
    Route::get('dashboard/petugas/{id}', 'DashboardController@petugas_show');
    Route::get('dashboard/petugas_sls/{id}', 'DashboardController@petugas_sls');
    Route::get('dashboard/alokasi', 'DashboardController@alokasi');
    Route::get('dashboard/alokasi/{id}', 'DashboardController@alokasi_show');
    Route::get('dashboard/rekap_dl', 'DashboardController@rekap_dl');
    Route::get('dashboard/{id}/profile', 'DashboardController@profile');
    Route::get('download_sp2020', 'HomeController@downloadSp2020');

    //Cuti
    Route::resource('cuti', 'CutiController')->except(['show']);
    Route::post('cuti/set_status_atasan', 'CutiController@set_status_atasan');
    Route::post('cuti/set_status_pejabat', 'CutiController@set_status_pejabat');
    Route::get('cuti/{id}/print_cuti', 'CutiController@print_cuti');
    Route::get('cuti/{id}/delete', 'CutiController@destroy');
});


Route::group(
    ['middleware' => ['role:superadmin|skf|pbj|ppk']],
    function () {
        Route::get('pengadaan', 'PengadaanController@index');
        Route::get('pengadaan/create', 'PengadaanController@create');
        Route::post('pengadaan/store', 'PengadaanController@store');

        Route::get('pengadaan/edit/{id}', 'PengadaanController@edit');
        Route::post('pengadaan/update_skf/{id}', 'PengadaanController@updateskf');
        Route::post('pengadaan/update_ppk/{id}', 'PengadaanController@updateppk');
        Route::post('pengadaan/update_pbj/{id}', 'PengadaanController@updatepbj');

        Route::get('pengadaan/unduh/{file_name}', 'PengadaanController@unduh');
        Route::post('pengadaan/set_aktif', 'PengadaanController@set_aktif');
    }
);


Route::group(['middleware' => ['role:superadmin|pengelola_regsosek']], function () {
    Route::resource('regsosek', 'RegsosekController')->except('show');
});

Route::group(['middleware' => ['role:superadmin|change_agent']], function () {
    // Route::get('bulletin', 'BulletinController@index');
    // Route::post('bulletin', 'BulletinController@store');
    // Route::get('bulletin/{id}', 'BulletinController@show');
    // Route::put('bulletin/{id}', 'BulletinController@update');
    // Route::delete('bulletin/{id}', 'BulletinController@delete');

    Route::post('bulletin/data_bulletin', 'BulletinController@dataBulletin');
    Route::resource('bulletin', 'BulletinController');
});

Route::group(['middleware' => ['role:superadmin|change_ambassador']], function () {
    Route::resource('curhat_anon', 'CurhatAnonController')->except(['show', 'destroy']);
    Route::post('curhat_anon/load_data', 'CurhatAnonController@loadData');
    Route::post('curhat_anon/destroy', 'CurhatAnonController@destroy');

    Route::resource('dopamin_motivasi', 'DopaminMotivasiController')->except(['show', 'create', 'edit', 'destroy']);
    Route::post('dopamin_motivasi/load_data', 'DopaminMotivasiController@loadData');
    Route::delete('dopamin_motivasi/{id}', 'DopaminMotivasiController@destroy');

    Route::resource('dopamin_spada', 'DopaminSpadaController')->except(['show', 'create', 'edit', 'destroy']);
    Route::get('dopamin_spada/hasil/{questionId}', 'DopaminSpadaController@showHasil')->name('dopamin_spada.hasil');
    Route::post('dopamin_spada/load_data', 'DopaminSpadaController@loadData');
    Route::delete('dopamin_spada/{id}', 'DopaminSpadaController@destroy');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('arsip_klasifikasi', 'ArsipKlasifikasiController')->except(['show', 'create', 'edit', 'destroy']);
    Route::post('arsip_klasifikasi/load_data', 'ArsipKlasifikasiController@loadData');
    Route::delete('arsip_klasifikasi/{id}', 'ArsipKlasifikasiController@destroy');
    
    Route::resource('arsip_jenis', 'ArsipJenisController')->except(['show', 'create', 'edit', 'destroy']);
    Route::post('arsip_jenis/load_data', 'ArsipJenisController@loadData');
    Route::delete('arsip_jenis/{id}', 'ArsipJenisController@destroy');
    
    Route::resource('arsip_jra', 'ArsipJraController')->except(['show', 'create', 'edit', 'destroy']);
    Route::post('arsip_jra/load_data', 'ArsipJraController@loadData');
    Route::delete('arsip_jra/{id}', 'ArsipJraController@destroy');
    
    // Daily Standup routes
    Route::get('daily_standup/create-by-tim', 'DailyStandupController@createByTim');
    Route::get('daily_standup/get-anggota-by-tim', 'DailyStandupController@getAnggotaByTim');
    Route::post('daily_standup/store-by-tim', 'DailyStandupController@storeByTim');
    Route::get('daily_standup', 'DailyStandupController@index');
    Route::post('daily_standup', 'DailyStandupController@store');
    Route::post('daily_standup/bulk-store', 'DailyStandupController@bulkStore');
    Route::put('daily_standup/{id}', 'DailyStandupController@update');
    Route::post('daily_standup/bulk-update', 'DailyStandupController@bulkUpdate');
    Route::delete('daily_standup/{id}', 'DailyStandupController@destroy');
});

Auth::routes();

Route::get('/d4ft4r_2612', 'HomeController@d4ft4r_2612');
Route::get('/', 'HomeController@index')->name('home');
Route::get('guest', 'HomeController@guest')->name('guest');
// Route::post('telegram/sp2020', 'TelegramController@sp2020');
Route::post('telegram/sp2020lf', 'TelegramController@sp2020lf');
Route::post('telegram/regsosek', 'TelegramController@regsosek');
Route::post('telegram/pes_st2023', 'TelegramController@pes_st2023');
Route::post('telegram/wilker_2025', 'TelegramController@wilker_2025');
Route::get('telegram/regsosek_belum_unduh', 'TelegramController@regsosek_belum_unduh');
Route::post('telegram/regsosek_set_unduh', 'TelegramController@regsosek_set_unduh');
Route::get('dashboard/{id}/pegawai', 'DashboardController@pegawai');

Route::get('dashboard/data/wilker2025', 'DashboardController@dashboard_wilker2025');
Route::get('dashboard/dinding_berbicara', 'DashboardController@dinding_berbicara');
Route::get('dashboard/api/birthday', 'DashboardController@api_birthday');
Route::get('curhat_anon/api/approved', 'CurhatAnonController@getApprovedCurhats');
