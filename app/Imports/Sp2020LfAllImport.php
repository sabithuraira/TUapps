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
        if (strlen($row[1])!=14) {
            return null;
        }

        $idbs = $row[0];
        $kd_prov = substr($idbs, 0,2);
        $kd_kab = substr($idbs, 2,2);
        $kd_kec = substr($idbs, 4,3);
        $kd_desa = substr($idbs, 7,3);

        
    // protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
    // 'kd_desa', 'idbs', 'jumlah_ruta', 'jumlah_laki', 
    // 'jumlah_perempuan', 'jumlah_ruta_ada_mati', 'nks', 
    // 'jenis_sampel', 'jumlah_kk_lama', 'nama_sls'

        return new Sp2020LfBs([
            'kd_prov'       => $kd_prov,
            'kd_kab'        => $kd_kab,
            'kd_kec'        => $kd_kec,
            'kd_desa'       => $kd_desa,
            'idbs'          => $idbs,
            'nks'           => $row[7],
            'jenis_sampel'  => $row[8],
            'jumlah_kk_lama'=> $row[9],
            'kode_sls'      => $row[10],
            'nama_sls'      => $row[11],
        ]);
    }
}