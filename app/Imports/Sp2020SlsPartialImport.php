<?php
namespace App\Imports;

use App\Sp2020Sls;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class Sp2020SlsPartialImport implements ToCollection
{
    use Importable;
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {

            // User::create([
            //     'name' => $row[0],
            // ]);

            // $model = \App\UserModel::where('email', '=', $user_id)->first();
            $model = Sp2020Sls::where('id_sls', '=' , $row[0])->first();

            if($model!=null){
                $model->target_penduduk = $row[1];
                $model->realisasi_penduduk = $row[2];
                $model->save();
            }

            // Sp2020Sls([
            //     'kd_prov'       => $row[0],
            //     'kd_kab'        => $row[1],
            //     'kd_kec'        => $row[2],
            //     'kd_desa'       => $row[3],
            //     'id_sls'        => $row[0].$row[1].$row[2].$row[3].$row[4].$row[5],
            //     // 'dp_j_penduduk' => (strlen($row[8])>0) ? $row[8] : 0,
            //     // 'target_penduduk' => (strlen($row[8])>0) ? $row[8] : 0,
            //     'dp_j_penduduk' => (strlen($row[21])>0) ? $row[21] : 0,
            //     'target_penduduk' => (strlen($row[21])>0) ? $row[21] : 0,
            //     'realisasi_penduduk' => 0,
            //     'peta_j_keluarga' =>(strlen($row[14])>0) ? $row[14] : 0,
            //     'nama_sls'  => $row[6],
            // ]);
        }
    }
}