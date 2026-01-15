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
        $str_where = "kdkab = '$unit_kerja' AND is_active=1";

        if($unit_kerja==111) $str_where = "kdesl='2' || kdesl='3'";

        $sql = "SELECT u.id, u.name, u.nip_baru, u.kdorg,  u.kdesl,
            GROUP_CONCAT(log_books.isi SEPARATOR '$separate') isi, 
            GROUP_CONCAT(log_books.hasil SEPARATOR '$separate') hasil
            
            FROM `users` u 
            LEFT JOIN log_books ON (log_books.user_id=u.email AND  log_books.tanggal='$tanggal' 
                AND (log_books.is_rencana=0 OR log_books.is_rencana IS NULL))
            
            WHERE $str_where
            GROUP BY u.id, u.name, u.nip_baru, u.kdorg , u.kdesl
            ORDER by kdorg";
            
        $result = DB::select(DB::raw($sql));
        return $result;
    }

    public  function RekapUkerPerBulan($unit_kerja, $month, $year){
        $sql = "SELECT u.id, u.name, u.nip_baru, COUNT(log_books.id) as total_logbook
            FROM `users` u 
            LEFT JOIN log_books ON (log_books.user_id=u.email 
            	AND MONTH(log_books.tanggal)=$month 
                AND YEAR(log_books.tanggal)=$year 
                AND (log_books.is_rencana=0 OR log_books.is_rencana IS NULL))
            
            WHERE u.kdkab = '$unit_kerja' 
            	AND u.is_active=1
            GROUP BY u.id, u.name, u.nip_baru
            ORDER by total_logbook DESC";

        $result = DB::select(DB::raw($sql));
        return $result;
    }

    //rekap per pegawai dalam rentang waktu tertentu
    public function LogBookRekap($start_date, $end_date, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->where(
                [
                    ['log_books.tanggal', '>=', $start_date],
                    ['log_books.tanggal', '<=', $end_date],
                    ['log_books.user_id', '=', $user_id],
                ]

                // (function ($query) {
                //     $query->where('log_books.tanggal', '>=', $start_date)
                //         ->Where('log_books.tanggal', '<=', $end_date)
                //         ->Where('log_books.user_id', '=', $user_id);
                // })
            )
            ->where(
                (function ($query) {
                    $query->where('log_books.is_rencana', '=', 0)
                        ->orWhereNull('log_books.is_rencana');
                })
            )
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
                'pemberi_tugas_id'     =>$value->pemberi_tugas_id,
                'pemberi_tugas_jabatan'     =>$value->pemberi_tugas_jabatan,
                'status_penyelesaian' =>$value->status_penyelesaian,
                'jumlah_jam' =>$value->jumlah_jam,
            );
        }

        return $result;
    }

    //rekap per pegawai dalam rentang waktu tertentu
    public function RencanaKerjaRekap($start_date, $end_date, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->where([
                ['log_books.tanggal', '>=', $start_date],
                ['log_books.tanggal', '<=', $end_date],
                ['log_books.user_id', '=', $user_id],
                ['log_books.is_rencana', '=', 1],
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
                'pemberi_tugas_id'     =>$value->pemberi_tugas_id,
                'pemberi_tugas_jabatan'     =>$value->pemberi_tugas_jabatan,
                'status_penyelesaian' =>$value->status_penyelesaian,
                'jumlah_jam' =>$value->jumlah_jam,
            );
        }

        return $result;
    }

    //rekap tim
    public function LogBookRekapTim($month, $year, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->leftJoin('users', 'log_books.user_id', '=', 'users.email')
            ->where(
                [
                    [\DB::raw('MONTH(tanggal)'), '=', $month],
                    [\DB::raw('YEAR(tanggal)'), '=', $year],
                    ['log_books.pemberi_tugas_id', '=', $user_id],
                ]
            )
            ->where(
                (function ($query) {
                    $query->where('log_books.is_rencana', '=', 0)
                        ->orWhereNull('log_books.is_rencana');
                })
            )
            ->select('log_books.*', 'users.name', 'users.nmjab')
            ->orderBy('log_books.tanggal', 'desc')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'user_id'           =>$value->user_id,
                'user_name'           =>$value->name,
                'user_nmjab'           =>$value->nmjab,
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
                'pemberi_tugas_id'     =>$value->pemberi_tugas_id,
                'pemberi_tugas_jabatan'     =>$value->pemberi_tugas_jabatan,
                'status_penyelesaian' =>$value->status_penyelesaian,
                'jumlah_jam' =>$value->jumlah_jam,
            );
        }

        return $result;
    }
}
