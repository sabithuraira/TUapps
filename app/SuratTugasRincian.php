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
        return array( 
			1 => 'Kendaraan Umum', 
			2 => 'Kendaraan Dinas',
			3 => 'Kendaraan Dinas',
		);
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

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}

	public function isAvailable($nip, $t_start, $t_end){
		$sql="SELECT count(*) as total FROM surat_tugas_rincian WHERE nip='".$nip."' 
			AND (('".$t_start."' BETWEEN tanggal_mulai AND tanggal_selesai) OR 
			('".$t_end."' BETWEEN tanggal_mulai AND tanggal_selesai) OR 
			(tanggal_mulai>'".$t_start."' AND tanggal_selesai<'".$t_end."'))";

		$result = DB::select(DB::raw($sql));
        return $result;
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
