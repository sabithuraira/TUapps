<?php
namespace App\Imports;

use App\Sp2020LfBs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class Sp2020LfAllImport implements ToModel
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (strlen($row[0])!=14) {
            return null;
        }

        $idbs = $row[0];
        $kd_prov = substr($idbs, 0,2);
        $kd_kab = substr($idbs, 2,2);
        $kd_kec = substr($idbs, 4,3);
        $kd_desa = substr($idbs, 7,3);

        return new Sp2020LfBs([
            'kd_prov'       => $kd_prov,
            'kd_kab'        => $kd_kab,
            'kd_kec'        => $kd_kec,
            'kd_desa'       => $kd_desa,
            'idbs'          => $idbs,
        ]);
    }
}