<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LogBookExport implements FromView
{
    public $tanggal;
    public $unit_kerja;

    public function __construct($tanggal, $unit_kerja)
    {
        $this->tanggal = $tanggal;
        $this->unit_kerja = $unit_kerja;
    }

    public function view(): View
    {
        $model = new \App\LogBook;
        $datas = $model->RekapPerUnitKerjaPerHari($this->unit_kerja, $this->tanggal, 'bps1600bps');

        return view('exports.log_book', [
            'datas' => $datas
        ]);
    }
}