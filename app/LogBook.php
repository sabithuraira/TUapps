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

    public function LogBookRekap($start_date, $end_date, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->where([
                ['log_books.tanggal', '>=', $start_date],
                ['log_books.tanggal', '<=', $end_date],
                ['log_books.user_id', '=', $user_id],
            ])
            ->orderBy('log_books.tanggal')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'user_id'           =>$value->user_id,
                'tanggal'           =>date('d M Y', strtotime($value->tanggal)),
                'real_tanggal'      =>date('m/d/Y', strtotime($value->tanggal)),
                'waktu_mulai'       =>date('h:i', strtotime($value->waktu_mulai)),
                'waktu_selesai'     =>date('h:i', strtotime($value->waktu_selesai)),
                'isi'               =>$value->isi,
                'hasil'             =>$value->hasil,
                'catatan_pimpinan'  =>$value->catatan_pimpinan,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
                'ckp_id'            =>$value->ckp_id,
            );
        }

        return $result;
    }
}
