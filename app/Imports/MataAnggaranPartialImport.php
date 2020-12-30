<?php
namespace App\Imports;

use App\MataAnggaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class MataAnggaranPartialImport implements ToCollection
{
    use Importable;
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row[1]!==null){
                $model = new \App\MataAnggaran;
                $model->kode_uker = Auth::user()->kdprop.Auth::user()->kdkab;
                $model->kode_program = $row[0];
                $model->label_program = $row[1];
                $model->kode_aktivitas = $row[2];
                $model->label_aktivitas = $row[3];
                $model->kode_kro = $row[4];
                $model->label_kro = $row[5];
                $model->kode_ro = $row[6];
                $model->label_ro = $row[7];
                $model->kode_komponen = $row[8];
                $model->label_komponen = $row[9];
                $model->kode_subkomponen = $row[10];
                $model->label_subkomponen = $row[11];
                $model->tahun = date('Y');
                $model->created_by=Auth::id();
                $model->updated_by=Auth::id();
                $model->save();
            }
        }
    }
}