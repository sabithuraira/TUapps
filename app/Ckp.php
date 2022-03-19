<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ckp extends Model
{
    protected $table = 'ckps';

    public function attributes(){
        return (new \App\Http\Requests\CkpRequest())->attributes();
    }

    public function User(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function IkiRel(){
        return $this->hasOne('App\Iki', 'id', 'iki');
    }
    
    public function getListTypeAttribute(){
        return array(1 => 'CKP-T', 2 => 'CKP-R');
    }
    
    public function getListJenisAttribute(){
        return array(1 => 'Kegiatan Utama', 2 => 'Kegiatan Tambahan');
    }

    public function CkpBulanan($type, $bulan, $year,$user){
        $datas = array();

        $datas['utama'] = DB::table('ckps')
            ->leftJoin('iki', 'ckps.iki', '=', 'iki.id')
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
                ['ckps.user_id', '=', $user],
            ])
            ->select('ckps.*', 'iki.iki_label')
            ->orderBy('ckps.jenis')
            ->get();
            
        $datas['tambahan'] = DB::table('ckps')
            ->leftJoin('iki', 'ckps.iki', '=', 'iki.id')
            ->where([
                ['ckps.month', '=', $bulan],
                ['ckps.year', '=', $year],
                ['ckps.type', '=', $type],
                ['ckps.jenis', '=', 2],
                ['ckps.user_id', '=', $user],
            ])
            ->select('ckps.*', 'iki.iki_label')
            ->orderBy('ckps.jenis')
            ->get();

        return $datas;
    }

    public function CkpBulananTim($type, $bulan, $year,$user){
        $result = [];

        $datas = DB::table('ckps')
            ->leftJoin('iki', 'ckps.iki', '=', 'iki.id')
            ->leftJoin('users', 'ckps.user_id', '=', 'users.email')
            ->where([
                ['ckps.month', '=', $bulan],
                ['ckps.year', '=', $year],
                ['ckps.type', '=', $type],
                ['ckps.pemberi_tugas_id', '=', $user],
            ])
            ->select('ckps.*', 'iki.iki_label', 'users.name', 'users.nmjab')
            ->orderBy('ckps.user_id')
            ->get();

        // foreach($datas as $key=>$value){
        //     $result[] = array(
        //         'angka_kredit'      => $value->angka_kredit,
        //         'catatan_koreksi'      => $value->catatan_koreksi,
        //         'created_at'      => $value->created_at,
        //         'created_by'      => $value->created_by,
        //         'id'      => $value->id,
        //         'iki'      => $value->iki,
        //         'iki_label'      => $value->iki_label,
        //         'jenis'      => $value->jenis,
        //         'kecepatan'      => $value->kecepatan,
        //         'ketepatan'      => $value->ketepatan,
        //         'keterangan'      => $value->keterangan,
        //         'ketuntasan'      => $value->ketuntasan,
        //         'kode_butir'      => $value->kode_butir,
        //         'kualitas'      => $value->kualitas,
        //         'month'      => $value->month,
        //         'name'      => $value->name,
        //         'nmjab'      => $value->nmjab,
        //         'pemberi_tugas_id'      => $value->pemberi_tugas_id,
        //         'pemberi_tugas_jabatan'      => $value->pemberi_tugas_jabatan,
        //         'pemberi_tugas_nama'      => $value->pemberi_tugas_nama,
        //         'penilaian_pimpinan'      => $value->penilaian_pimpinan,
        //         'realisasi_kuantitas'      => $value->realisasi_kuantitas,
        //         'satuan'      => $value->satuan,
        //         'target_kuantitas'      => $value->target_kuantitas,
        //         'type'      => $value->type,
        //         'updated_at'      => $value->updated_at,
        //         'updated_by'      => $value->updated_by,
        //         'uraian'      => $value->uraian,
        //         'user_id'      => $value->user_id,
        //         'year'      => $value->year,
        //     );
        // }

        // return $result;
        return $datas;
    }
}
