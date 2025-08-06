<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Wilkerstat2025Controller extends Controller
{
    public function wilkerstat2025(Request $request){
        //////////////
        $label = 'prov';
        $label_kab = '';
        $label_kec = '';
        $label_desa = '';
        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');
        $sls = $request->get('sls');
        if (strlen($kab) == 0) $kab = null;
        if (strlen($kec) == 0) $kec = null;
        if (strlen($desa) == 0) $desa = null;
        if (strlen($sls) == 0) $sls = null;

        $model = new \App\Models\BsPemetaan2025();
        if ($sls != null) {
            $label = 'sls';
            $model_kab = \App\Models\Kabs::where('id_kab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nama_kab;

            $model_kec = \App\Models\Kecs::where([
                ['id_kab', '=', $kab],
                ['id_kec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nama_kec;

            $model_desa = \App\Models\Desas::where([
                ['id_kab', '=', $kab],
                ['id_kec', '=', $kec],
                ['id_desa', '=', $desa],
            ])->first();
            if ($model_desa != null) $label_desa = $model_desa->nama_desa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        } else if ($sls == null && $desa != null) {
            $label = 'desa';
            $model_kab = \App\Models\Kabs::where('id_kab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nama_kab;

            $model_kec = \App\Models\Kecs::where([
                ['id_kab', '=', $kab],
                ['id_kec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nama_kec;

            $model_desa = \App\Models\Desas::where([
                ['id_kab', '=', $kab],
                ['id_kec', '=', $kec],
                ['id_desa', '=', $desa],
            ])->first();
            if ($model_desa != null) $label_desa = $model_desa->nama_desa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        } else if ($sls == null && $desa == null && $kec != null) {
            $label = 'kec';
            $model_kab = \App\Models\Kabs::where('id_kab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nama_kab;

            $model_kec = \App\Models\Kecs::where([
                ['id_kab', '=', $kab],
                ['id_kec', '=', $kec]
            ])->first();
            if ($model_kec != null) $label_kec = $model_kec->nama_kec;

            $datas = $model->Rekapitulasi($kab, $kec);
        } else if ($sls == null && $desa == null && $kec == null && $kab != null) {
            $label = 'kab';
            $model_kab = \App\Models\Kabs::where('id_kab', '=', $kab)->first();
            if ($model_kab != null) $label_kab = $model_kab->nama_kab;

            $datas = $model->Rekapitulasi($kab);
        } else {
            $datas = $model->Rekapitulasi();
        }
        $labels = [];
        $persens = [];

        /////////////
        // return view('dashboard.index', compact(
        //     'random_user',
        //     'unit_kerja',
        //     'dl_per_uk',
        //     'model',
        //     'datas',
        //     'labels',
        //     'persens',
        //     'kab',
        //     'kec',
        //     'desa',
        //     'bs',
        //     'label',
        //     'label_kab',
        //     'label_kec',
        //     'label_desa'
        // ));

        return response()->json(['success'=>'Sukses', 
            'datas'=>$datas,
            'labels' => $labels,
            'persens'=> $persens,
            'kab' => $kab,
            'kec'=> $kec,
            'desa' => $desa,
            'sls' => $sls,
            'label' => $label,
            'label_kab' => $label_kab,
            'label_kec' => $label_kec,
            'label_desa' => $label_desa
        ]);
    }

    public function download(Request $request){
        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');
        $sls = $request->get('sls');
        if (strlen($kab) == 0) $kab = null;
        if (strlen($kec) == 0) $kec = null;
        if (strlen($desa) == 0) $desa = null;
        if (strlen($sls) == 0) $sls = null;    
       
        return Excel::download(new \App\Exports\BsPemetaan2025Export($kab, $kec, $desa), 'sls_wilkerstat2025.xlsx');
    }
}
