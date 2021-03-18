<<<<<<< HEAD
<?php 
=======
<?php
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864

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
<<<<<<< HEAD
        
=======

>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
        $arr_where = [];

        $arr_where[] = [\DB::raw('status_aktif'), '<>', '2'];

<<<<<<< HEAD
        if(strlen($this->month)>0){
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $this->month];
        }
        
        if(strlen($this->year)>0){
=======
        if (strlen($this->month) > 0) {
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $this->month];
        }

        if (strlen($this->year) > 0) {
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $this->year];
        }

        $uk = $this->unit_kerja;
        $kw = $this->keyword;

        $datas = \App\SuratTugasRincian::where($arr_where)
<<<<<<< HEAD
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
=======
            ->where(
                (function ($query) use ($uk) {
                    $query->where('unit_kerja', '=', $uk)
                        ->orWhere('unit_kerja_ttd', '=', $uk)
                        ->orWhere('unit_kerja_spd', '=', $uk);
                })
            )
            ->where(
                (function ($query) use ($kw) {
                    $query->where('nama', 'LIKE', '%' . $kw . '%')
                        ->orWhere('tujuan_tugas', 'LIKE', '%' . $kw . '%')
                        ->orWhere('nomor_st', 'LIKE', '%' . $kw . '%');
                })
            )
            ->with('SuratIndukRel')
            ->orderBy('id', 'desc')
            ->get();
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864

        return view('exports.surat_tugas', [
            'datas' => $datas,
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
