<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $random_user = \App\UserModel::inRandomOrder()->first();
        $unit_kerja = \App\UnitKerja::where('kode', '=', $random_user->kdprop.$random_user->kdkab)->first();
        $dl_per_uk = \App\UnitKerja::rekapDlPerUk();

        //////////////
        $label = 'prov';

        $label_kab = ''; $label_kec = ''; $label_desa = '';

        $kab = $request->get('kab'); $kec = $request->get('kec'); $desa = $request->get('desa');

        if(strlen($kab)==0) $kab = null;
        if(strlen($kec)==0) $kec = null;
        if(strlen($desa)==0) $desa = null;
        $model = new \App\Sp2020LfBs();

        if($desa!=null){
            $label = 'desa';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if($model_kab!=null) $label_kab = $model_kab->nmKab;
            
            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if($model_kec!=null) $label_kec = $model_kec->nmKec;
            
            $model_desa = \App\Pdesa::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec],
                ['idDesa', '=', $desa],
            ])->first();
            if($model_desa!=null) $label_desa = $model_desa->nmDesa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        }
        else if($desa==null && $kec!=null){
            $label = 'kec';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if($model_kab!=null) $label_kab = $model_kab->nmKab;
            
            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if($model_kec!=null) $label_kec = $model_kec->nmKec;

            $datas = $model->Rekapitulasi($kab, $kec);    
        }
        else if($desa==null && $kec==null && $kab!=null){
            $label = 'kab';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if($model_kab!=null) $label_kab = $model_kab->nmKab;

            $datas = $model->Rekapitulasi($kab); 
        }
        else{
            $datas = $model->Rekapitulasi(); 
        }

        // $labels = [];
        // $persens = [];

        foreach($datas as $key=>$data){
            $labels[] = $data->nama;
            $persen = 100;
            $persen = round(($data->terlapor/$data->total*100),3);
            
            $persens[] = $persen;
        }

        /////////////

        // return view('dashboard.index',compact(
        //     'random_user', 'unit_kerja', 'dl_per_uk'));
        
        return view('dashboard.index',compact(
            'random_user', 'unit_kerja', 'dl_per_uk', 
            'model', 'datas', 'labels', 'persens', 
            'kab', 'kec', 'desa', 'label',
            'label_kab', 'label_kec', 'label_desa'));
    }

    public function rekap_dl(Request $request){
        $year = date('Y');
        $month = date('m');
        $uk = '00';
        $list_libur = [];

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');

        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        if(strlen($request->get('uk'))>0)
            $uk = $request->get('uk');
    
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
        for($i=1;$i<=$d;$i++){
            $hari = date('N', strtotime($year.'-'.$month.'-'.$i));
            if($hari >= 6){
                $list_libur[] = $i;
            }
        }

        // $datas = \App\SuratTugasRincian::rekapUnitKerja($uk, $month, $year);
        $result = \App\SuratTugasRincian::rekapUnitKerja($uk, $month, $year);
        $datas = [];
        $model = new \App\UserModel;

        foreach($result as $key=>$value){
            $datas[] = (object) array_merge((array) $value, ['total_dl' => $model->getJumlahDlByNip($value->nip)]);
        }

        return view('dashboard.rekap_dl',compact(
            'datas', 'month', 'year', 'uk', 'list_libur'));
    }

    public function profile($id){
        $year = date('Y');
        $real_id = Crypt::decrypt($id);
        $model = \App\UserModel::where('nip_baru', '=', $real_id)->first();
        $ckp_bulanan = new \App\CkpLogBulanan;
        $list_ckp = $ckp_bulanan->RekapCkpPegawaiPerTahun($model->email, $year);
        $result_ckp = [];
        for($i=1;$i<=12;++$i){
            $name = 'bulan'.$i;
            $result_ckp[] = $list_ckp[0]->$name;
        }

        $data_st = \App\SuratTugasRincian::where([
                ['nip', '=', $real_id], ['status_aktif', '<>', '2']
            ])
            ->where(
                (function ($query) use ($year) {
                    $query->where(\DB::raw('YEAR(tanggal_mulai)'), '=', $year)
                        ->orWhere(\DB::raw('YEAR(tanggal_selesai)'), '=', $year);
                })
            )
            ->with('SuratIndukRel')
            ->orderBy('id', 'desc')
            ->get();

        $unit_kerja = \App\UnitKerja::where('kode', '=', $model->kdprop.$model->kdkab)->first();
        // dd($list_ckp[0]);
        return view('dashboard.profile', compact(
            'id', 'model', 'unit_kerja', 'result_ckp', 'data_st'
        ));
    }
}
