<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SlsUmkm extends Model
{
    protected $table = 'sls_umkm';
    
    protected $fillable = ['kode_prov', 'kode_kab', 'kode_kec',
        'kode_desa', 'id_sls', 'id_sub_sls', 'nama_sls', 'sls_op',
        'jenis_konsentrasi', 
        'jml_kk', 'no_urut_usaha_terbesar', 'jml_koperasi'
        , "status_selesai", 'created_by', 'updated_by'];
}
