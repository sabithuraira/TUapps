<?php

namespace App\Http\Controllers;

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

        $random_user = UserModel::inRandomOrder()->first();
        $unit_kerja = UnitKerja::where('kode', '=', $random_user->kdprop . $random_user->kdkab)->first();

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
        // $wilayah_url = 'https://st23.bpssumsel.com/api/progress?kab_filter=' . $kab_filter . '&kec_filter=' . $kec_filter . '&desa_filter=' . $desa_filter . '&sls_filter=' . $sls_filter;
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
        if ($wilayah_result) {
            $data_wilayah = $wilayah_result['data'];
            if (isset($data_wilayah[0]['nama_kab'])) {
                $label_kab = $data_wilayah[0]['nama_kab'];
            }
            if (isset($data_wilayah[0]['nama_kec'])) {
                $label_kec = $data_wilayah[0]['nama_kec'];
            }
            if (isset($data_wilayah[0]['nama_desa'])) {
                $label_desa = $data_wilayah[0]['nama_desa'];
            }
            if (isset($data_wilayah[0]['nama_sls'])) {
                $label_sls = $data_wilayah[0]['nama_sls'];
            }
        }

        // dd($data_wilayah);
        $ch = curl_init($kk_url . $filter_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $kk_result = curl_exec($ch);
        curl_close($ch);
        $kk_result = json_decode($kk_result, true);
        $data_kk = [];
        if ($kk_result) {
            $data_kk = $kk_result['data'];
        }


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
        return view('dashboard.index', compact(
            'random_user',
            'unit_kerja',
            'dl_per_uk',
            'request',
            'label_kab',
            'label_kec',
            'label_desa',
            'label_sls',
            'data_wilayah',
            'data_kk',
            'data_dokumen',
        ));
    }

    // index Dashbaord Regsosek
    // public function index(Request $request){
    //     $random_user = \App\UserModel::inRandomOrder()->first();
    //     $unit_kerja = \App\UnitKerja::where('kode', '=', $random_user->kdprop.$random_user->kdkab)->first();
    //     $dl_per_uk = \App\UnitKerja::rekapDlPerUk();
    //     //////REGSOSEK
    //     //////////////
    //     $label = 'prov';
    //     $label_kab = '';
    //     $label_kec = '';
    //     $label_desa = '';
    //     $kab = $request->get('kab');
    //     $kec = $request->get('kec');
    //     $desa = $request->get('desa');
    //     $bs = $request->get('bs');
    //     if (strlen($kab) == 0) $kab = null;
    //     if (strlen($kec) == 0) $kec = null;
    //     if (strlen($desa) == 0) $desa = null;
    //     if (strlen($bs) == 0) $bs = null;
    //     $model = new \App\RegsosekSls();
    //     if ($bs != null) {
    //         $label = 'bs';
    //         $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
    //         if ($model_kab != null) $label_kab = $model_kab->nmKab;

    //         $model_kec = \App\Pkec::where([
    //             ['idKab', '=', $kab],
    //             ['idKec', '=', $kec]
    //         ])->first();
    //         if ($model_kec != null) $label_kec = $model_kec->nmKec;

    //         $model_desa = \App\Pdesa::where([
    //             ['idKab', '=', $kab],
    //             ['idKec', '=', $kec],
    //             ['idDesa', '=', $desa],
    //         ])->first();
    //         if ($model_desa != null) $label_desa = $model_desa->nmDesa;

    //         $datas = $model->Rekapitulasi($kab, $kec, $desa);
    //     } else if ($bs == null && $desa != null) {
    //         $label = 'desa';
    //         $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
    //         if ($model_kab != null) $label_kab = $model_kab->nmKab;

    //         $model_kec = \App\Pkec::where([
    //             ['idKab', '=', $kab],
    //             ['idKec', '=', $kec]
    //         ])->first();
    //         if ($model_kec != null) $label_kec = $model_kec->nmKec;

    //         $model_desa = \App\Pdesa::where([
    //             ['idKab', '=', $kab],
    //             ['idKec', '=', $kec],
    //             ['idDesa', '=', $desa],
    //         ])->first();
    //         if ($model_desa != null) $label_desa = $model_desa->nmDesa;

    //         $datas = $model->Rekapitulasi($kab, $kec, $desa);
    //     } else if ($bs == null && $desa == null && $kec != null) {
    //         $label = 'kec';
    //         $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
    //         if ($model_kab != null) $label_kab = $model_kab->nmKab;

    //         $model_kec = \App\Pkec::where([
    //             ['idKab', '=', $kab],
    //             ['idKec', '=', $kec]
    //         ])->first();
    //         if ($model_kec != null) $label_kec = $model_kec->nmKec;

    //         $datas = $model->Rekapitulasi($kab, $kec);
    //     } else if ($bs == null && $desa == null && $kec == null && $kab != null) {
    //         $label = 'kab';
    //         $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
    //         if ($model_kab != null) $label_kab = $model_kab->nmKab;

    //         $datas = $model->Rekapitulasi($kab);
    //     } else {
    //         $datas = $model->Rekapitulasi();
    //     }
    //     $labels = [];
    //     $persens = [];
    //     // foreach ($datas as $key => $data) {
    //     //     $labels[] = $data->nama;
    //     //     $persen = 100;

    //     //     if ($data->total == 0) $persen = 0;
    //     //     else $persen = round(($data->terlapor / $data->total * 100), 3);

    //     //     $persens[] = $persen;
    //     // }
    //     /////////////
    //     return view('dashboard.index', compact(
    //         'random_user',
    //         'unit_kerja',
    //         'dl_per_uk',
    //         'model',
    //         'datas',
    //         'labels',
    //         'persens',
    //         'kab',
    //         'kec',
    //         'desa',
    //         'bs',
    //         'label',
    //         'label_kab',
    //         'label_kec',
    //         'label_desa'
    //     ));
    // }

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

        // print_r($datas_c2);die();

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
}
