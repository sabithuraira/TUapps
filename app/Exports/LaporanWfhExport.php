<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanWfhExport implements FromView
{
    public $tanggal;
    public $user_id;

    public function __construct($tanggal, $user_id)
    {
        $this->tanggal = $tanggal;
        $this->user_id = $user_id;
    }

    public function view(): View
    {
        $model = new \App\LogBook;
        $datas = $model->LogBookRekap($this->tanggal, $this->tanggal, $this->user_id);
        
        $user = \App\User::where('email', '=', $this->user_id)->first();

        // print_r($datas);die();

        return view('exports.laporan_wfh', [
            'datas' => $datas,
            'user'  => $user,
            'tanggal'   => $this->tanggal,
        ]);
    }
}