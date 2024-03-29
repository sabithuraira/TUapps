<?php
namespace App\Imports;

use App\PesSt2023;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class PesSt2023Import implements ToModel
{
    use Importable;
    use Importable;

    public function model(array $row)
    {
        if (strlen($row[0])!=2) {
            return null;
        }

        // $id_sls = $row[0].$row[1].$row[2].$row[3].$row[4];
        // if(strlen($id_sls)==16){
        //     $id_sls = $id_sls.'00';
        // }

        $id_sls = str_replace(' ', '', $row[4]);

        return new PesSt2023([
            'kode_prov'       => $row[0],
            'kode_kab'        => $row[1],
            'kode_kec'        => $row[2],
            'kode_desa'       => $row[3],
            'id_sls'        => substr($row[4],0,4),
            'id_sub_sls'        => substr($row[4],4,2),
            'nama_sls'  => $row[5],
            'sls_op'    => 1,
            'jenis_sls' => ($row[9]=="Konsentrasi") ? 1 : 2,
            'jml_ruta_tani' => $row[7],
            'jml_art_tani' => 0,
            'jml_ruta_pes' => 0,
            'jml_art_pes' => 0,
            'status_selesai' => 0,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}