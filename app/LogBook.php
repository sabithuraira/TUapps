<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LogBook extends Model
{
    protected $table = 'log_books';

    public function attributes()
    {
        return (new \App\Http\Requests\LogBookRequest())->attributes();
    }

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    //rekap per unit kerja per hari
    public function RekapPerUnitKerjaPerHari($unit_kerja, $tanggal, $separate=' <br/> '){
        $str_where = "kdkab = '$unit_kerja'";

        if($unit_kerja==111) $str_where = "kdesl='2' || kdesl='3'";

        $sql = "SELECT u.id, u.name, u.nip_baru, u.kdorg,  u.kdesl,
            GROUP_CONCAT(log_books.isi SEPARATOR '$separate') isi, 
            GROUP_CONCAT(log_books.hasil SEPARATOR '$separate') hasil
            
            FROM `users` u 
            LEFT JOIN log_books ON log_books.user_id=u.email AND  log_books.tanggal='$tanggal'
            
            WHERE $str_where
            GROUP BY u.id, u.name, u.nip_baru, u.kdorg , u.kdesl
            ORDER by kdorg";
            
        $result = DB::select(DB::raw($sql));
        return $result;
    }

    //rekap per pegawai dalam rentang waktu tertentu
    public function LogBookRekap($start_date, $end_date, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->where([
                ['log_books.tanggal', '>=', $start_date],
                ['log_books.tanggal', '<=', $end_date],
                ['log_books.user_id', '=', $user_id],
            ])
            ->orderBy('log_books.tanggal', 'desc')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'user_id'           =>$value->user_id,
                'tanggal'           =>date('d M Y', strtotime($value->tanggal)),
                'real_tanggal'      =>date('m/d/Y', strtotime($value->tanggal)),
                'waktu_mulai'       =>date('H:i', strtotime($value->waktu_mulai)),
                'waktu_selesai'     =>date('H:i', strtotime($value->waktu_selesai)),
                'isi'               =>$value->isi,
                'hasil'             =>$value->hasil,
                'catatan_pimpinan'  =>$value->catatan_pimpinan,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
                'ckp_id'            =>$value->ckp_id,
                'volume'            =>$value->volume,
                'satuan'            =>$value->satuan,
                'pemberi_tugas'     =>$value->pemberi_tugas,
                'status_penyelesaian' =>$value->status_penyelesaian,
            );
        }

        return $result;
    }
}
