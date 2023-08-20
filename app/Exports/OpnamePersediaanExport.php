<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class OpnamePersediaanExport implements FromView, ShouldAutoSize, WithTitle{
    public $month;
    public $year;

    public function __construct($month, $year){
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        // $model = new \App\LogBook;
        // $datas = $model->LogBookRekap($this->tanggal, $this->tanggal, $this->user_id);
        
        // $user = \App\User::where('email', '=', $this->user_id)->first();

        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $last_day_month  = date('t', mktime(0, 0, 0, $month, 10));

        $prevMonthName = date("F", mktime(0, 0, 0, ($month-1), 10));
        $last_day_prev_month  = date('t', mktime(0, 0, 0, ($month-1), 10));

        $model = new \App\Opnamepersediaan();
        $datas = $model->OpnameRekap($this->month, $this->year);

        return view('exports.opname_persediaan', [
            // 'datas' => $datas,
            // 'user'  => $user,
            // 'tanggal'   => $this->tanggal,
            'month' => $this->month, 
            'year' => $this->year, 
            'datas' => $this->datas , 
            'monthName' => $this->monthName, 
            'last_day_month'=> $this->last_day_month,
            'prevMonthName'=> $this->prevMonthName, 
            'last_day_prev_month'=> $this->last_day_prev_month
        ]);
    }

    public function title(): string
    {
        $nama_file = 'opname_persediaan_';
        $nama_file .= $this->month .'_'.$this->year.'_'. '.pdf';
        return $nama_file;
    }
}