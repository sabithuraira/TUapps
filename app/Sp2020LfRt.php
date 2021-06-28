<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sp2020LfRt extends Model
{
    protected $table = 'sp2020lf_rt';
    
    protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
        'kd_desa', 'idbs', 'status_rt', 'nama_krt', 
        'pendidikan_krt', 'jumlah_laki', 'jumlah_perempuan'
        , 'jumlah_perempuan_1549', 'jumlah_mati'];
}
