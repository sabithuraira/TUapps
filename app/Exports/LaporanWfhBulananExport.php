<?php 

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanWfhBulananExport implements WithMultipleSheets
{
    // use Exportable;

    public $bulan;
    public $tahun;
    public $user_id;
    
    public function __construct($bulan, $tahun, $user_id)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->user_id = $user_id;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $total_day = cal_days_in_month(CAL_GREGORIAN,$this->bulan,$this->tahun);

        for ($i = 1; $i <= $total_day; $i++) {
            $sheets[] = new LaporanWfhExport($this->tahun."-".$this->bulan."-".$i, $this->user_id);
        }

        return $sheets;
    }
}
