<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BsPemetaan2025Export implements FromView
{
    public $kab;
    public $kec;
    public $desa;

    public function __construct($kab, $kec, $desa){
        $this->kab = $kab;
        $this->kec = $kec;
        $this->desa = $desa;
    }

    public function view(): View
    {
        $arr_cond = [];

        if($this->kab!=null){
            $arr_cond[] = ['kode_kab', '=', $this->kab];
            
            if($this->kec!=null){
                $arr_cond[] = ['kode_kec', '=', $this->kec];
                
                if($this->desa!=null){
                    $arr_cond[] = ['kode_desa', '=', $this->desa];
                }
            }
        }
        
        $datas = \App\Models\BsPemetaan2025::where($arr_cond)->get();

        return view('exports.bs_pemetaan2025', [
            'datas' => $datas,
        ]);
    }
}