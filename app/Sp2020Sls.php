<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RincianKredit extends Model
{
    protected $table = 'sp2020_sls';
    
    public function attributes()
    {
        return [
            'kd_prov' => 'Provinsi',
            'kd_kab' => 'Kabupaten',
            'kd_kec' => 'Kecamatan',
            'kd_desa' => 'Desa',
            'id_sls' => 'ID SLS/Non SLS',
            'dp_j_penduduk' => 'Jumlah Penduduk DP',
            'target_penduduk' => 'target_penduduk',
            'realisasi_penduduk' => 'realisasi_penduduk',
            'peta_j_keluarga' => 'Jumlah Keluarga Pemetaan',
            'updated_phone' => 'Diupdate oleh',
        ];
    }
}
