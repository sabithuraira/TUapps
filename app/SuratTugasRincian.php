<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratTugasRincian extends Model
{
    protected $table = 'surat_tugas_rincian';
    
    public function SuratIndukRel()
    {
        return $this->hasOne('App\SuratTugas', 'id', 'id_surtug');
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
            1 => "<div class='badge badge-info'>Sedang Berjalan</div>", 
            3 => "<div class='badge badge-warning'>Kelengkapan sudah di bagian administrasi</div>", 
            4 => "<div class='badge badge-warning'>Kwitansi telah dibuat</div>", 
            5 => "<div class='badge badge-warning'>Konfirmasi PPK</div>", 
            6 => "<div class='badge badge-warning'>Proses Pembayaran</div>", 
            7 => "<div class='badge badge-success'>Sudah dibayar</div>",
        );
    }

    public function getListLabelStatusAttribute()
    {
        return array(
            1 => "Sedang Berjalan", 
            3 => "Kelengkapan sudah di bagian administrasi", 
            4 => "Kwitansi telah dibuat", 
            5 => "Konfirmasi PPK", 
            6 => "Proses Pembayaran", 
            7 => "Sudah dibayar",
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
