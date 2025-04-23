<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IzinKeluar extends Model
{
    protected $table = 'izin_keluar';

    public function attributes()
    {
        return (new \App\Http\Requests\IzinKeluarRequest())->attributes();
    }

    public function Pegawai()
    {
        return $this->hasOne('App\User', 'nip_baru', 'pegawai_nip');
    }

    public function ReportBulanan($month, $year, $kode_kab){
        $sql = "SELECT SUM(total_minutes) jumlah_menit, users.name, users.nip_baru 
                    FROM `users` 
                    LEFT JOIN izin_keluar ON (users.nip_baru=izin_keluar.pegawai_nip 
                                AND MONTH(izin_keluar.tanggal)='$month' 
                                AND YEAR(izin_keluar.tanggal)='$year')
                    WHERE kdkab='$kode_kab' AND is_active=1 
                    GROUP BY users.name, users.nip_baru
                    ORDER BY jumlah_menit DESC;";
            
        $result = DB::select(DB::raw($sql));
        return $result;
    }

    //rekap per pegawai dalam rentang waktu tertentu
    public function IzinKeluarRekap($month, $year, $user_id){
        $result = array();
        $datas = array();

        $arr_condition = [
            [\DB::raw('MONTH(tanggal)'), '=', $month],
            [\DB::raw('YEAR(tanggal)'), '=', $year]
        ];
        
        if($user_id!='') $arr_condition[] = ['izin_keluar.pegawai_nip', '=', $user_id];

        $datas = DB::table('izin_keluar')
            ->leftJoin('users', 'izin_keluar.pegawai_nip', '=', 'users.nip_baru')
            ->where($arr_condition)
            ->select('izin_keluar.*', 'users.name')
            ->orderBy('izin_keluar.tanggal', 'desc')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'pegawai_nip'       =>$value->pegawai_nip,
                'name'              => $value->name,
                'kode_prov'         =>$value->kode_prov,
                'kode_kab'          =>$value->kode_kab,
                'tanggal'           => date('d M Y', strtotime($value->tanggal)),
                'start'             => ($value->start!=null) ? date('H:i', strtotime($value->start)) : "...",
                'end'               => ($value->end!=null) ? date('H:i', strtotime($value->end)) : "...",
                'total_minutes'     =>$value->total_minutes,
                'keterangan'        =>$value->keterangan,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
            );
        }

        return $result;
    }
}
