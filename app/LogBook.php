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
    
    public function getListApproveAttribute()
    {
        return array(1 => 'Sudah disetujui', 2 => 'Belum disetujui');
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
                'tanggal'           =>$value->tanggal,
                'isi'               =>$value->isi,
                'catatan_approve'   =>$value->catatan_approve,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
                'waktu'             =>$value->waktu,
            );
        }

        // print_r($result);die();

        return $result;
    }
}
