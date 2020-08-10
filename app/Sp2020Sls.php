<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Sp2020Sls extends Model
{
    protected $table = 'sp2020_sls';
    
    protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
        'kd_desa', 'id_sls', 'dp_j_penduduk', 'target_penduduk', 
        'realisasi_penduduk', 'peta_j_keluarga', 'updated_phone'];
    
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
