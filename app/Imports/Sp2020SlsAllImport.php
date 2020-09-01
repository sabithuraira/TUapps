<?php
namespace App\Imports;

use App\Sp2020Sls;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class Sp2020SlsAllImport implements  ToModel
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // if (strlen($row[4])==16) {
        //     $model_sls = \App\Sp2020Sks::where('id_sls', '=', $row[4])->first();
        //     if($model_sls!=null){
        //         return new Sp2020Sls([
        //             'kd_prov'       => substr($row[4],0,2),
        //             'kd_kab'        => substr($row[4],2,2),
        //             'kd_kec'        => substr($row[4],4,3),
        //             'kd_desa'       => substr($row[4],7,3),
        //             'id_sls'        => $row[4],
        //             'dp_j_penduduk' => (strlen($row[5])>0) ? $row[5] : 0,
        //             'target_penduduk' => (strlen($row[5])>0) ? $row[5] : 0,
        //             'peta_j_keluarga' => (strlen($row[10])>0) ? $row[10] : 0,
        //         ]);
        //     }
        //     else{
        //         return null;
        //     }
        // }
        // else{
        //     return null;
        // }

        if (strlen($row[4])!=6) {
            return null;
        }

        $id_sls = $row[0].$row[1].$row[2].$row[3].$row[4].$row[5];
        if(strlen($id_sls)==16){
            $id_sls = $id_sls.'00';
        }

        return new Sp2020Sls([
            'kd_prov'       => $row[0],
            'kd_kab'        => $row[1],
            'kd_kec'        => $row[2],
            'kd_desa'       => $row[3],
            'id_sls'        => $row[0].$row[1].$row[2].$row[3].$row[4].$row[5],
            // 'dp_j_penduduk' => (strlen($row[8])>0) ? $row[8] : 0,
            // 'target_penduduk' => (strlen($row[8])>0) ? $row[8] : 0,
            'dp_j_penduduk' => (strlen($row[21])>0) ? $row[21] : 0,
            'target_penduduk' => (strlen($row[21])>0) ? $row[21] : 0,
            'realisasi_penduduk' => 0,
            'peta_j_keluarga' =>(strlen($row[14])>0) ? $row[14] : 0,
            'nama_sls'  => $row[6],
        ]);
    }
}