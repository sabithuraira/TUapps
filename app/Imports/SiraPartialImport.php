<?php
namespace App\Imports;

use App\SiraAkun;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class SiraPartialImport implements ToCollection
{
    use Importable;
    public $tahun;

    public function __construct($tahun) {
        $this->tahun = $tahun;
    }

    public function collection(Collection $rows){
        foreach ($rows as $row) 
        {
            if($row[1]!==null){
                $model = new \App\SiraAkun;
                $model->kode_mak= $row[0];
                $model->mak= $row[1];
                $model->kode_akun= $row[2];
                $model->akun= $row[3];
                $model->tahun = $this->tahun;
                $model->created_by=Auth::id();
                $model->updated_by=Auth::id();
                $model->save();
            }
        }
    }
}