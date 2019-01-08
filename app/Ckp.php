<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ckp extends Model
{
    protected $table = 'ckps';

    public function attributes()
    {
        return (new \App\Http\Requests\CkpRequest())->attributes();
    }

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function getListTypeAttribute()
    {
        return array(1 => 'CKP-T', 2 => 'CKP-R');
    }
    
    public function getListJenisAttribute()
    {
        return array(1 => 'Kegiatan Utama', 2 => 'Kegiatan Tambahan');
    }

    public function CkpBulanan($type, $bulan, $year){
        // $sql = "SELECT mp.id as pos_id, mp.name, GROUP_CONCAT(
                    //         DISTINCT CONCAT(ap.title," : ", ip.data) 
                    //         ) as rincian_form, GROUP_CONCAT(ap.title), GROUP_CONCAT(ip.data) FROM relasi_pos rp
                    // RIGHT JOIN `master_pos` as mp ON mp.id = rp.pos_id
                    //     JOIN `attribute_pos` as ap ON ap.id = rp.attribute_pos_id
                    //     LEFT JOIN `input_pos` as ip ON ip.relasi_id = rp.id
                    //     GROUP BY mp.id, mp.name";

        return DB::table('ckps')
            // ->rightJoin('master_pos', 'master_pos.id', '=', 'relasi_pos.pos_id')
            // ->join('attribute_pos', 'attribute_pos.id', '=', 'relasi_pos.attribute_pos_id')
            // ->leftJoin('input_pos', function($join) use ($tanggal, $shift)
            //     {
            //         $join->on('input_pos.relasi_id', '=', 'relasi_pos.id');
            //         $join->on('input_pos.shift_no','=',DB::raw($shift));
            //         $join->on('input_pos.tanggal','=',DB::raw("'$tanggal'"));
            //     })
            ->where([
                ['ckps.month', '=', $bulan],
                ['ckps.year', '=', $year],
                ['ckps.type', '=', $type],
            ])
            ->orderBy('ckps.jenis')
            ->get();
    }
}
