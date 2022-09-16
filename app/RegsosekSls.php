<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegsosekSls extends Model
{
    protected $table = 'regsosek_sls';
    
    protected $fillable = ['kode_prov', 'kode_kab', 'kode_kec',
        'kode_desa', 'id_sls', 'id_sub_sls', 'nama_sls', 
        'jenis_sls', 'j_keluarga_sls', 'j_keluarga_pcl', 'j_keluarga_pml'
        , 'j_keluarga_kosek', 'status_selesai_pcl', 'j_tidak_miskin'
        , 'j_miskin', 'j_sangat_miskin', 'j_nr', 'kode_pcl'
        , 'kode_pml', 'kode_koseka', 'status_sls'];
}
