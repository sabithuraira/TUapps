<?php
namespace App\Imports;

use App\Sp2020LfBs;
use App\RegsosekSls;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class RegsosekPartialImport implements ToCollection
{
    use Importable;
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            // print_r($row);die();
            if (strlen($row[1])==10 && strlen($row[11])==4 && strlen($row[12])==2) {
                // print_r($row);die();
        // 'jenis_sls', 'j_keluarga_sls', 'j_keluarga_pcl', 'j_keluarga_pml'
        // , 'j_keluarga_kosek', 'status_selesai_pcl', 'j_tidak_miskin'
        // , 'j_miskin', 'j_sangat_miskin', 'j_nr', 'kode_pcl'
        // , 'kode_pml', 'kode_koseka', 'status_sls'

                $model = RegsosekSls::where('kode_desa', '=' , $row[1])
                            ->where('id_sls', '=', $row[11])
                            ->where('id_sub_sls', '=', $row[12])
                            ->where('status_sls', '=', 1)->first();

                $id_desa = $row[1];
                $kd_prov = substr($id_desa, 0,2);
                $kd_kab = substr($id_desa, 2,2);
                $kd_kec = substr($id_desa, 4,3);
                $kd_desa = substr($id_desa, 7,3);
    
                if($model==null){
                    $model = new RegsosekSls;
                    $model->kode_prov = $kd_prov;
                    $model->kode_kab = $kd_kab;
                    $model->kode_kec = $kd_kec;
                    $model->kode_desa = $kd_desa;
                    $model->id_sls = $row[11];
                    $model->id_sub_sls = $row[12];
                }

                $model->nama_sls = $row[13];
                if(strlen($row[14])>0) $model->sls_op = 1;
                else $model->sls_op = 0;

                if($row[15]=='SLS') $model->jenis_sls = 1;
                else $model->jenis_sls = 2;

                $model->j_keluarga_sls = $row[17];
                $model->status_sls = 1;

                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();

                // print_r($model);die();
                $model->save();
            }
        }
    }
}