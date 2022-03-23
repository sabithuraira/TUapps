<?php
namespace App\Imports;

use App\Sp2020LfBs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class Sp2020LfPenggantiImport implements ToCollection
{
    use Importable;
    public function collection(Collection $rows){
        foreach ($rows as $key=>$row) {
            if (strlen($row[1])==14) {
                $model = Sp2020LfBs::where('idbs', '=' , $row[1])->first();
    
                $jenis = 1;//1=pengganti, 0=diganti
                $kode_hasil = substr($row[9],0,1);
                
                if($kode_hasil=='G') $jenis = 0;
                else if($kode_hasil=='P') $jenis = 1;
                else $jenis = 2;


                if($jenis==0){
                    if($model!=null){
                        $model->delete();
                    }
                }
                else if($jenis==1){
                    print_r($kode_hasil);
                    print_r($jenis);
                    print_r($key);die();
                    if($model==null){
                        $model = new Sp2020LfBs;
                    }
                    else{
                        $model->kode_sls    = '';
                        $model->nama_sls    = '';
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
                    $model->jumlah_kk_lama = 0;
                    $model->save();
                }
            }
        }
    }
}