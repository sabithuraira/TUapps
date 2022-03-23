<?php
namespace App\Imports;

use App\Sp2020LfBs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class Sp2020LfPartialImport implements ToCollection
{
    use Importable;
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            if (strlen($row[1])==14) {
                $model = Sp2020LfBs::where('idbs', '=' , $row[1])->first();
    
                if($model==null){
                    $model = new Sp2020LfBs;
                }
                else{
                    $model->kode_sls    = ';'.$row[10];
                    $model->nama_sls    = ';'.$row[11];
                }
                
                $idbs = $row[1];
                $kd_prov = substr($idbs, 0,2);
                $kd_kab = substr($idbs, 2,2);
                $kd_kec = substr($idbs, 4,3);
                $kd_desa = substr($idbs, 7,3);
                
                $model->kd_prov     = $kd_prov;
                $model->kd_kab      = $kd_kab;
                $model->kd_kec      = $kd_kec;
                $model->kd_desa     = $kd_desa;
                $model->idbs       = $idbs;
                $model->nks         = $row[7];
                $model->jenis_sampel= $row[8];
                $model->jumlah_kk_lama = $row[9];
                $model->save();
            }
        }
    }
}