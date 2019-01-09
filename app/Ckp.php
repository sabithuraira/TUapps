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
        $datas = array();

        $datas['utama'] = DB::table('ckps')
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
                ['ckps.jenis', '=', 1],
            ])
            ->orderBy('ckps.jenis')
            ->get();
            
        $datas['tambahan'] = DB::table('ckps')
            ->where([
                ['ckps.month', '=', $bulan],
                ['ckps.year', '=', $year],
                ['ckps.type', '=', $type],
                ['ckps.jenis', '=', 2],
            ])
            ->orderBy('ckps.jenis')
            ->get();

        return $datas;
    }
}
