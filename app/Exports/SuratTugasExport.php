<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class SuratTugasExport implements FromView
{
    public function __construct($unit_kerja, $month, $year, $keyword)
    {
        $this->unit_kerja = $unit_kerja;
        $this->month = $month;
        $this->year = $year;
        $this->keyword = $keyword;
    }

    public function view(): View
    {
        $model = new \App\SuratTugasRincian();
        
        $arr_where = [];

        $arr_where[] = [\DB::raw('status_aktif'), '<>', '2'];

        if(strlen($this->month)>0){
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $this->month];
        }
        
        if(strlen($this->year)>0){
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $this->year];
        }

        $uk = $this->unit_kerja;
        $kw = $this->keyword;

        $datas = \App\SuratTugasRincian::where($arr_where)
                ->where(
                    (function ($query) use ($uk) {
                        $query-> where('unit_kerja', '=', $uk)
                        ->orWhere('unit_kerja_ttd', '=', $uk)
                        ->orWhere('unit_kerja_spd', '=', $uk);
                    })
                )
                ->where(
                    (function ($query) use ($kw) {
                        $query-> where('nama', 'LIKE', '%' . $kw . '%')
                        ->orWhere('tujuan_tugas', 'LIKE', '%' . $kw . '%')
                        ->orWhere('nomor_st', 'LIKE', '%' . $kw . '%');
                    })
                )
                ->with('SuratIndukRel')
                ->orderBy('id', 'desc')
                ->get();

        return view('exports.surat_tugas', [
            'datas' => $datas,
        ]);
    }
}