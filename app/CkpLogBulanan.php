<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CkpLogBulanan extends Model
{
    protected $table = 'ckp_log_bulanan';

     public function triggerCkp($user_id, $month, $year, $is_atasan=0){
        DB::statement('call updatePersediaan(?, ?, ?, ?, ?, ?, ?)',[$m, $y, $id_barang, $nama_barang, $user_id, $next_month, $next_year]);
    }
}
