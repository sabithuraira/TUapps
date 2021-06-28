<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp2020LfBs extends Model
{
    protected $table = 'sp2020lf_bs';
    
    protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
        'kd_desa', 'idbs', 'jumlah_ruta', 'jumlah_laki', 
        'jumlah_perempuan', 'jumlah_ruta_ada_mati'];
}
