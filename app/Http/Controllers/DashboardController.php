<?php

namespace App\Http\Controllers;

use App\Kabs;
use App\Pdesa;
use App\Pkab;
use App\Pkec;
use App\RiwayatSK;
use App\UnitKerja;
use App\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user();
        $random_user = UserModel::inRandomOrder()->first();
        $unit_kerja = UnitKerja::where('kode', '=', $random_user->kdprop . $random_user->kdkab)->first();

        $dl_per_uk = UnitKerja::rekapDlPerUk();

        $birthday = UserModel::where(DB::raw('SUBSTRING(nip_baru, 5, 2)'), date('m'))
                        ->where(DB::raw('SUBSTRING(nip_baru, 7, 2)'), date('d'))
                        ->where('is_active', 1)
                        ->get();

        // $mengabdi = UserModel::where(DB::raw('SUBSTRING(nip_baru, 13, 2)'), date('m'))
        //             ->where('is_active', 1)
        //             ->get();
        
        // inRandomOrder()->first();

        return view('dashboard.index', compact(
            'random_user',
            'unit_kerja',
            'dl_per_uk',
            'request',
            'birthday', 
            // 'mengabdi'
        ));
    }

    public function umkm(Request $request)
    {
        $auth = Auth::user();
        $random_user = UserModel::inRandomOrder()->first();
        $unit_kerja = UnitKerja::where('kode', '=', $random_user->kdprop . $random_user->kdkab)->first();

        $list_kab_filter = "";
        $kab_filter = "";
        $kab_filter = $request->kab_filter;
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $page = '?page=' . $request->page;
        $filter_url = '&kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter;
        $data_url = 'https://st23.bpssumsel.com/api/umkm';

        $headers = [
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data_result = curl_exec($ch);
        curl_close($ch);
        $data_result = json_decode($data_result, true);

        $data = [];
        $label_kab = "";
        $label_kec = "";
        $label_desa = "";

        $label_kab = $data_result['label_kab'];
        $label_kec = $data_result['label_kec'];
        $label_desa = $data_result['label_desa'];

        if ($data_result) {
            $data = $data_result['data'];
        }

        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }
        $dl_per_uk = UnitKerja::rekapDlPerUk();
        return view('dashboard.umkm', compact(
            'random_user',
            'unit_kerja',
            'dl_per_uk',
            'request',
            'label_kab',
            'label_kec',
            'label_desa',
            'data',
            'auth',
            'kabs',
            'list_kab_filter'
        ));
        
    }

    public function st2023(Request $request)
    {
        $auth = Auth::user();
        $random_user = UserModel::inRandomOrder()->first();
        $unit_kerja = UnitKerja::where('kode', '=', $random_user->kdprop . $random_user->kdkab)->first();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $kab_filter = $request->kab_filter;
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;

        $filter_url = '?kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter . '&sls_filter=' . $sls_filter;
        $wilayah_url = 'https://st23.bpssumsel.com/api/progress';
        $kk_url = 'https://st23.bpssumsel.com/api/progress_kk';
        $dokumen_url = 'https://st23.bpssumsel.com/api/progress_dokumen';

        $headers = [
            'Authorization: Bearer 37|wGY6bloEzGc4SlaQ0Hxx4zyHtQeIYFbKtk0duRF5',
            'Content-Type: application/json',
        ];
        $ch = curl_init($wilayah_url . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $wilayah_result = curl_exec($ch);
        curl_close($ch);
        $wilayah_result = json_decode($wilayah_result, true);

        $data_wilayah = [];
        $label_kab = "";
        $label_kec = "";
        $label_desa = "";
        $label_sls = "";

        $label_kab = $wilayah_result['label_kab'];
        $label_kec = $wilayah_result['label_kec'];
        $label_desa = $wilayah_result['label_desa'];
        $label_sls = $wilayah_result['label_sls'];


        if ($wilayah_result) {
            $data_wilayah = $wilayah_result['data'];
            // dd($data_wilayah);
            // if (isset($data_wilayah[0]['nama_kab'])) {
            //     $label_kab = $data_wilayah[0]['nama_kab'];
            // }
            // if (isset($data_wilayah[0]['nama_kec'])) {
            //     $label_kec = $data_wilayah[0]['nama_kec'];
            // }
            // if (isset($data_wilayah[0]['nama_desa'])) {
            //     $label_desa = $data_wilayah[0]['nama_desa'];
            // }
            // if (isset($data_wilayah[0]['nama_sls'])) {
            //     $label_sls = $data_wilayah[0]['nama_sls'];
            // }
        }

        // dd($data_wilayah);
        // $ch = curl_init($kk_url . $filter_url);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $kk_result = curl_exec($ch);
        // curl_close($ch);
        // $kk_result = json_decode($kk_result, true);
        // $data_kk = [];
        // if ($kk_result) {
        //     $data_kk = $kk_result['data'];
        // }

        $ch = curl_init($dokumen_url . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dokumen_result = curl_exec($ch);
        curl_close($ch);
        $dokumen_result = json_decode($dokumen_result, true);
        $data_dokumen = [];
        if ($dokumen_result) {
            $data_dokumen = $dokumen_result['data'];
        }


        $dl_per_uk = UnitKerja::rekapDlPerUk();
        return view('dashboard.st2023', compact(
            'random_user',
            'unit_kerja',
            'dl_per_uk',
            'request',
            'label_kab',
            'label_kec',
            'label_desa',
            'label_sls',
            'data_wilayah',
            // 'data_kk',
            'data_dokumen',
            'api_token',
            'auth'
        ));
    }

    public function pes_st2023(Request $request)
    {
        $auth = Auth::user();
        $random_user = UserModel::inRandomOrder()->first();
        $unit_kerja = UnitKerja::where('kode', '=', $random_user->kdprop . $random_user->kdkab)->first();

        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $list_kab_filter = "";
        $kab_filter = "";
        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        $kab_filter = $request->kab_filter;
        $kec_filter = $request->kec_filter;
        $page = '?page=' . $request->page;
        $filter_url = '&kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter;
        $data_url = 'https://st23.bpssumsel.com/api/pes';

        $headers = [
            'Authorization: Bearer 37|wGY6bloEzGc4SlaQ0Hxx4zyHtQeIYFbKtk0duRF5',
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data_result = curl_exec($ch);
        curl_close($ch);
        $data_result = json_decode($data_result, true);

        $data = [];
        $label_kab = "";
        $label_kec = "";

        $label_kab = $data_result['label_kab'];
        $label_kec = $data_result['label_kec'];

        $links = [];
        if ($data_result) {
            $data = $data_result['data']['data'];
            $links = $data_result['data']['links'];
        }
        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.pes_st2023', compact(
            'random_user',
            'unit_kerja',
            'request',
            'label_kab',
            'label_kec',
            'data',
            'api_token',
            'auth',
            'links',
            'kabs',
            'list_kab_filter'
        ));
    }

    public function waktu(Request $request)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $list_kab_filter = "";
        $kab_filter = "";
        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        $tanggal_awal = $request->tanggal_awal ? $request->tanggal_awal : now()->subDays(7)->format('m/d/Y');
        $tanggal_akhir = $request->tanggal_akhir ? $request->tanggal_akhir : now()->format('m/d/Y');

        // Mengambil Data Tabel
        $filter_url = '&kab_filter=' . $kab_filter .
            '&kec_filter=' . $kec_filter .
            '&desa_filter=' . $desa_filter .
            '&sls_filter=' . $sls_filter .
            '&tanggal_awal=' . $tanggal_awal .
            '&tanggal_akhir=' . $tanggal_akhir;
        $data_url = 'http://st23.bpssumsel.com/api/dashboard_waktu';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];
        if ($result) {
            $data = $result['datas']['data'];
            $links = $result['datas']['links'];
        }

        //  Mengambil List Filter KabKot
        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.dash_waktu', compact(
            'auth',
            'api_token',
            'request',
            'data',
            'links',
            'kabs',
            'tanggal_awal',
            'tanggal_akhir'
        ));
    }

    public function lokasi(Request $request)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $list_kab_filter = "";
        $kab_filter = "";

        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        $tanggal_awal = $request->tanggal_awal ? $request->tanggal_awal : now()->subDays(7)->format('m/d/Y');
        $tanggal_akhir = $request->tanggal_akhir ? $request->tanggal_akhir : now()->format('m/d/Y');

        // Mengambil Data Tabel
        $filter_url = '&kab_filter=' . $kab_filter .
            '&kec_filter=' . $kec_filter .
            '&desa_filter=' . $desa_filter .
            '&sls_filter=' . $sls_filter .
            '&tanggal_awal=' . $tanggal_awal .
            '&tanggal_akhir=' . $tanggal_akhir;
        $data_url = 'https://st23.bpssumsel.com/api/dashboard_lokasi';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];
        if ($result) {
            $data = $result['datas']['data'];
            $links = $result['datas']['links'];
        }

        // dd($data);
        // Mengambil List Filter Kabkot
        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.dash_lokasi', compact(
            'auth',
            'api_token',
            'request',
            'data',
            'links',
            'kabs',
            'tanggal_awal',
            'tanggal_akhir'
        ));
    }

    public function target(Request $request)
    {
        $target_hari_ini = 0;
        $date2 = date('Y-m-d');
        $date1 = strtotime("2023-06-01");
        $diff = round(abs($date1 - strtotime($date2)) / 86400);
        $target_hari_ini = 10 * ($diff + 1);

        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $list_kab_filter = "";
        $kab_filter = "";
        $kab_filter = $auth->kdkab; // 00 supaya gagal jadi memilih kabkot dulu
        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        $keyword = $request->keyword;
        $keyword = str_replace(" ", "%20", $keyword);

        // Mengambil Data Table
        $filter_url = '&kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter . '&sls_filter=' . $sls_filter . '&keyword=' . $keyword;
        $petugas_url = 'http://st23.bpssumsel.com/api/petugas/data/rekap';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($petugas_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];
        if ($result) {
            $data = $result['data']['data'];
            $links = $result['data']['links'];
        }

        // Mengambil List Kabkot
        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.dash_target', compact(
            'auth',
            'request',
            'data',
            'links',
            'kabs',
            'api_token',
            'target_hari_ini'
        ));
    }
    public function koseka(Request $request)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $list_kab_filter = "";
        $kab_filter = "";
        $kab_filter = $auth->kdkab; // supaya gagal jadi memilih kabkot dulu
        if ($auth->kdkab != "00") {
            $list_kab_filter = $auth->kdkab;
        }
        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }

        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        // $keyword = $request->keyword;
        // $keyword = str_replace(" ", "%20", $keyword);
        $filter_url = '&kab_filter=' . $kab_filter;
        $petugas_url = 'http://st23.bpssumsel.com/api/dashboard_koseka';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($petugas_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        // $links = [];
        if ($result) {
            $data = $result['datas'];
            // $links = $result['data']['links'];
        }
        // dd($data);
        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.dash_koseka', compact(
            'auth',
            'request',
            'data',
            'kabs',
            'api_token',
        ));
    }
    public function pendampingan(Request $request)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }
        //////
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }
        ///

        $list_kab_filter = "";
        $kab_filter = $auth->kdkab; //00 supaya gagal jadi memilih kabkot dulu
        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        // $keyword = $request->keyword;
        // $keyword = str_replace(" ", "%20", $keyword);

        // Mengambil Data Table
        $filter_url = '&kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter . '&sls_filter=' . $sls_filter;
        $data_url = 'http://st23.bpssumsel.com/api/dashboard_pendampingan';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];
        if ($result) {
            $data = $result['datas']['data'];
            $links = $result['datas']['links'];
        }
        // dd($result);
        // Mengambil List Filter Kabkot
        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.dash_pendampingan', compact(
            'auth',
            'request',
            'data',
            'links',
            'kabs',
            'api_token',
        ));
    }

    public function petugas(Request $request)
    {
        $auth = Auth::user();
        $list_kab_filter = "";
        $kab_filter = "";
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }
        if ($auth->kdkab != "00") {
            $kab_filter = $auth->kdkab;
            $list_kab_filter = $auth->kdkab;
        }
        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        $keyword = $request->keyword;
        $keyword = str_replace(" ", "%20", $keyword);
        $filter_url = '&kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter . '&sls_filter=' . $sls_filter . '&keyword=' . $keyword;
        $petugas_url = 'http://st23.bpssumsel.com/api/petugas';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($petugas_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];

        if ($result) {
            $data = $result['data']['data'];
            $links = $result['data']['links'];
        }

        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.user', compact(
            'auth',
            'request',
            'data',
            'links',
            'kabs',
            'api_token',
            // 'list_roles'
        ));
    }

    public function petugas_show($id)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $data_url = 'http://st23.bpssumsel.com/api/petugas' . "/" . $id;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        if ($result) {
            $data = $result['data'];
        }

        $roles_url = 'https://st23.bpssumsel.com/api/list_roles';
        $ch = curl_init($roles_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $list_roles = [];
        if ($result) {
            $list_roles = $result['data'];
        }

        return view('dashboard.st2023.user_show', compact(
            'data',
            'api_token',
            'list_roles',
        ));
    }

    public function petugas_sls($id)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $data_url = 'http://st23.bpssumsel.com/api/petugas_sls/' . $id;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($data_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];
        if ($result) {
            $data = $result['data']['data'];
            $links = $result['data']['links'];
        }
        return view('dashboard.st2023.user_sls', compact(
            'auth',
            'id',
            'data',
            'links',
            'api_token',
        ));
    }

    public function alokasi(Request $request)
    {
        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }
        $list_kab_filter = "";
        $kab_filter = "";
        if ($auth->kdkab != "00") {
            $kab_filter = $auth->kdkab;
            $list_kab_filter = $auth->kdkab;
        }

        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        // $kab_filter = $request->kab_filter;
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        $keyword = $request->keyword;
        $keyword = str_replace(" ", "%20", $keyword);
        $filter_url = '&kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter . '&sls_filter=' . $sls_filter . '&keyword=' . $keyword;
        $sls_url = 'http://st23.bpssumsel.com/api/alokasi';
        $page = '?page=' . $request->page;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($sls_url . $page . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        $links = [];

        if ($result) {
            // dd($result);
            $data = $result['datas']['data'];
            $links = $result['datas']['links'];
        }

        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.alokasi', compact(
            'auth',
            'request',
            'data',
            'links',
            'kabs',
            'api_token'
        ));
    }

    public function alokasi_show($id)
    {

        $auth = Auth::user();
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = "http://st23.bpssumsel.com/api/login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $alokasi_url = 'http://st23.bpssumsel.com/api/alokasi' . "/" . $id;
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($alokasi_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $data = [];
        if ($result) {
            $data = $result['data'];
        }

        $petugas_url = 'http://st23.bpssumsel.com/api/list_petugas?kab_filter=' . $data['kode_kab'];
        $headers = [
            'Authorization: Bearer ' . $api_token,
            'Content-Type: application/json',
        ];
        $ch = curl_init($petugas_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_petugas = curl_exec($ch);
        curl_close($ch);
        $result_petugas = json_decode($result_petugas, true);
        $list_pcl = [];
        $list_pml = [];
        $list_koseka = [];
        if ($result_petugas) {
            $list_pcl = $result_petugas['data']['list_pcl'];
            $list_pml = $result_petugas['data']['list_pml'];
            $list_koseka = $result_petugas['data']['list_koseka'];
        }

        // dd($result_petugas);

        return view('dashboard.st2023.alokasi_show', compact(
            'data',
            'api_token',
            'list_pcl',
            'list_pml',
            'list_koseka'
        ));
    }

    public function daftar_ruta(Request $request)
    {
        $auth = Auth::user();
        // $base_url = "http://localhost:8000/api/";
        $base_url = "https://st23.bpssumsel.com/api/";
        if (session('api_token')) {
            $api_token = session('api_token');
        } else {
            $login_url = $base_url . "login";
            $data = [
                'email' => 'admin' . $auth->kdkab . '@bpssumsel.com',
                'password' => '123456',
            ];
            $ch = curl_init($login_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error
            } else {
                $responseData = json_decode($response, true);
                session(['api_token' => $responseData['data']['access_token']]);
                $api_token = session('api_token');
            }
        }

        $list_kab_filter = "";
        $kab_filter = "";
        if ($auth->kdkab != "00") {
            $kab_filter = $auth->kdkab;
            $list_kab_filter = $auth->kdkab;
        }

        if ($request->kab_filter) {
            $kab_filter = $request->kab_filter;
        }
        // $kab_filter = $request->kab_filter;
        $kec_filter = $request->kec_filter;
        $desa_filter = $request->desa_filter;
        $sls_filter = $request->sls_filter;
        $keyword = $request->keyword;
        $keyword = str_replace(" ", "%20", $keyword);

        $kabs_url = 'https://st23.bpssumsel.com/api/list_kabs?kab_filter=' . $list_kab_filter;
        $ch = curl_init($kabs_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $kabs = [];
        if ($result) {
            $kabs = $result['data'];
        }

        return view('dashboard.st2023.daftar_ruta', compact(
            'auth',
            'request',
            'kabs',
            'kab_filter',
            'api_token',
            'base_url'
        ));
    }

    // index Dashbaord Regsosek
    public function index2(Request $request)
    {
        $random_user = \App\UserModel::inRandomOrder()->first();
        $unit_kerja = \App\UnitKerja::where('kode', '=', $random_user->kdprop . $random_user->kdkab)->first();
        $dl_per_uk = \App\UnitKerja::rekapDlPerUk();
        //////REGSOSEK
        //////////////
        $label = 'prov';
        $label_kab = '';
        $label_kec = '';
        $label_desa = '';
        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');
        $bs = $request->get('bs');
        if (strlen($kab) == 0) $kab = null;
        if (strlen($kec) == 0) $kec = null;
        if (strlen($desa) == 0) $desa = null;
        if (strlen($bs) == 0) $bs = null;
        $model = new \App\RegsosekSls();
        if ($bs != null) {
            $label = 'bs';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nmKec;

            $model_desa = \App\Pdesa::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec],
                ['idDesa', '=', $desa],
            ])->first();
            if ($model_desa != null) $label_desa = $model_desa->nmDesa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        } else if ($bs == null && $desa != null) {
            $label = 'desa';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nmKec;

            $model_desa = \App\Pdesa::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec],
                ['idDesa', '=', $desa],
            ])->first();
            if ($model_desa != null) $label_desa = $model_desa->nmDesa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        } else if ($bs == null && $desa == null && $kec != null) {
            $label = 'kec';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nmKec;

            $datas = $model->Rekapitulasi($kab, $kec);
        } else if ($bs == null && $desa == null && $kec == null && $kab != null) {
            $label = 'kab';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $datas = $model->Rekapitulasi($kab);
        } else {
            $datas = $model->Rekapitulasi();
        }
        $labels = [];
        $persens = [];
        // foreach ($datas as $key => $data) {
        //     $labels[] = $data->nama;
        //     $persen = 100;

        //     if ($data->total == 0) $persen = 0;
        //     else $persen = round(($data->terlapor / $data->total * 100), 3);

        //     $persens[] = $persen;
        // }
        /////////////
        return view('dashboard.index', compact(
            'random_user',
            'unit_kerja',
            'dl_per_uk',
            'model',
            'datas',
            'labels',
            'persens',
            'kab',
            'kec',
            'desa',
            'bs',
            'label',
            'label_kab',
            'label_kec',
            'label_desa'
        ));
    }

    public function lfsp2020(Request $request)
    {
        //////////////
        $label = 'prov';

        $label_kab = '';
        $label_kec = '';
        $label_desa = '';

        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');
        $bs = $request->get('bs');

        if (strlen($kab) == 0) $kab = null;
        if (strlen($kec) == 0) $kec = null;
        if (strlen($desa) == 0) $desa = null;
        if (strlen($bs) == 0) $bs = null;
        $model = new \App\Sp2020LfBs();
        $model_c2 = new \App\Sp2020LfRt();

        if ($bs != null) {
            $label = 'bs';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nmKec;

            $model_desa = \App\Pdesa::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec],
                ['idDesa', '=', $desa],
            ])->first();
            if ($model_desa != null) $label_desa = $model_desa->nmDesa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
            $datas_c2 = $model_c2->Rekapitulasi($kab, $kec, $desa, $bs);
        } else if ($bs == null && $desa != null) {
            $label = 'desa';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nmKec;

            $model_desa = \App\Pdesa::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec],
                ['idDesa', '=', $desa],
            ])->first();
            if ($model_desa != null) $label_desa = $model_desa->nmDesa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
            $datas_c2 = $model_c2->Rekapitulasi($kab, $kec, $desa);
        } else if ($bs == null && $desa == null && $kec != null) {
            $label = 'kec';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nmKec;

            $datas = $model->Rekapitulasi($kab, $kec);
            $datas_c2 = $model_c2->Rekapitulasi($kab, $kec);
        } else if ($bs == null && $desa == null && $kec == null && $kab != null) {
            $label = 'kab';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nmKab;

            $datas = $model->Rekapitulasi($kab);
            $datas_c2 = $model_c2->Rekapitulasi($kab);
        } else {
            $datas = $model->Rekapitulasi();
            $datas_c2 = $model_c2->Rekapitulasi();
        }

        $labels = [];
        $persens = [];

        $labels_c2 = [];
        $persens_c2 = [];

        foreach ($datas as $key => $data) {
            $labels[] = $data->nama;
            $persen = 100;

            if ($data->total == 0) $persen = 0;
            else $persen = round(($data->terlapor / $data->total * 100), 3);

            $persens[] = $persen;
        }

        foreach ($datas_c2 as $key => $data) {
            $labels_c2[] = $data->nama;
            $persen = 100;
            if ($data->total == 0) $persen = 0;
            // else $persen = round(($data->terlapor/($datas[$key]->total*16)*100),3);

            $persens_c2[] = $persen;
        }

        /////////////

        // return view('dashboard.index',compact(
        //     'random_user', 'unit_kerja', 'dl_per_uk'));

        return view('dashboard.index', compact(
            'random_user',
            'unit_kerja',
            'dl_per_uk',
            'model',
            'datas',
            'labels',
            'persens',
            'model_c2',
            'datas_c2',
            'labels_c2',
            'persens_c2',
            'kab',
            'kec',
            'desa',
            'bs',
            'label',
            'label_kab',
            'label_kec',
            'label_desa'
        ));
    }

    public function rekap_dl(Request $request)
    {
        $year = date('Y');
        $month = date('m');
        $uk = '00';
        $list_libur = [];

        if (strlen($request->get('month')) > 0)
            $month = $request->get('month');

        if (strlen($request->get('year')) > 0)
            $year = $request->get('year');

        if (strlen($request->get('uk')) > 0)
            $uk = $request->get('uk');

        $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 1; $i <= $d; $i++) {
            $hari = date('N', strtotime($year . '-' . $month . '-' . $i));
            if ($hari >= 6) {
                $list_libur[] = $i;
            }
        }

        // $datas = \App\SuratTugasRincian::rekapUnitKerja($uk, $month, $year);
        $result = \App\SuratTugasRincian::rekapUnitKerja($uk, $month, $year);
        $datas = [];
        $model = new \App\UserModel;

        foreach ($result as $key => $value) {
            $datas[] = (object) array_merge((array) $value, ['total_dl' => $model->getJumlahDlByNip($value->nip, $year)]);
        }

        return view('dashboard.rekap_dl', compact(
            'datas',
            'month',
            'year',
            'uk',
            'list_libur'
        ));
    }

    public function profile($id)
    {
        $year = date('Y');
        $real_id = Crypt::decrypt($id);
        $model = \App\UserModel::where('nip_baru', '=', $real_id)->first();
        $ckp_bulanan = new \App\CkpLogBulanan;
        $list_ckp = $ckp_bulanan->RekapCkpPegawaiPerTahun($model->email, $year);
        $result_ckp = [];
        for ($i = 1; $i <= 12; ++$i) {
            $name = 'bulan' . $i;
            $result_ckp[] = $list_ckp[0]->$name;
        }

        $data_st = \App\SuratTugasRincian::where([
            ['nip', '=', $real_id], ['status_aktif', '<>', '2']
        ])
            ->where(
                (function ($query) use ($year) {
                    $query->where(DB::raw('YEAR(tanggal_mulai)'), '=', $year)
                        ->orWhere(DB::raw('YEAR(tanggal_selesai)'), '=', $year);
                })
            )
            ->with('SuratIndukRel')
            ->orderBy('id', 'desc')
            ->get();
        // dd($model->email);
        $riwayat_sk = RiwayatSK::where('niplama', $model->email)->orderby('tmt', 'desc')->get();
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model->kdprop . $model->kdkab)->first();
        // dd($list_ckp[0]);
        return view('dashboard.profile', compact(
            'id',
            'model',
            'unit_kerja',
            'result_ckp',
            'data_st',
            'riwayat_sk'
        ));
    }

    public function pegawai($id){
        $model = \App\UserModel::where('email', '=', $id)->first();
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model->kdprop . $model->kdkab)->first();
      
        return view('dashboard.pegawai', compact(
            'id',
            'model',
            'unit_kerja',
        ));
    }
}
