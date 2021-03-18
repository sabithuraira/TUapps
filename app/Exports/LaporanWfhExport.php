<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanWfhExport implements FromView, ShouldAutoSize, WithTitle
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

        return view('exports.laporan_wfh', [
            'datas' => $datas,
            'user'  => $user,
            'tanggal'   => $this->tanggal,
        ]);
    }

    public function title(): string
    {
        return date("d F", strtotime($this->tanggal));
    }
}