<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratTugasRincian extends Model
{
    protected $table = 'surat_tugas_rincian';
    
    public function PegawaiRel()
    {
        return $this->hasOne('App\User', 'email', 'pegawai_id');
    }

    public function attributes()
    {
        return (new \App\Http\Requests\SuratTugasRincianRequest())->attributes();
	}
	
    public function getListTingkatBiayaAttribute()
    {
        return array(
            1 => 'B', 2 => 'C', 3 => 'D'
        );
	}
	
    public function getListKendaraanAttribute()
    {
        return array( 1 => 'Kendaraan Umum', 2 => 'Kendaraan Dinas',);
    }
    
    public function getListStatusAttribute()
    {
        return array(
            0 => "<div class='badge badge-warning'>Belum</div>", 
            1 => "<div class='badge badge-success'>Selesai</div>", 
        );
    }

    // public function listKegiatanByMonth($month){
	// 	$curr_year=date('Y');

	// 	$sql="SELECT u.id, u.email, u.name, DAY(tanggal_mulai) as mulai, 
	// 		DAY(tanggal_selesai) as berakhir, j.nama_kegiatan
	// 		FROM surat_tugas j, users u 
	// 		WHERE 
	// 		(YEAR(tanggal_mulai)='".$curr_year."' OR YEAR(tanggal_selesai)='".$curr_year."') AND 
	// 		(MONTH(tanggal_mulai)='".$month."' OR MONTH(tanggal_selesai)='".$month."') AND 
	// 		j.pegawai_id=u.email 
	// 		ORDER BY tanggal_selesai DESC, tanggal_mulai DESC 
	// 		LIMIT 1000;";

    //     $result = DB::select(DB::raw($sql));
	// 	return $result;
	// }
}
