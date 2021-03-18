<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Sp2020Export implements FromView
{
    public function __construct($kab, $kec, $desa)
    {
        $this->kab = $kab;
        $this->kec = $kec;
        $this->desa = $desa;
    }

    public function view(): View
    {
        $model = new \App\Sp2020Sls();
        if($this->desa!=null){
            $datas = $model->Rekapitulasi($this->kab, $this->kec, $this->desa);
        }
        else if($this->desa==null && $this->kec!=null){
            $datas = $model->Rekapitulasi($this->kab, $this->kec);    
        }
        else if($this->desa==null && $this->kec==null && $this->kab!=null){
            $datas = $model->Rekapitulasi($this->kab); 
        }
        else{
            $datas = $model->Rekapitulasi(); 
        }

        $labels = [];
        $persens = [];

        foreach($datas as $key=>$data){
            $labels[] = $data->nama;
            $persen = 0;
            if($data->target_penduduk>0) $persen = round(($data->realisasi_penduduk/$data->target_penduduk*100),3);
            $persens[] = $persen;
        }

        return view('exports.sp2020', [
            'datas' => $datas,
            'model' => $model,
            'labels'=> $labels,
            'persens'   => $persens,
            'kab'   => $this->kab,
            'kec'   => $this->kec,
            'desa' => $this->desa
        ]);
    }
}