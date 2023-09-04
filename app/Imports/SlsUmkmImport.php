<?php
namespace App\Imports;

use App\SlsUmkm;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class SlsUmkmImport implements ToModel
{
    use Importable;
    use Importable;

    public function model(array $row)
    {
        if (strlen($row[0])!=2) {
            return null;
        }

        $id_sls = str_replace(' ', '', $row[4]);

        return new SlsUmkm([
            'kode_prov'       => $row[0],
            'kode_kab'        => $row[1],
            'kode_kec'        => $row[2],
            'kode_desa'       => $row[3],
            'id_sls'        => substr($row[4],0,4),
            'id_sub_sls'        => substr($row[4],4,2),
            'nama_sls'      => $row[5],
            'sls_op' => 1,
            'jenis_konsentrasi' => 1, 
            'jml_kk' => 0, 
            'no_urut_usaha_terbesar' => 0, 
            'jml_koperasi' => 0, 
            "status_selesai" => 0,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}