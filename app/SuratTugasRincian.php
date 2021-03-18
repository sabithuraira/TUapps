<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratTugasRincian extends Model
{
	protected $table = 'surat_tugas_rincian';
	protected $appends = ["kategori_petugas"];
<<<<<<< HEAD
    
    public function SuratIndukRel()
    {
        return $this->hasOne('App\SuratTugas', 'id', 'id_surtug');
    }

    public function attributes()
    {
        return (new \App\Http\Requests\SuratTugasRincianRequest())->attributes();
	}
=======

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
			1 => 'A', 2 => 'B', 3 => 'C'
		);
	}
<<<<<<< HEAD

	public function getListKendaraanAttribute()
	{
		return array(
			1 => 'Kendaraan Umum',
=======
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
	
    public function getListTingkatBiayaAttribute()
    {
        return array(
<<<<<<< HEAD
            1 => 'A', 2 => 'B', 3 => 'C'
=======
            0=> '', 1 => 'A', 2 => 'B', 3 => 'C'
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
        );
    }
	
    public function getListKendaraanAttribute()
    {
        return array( 
<<<<<<< HEAD
			1 => 'Kendaraan Umum', 
=======
			0 => '',
			1 => 'Kendaraan Umum', 
>>>>>>> 7d546657ff7a33cbe62a91e7aaabd26a7c81ab7a
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
			2 => 'Kendaraan Dinas',
			3 => 'Kendaraan Pesawat',
		);
	}

	public function getListKategoriPetugasAttribute()
<<<<<<< HEAD
    {
        return array( 
			1 => 'Ketua', 
			2 => 'Anggota',
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
            7 => "<div class='badge badge-success'>Sudah dibayar/selesai</div>",
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
            7 => "Sudah dibayar/selesai",
        );
    }

    function penyebut($nilai) {
=======
	{
		return array(
			1 => 'Ketua',
			2 => 'Anggota',
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
			7 => "<div class='badge badge-success'>Sudah dibayar/selesai</div>",
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
			7 => "Sudah dibayar/selesai",
		);
	}

	function penyebut($nilai)
	{
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
<<<<<<< HEAD
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " Ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " Ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " Juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " Milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "Minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}

	public function isAvailable($nip, $t_start, $t_end){
		$sql="SELECT count(sr.id) as total 
=======
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = $this->penyebut($nilai - 10) . " Belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai / 10) . " Puluh" . $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai / 100) . " Ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai / 1000) . " Ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai / 1000000) . " Juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai / 1000000000) . " Milyar" . $this->penyebut(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai / 1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
		}
		return $temp;
	}

	public function terbilang($nilai)
	{
		if ($nilai < 0) {
			$hasil = "Minus " . trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}
		return $hasil;
	}

	public function isAvailable($nip, $t_start, $t_end)
	{
		$sql = "SELECT count(sr.id) as total 
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
			FROM surat_tugas_rincian as sr, surat_tugas as s  
			WHERE 
			sr.id_surtug = s.id AND s.mak IS NOT NULL AND 
			s.jenis_st <> 4 AND
<<<<<<< HEAD
			nip='".$nip."' AND status_aktif<>2 
			AND  (('".$t_start."' BETWEEN tanggal_mulai AND tanggal_selesai) OR 
			('".$t_end."' BETWEEN tanggal_mulai AND tanggal_selesai) OR 
			(tanggal_mulai>'".$t_start."' AND tanggal_selesai<'".$t_end."'))";

		$result = DB::select(DB::raw($sql));
        return $result;
	}

	public static function rekapUnitKerja($uk, $month, $year){
		$d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		
		$label_select = [];
		$label_case = [];

		for($i=1;$i<=$d;$i++){
			$label_select[] = 'day'.$i;
			$label_case[] = "COUNT(CASE WHEN ($i BETWEEN DAY(tanggal_mulai) AND DAY(tanggal_selesai)) THEN 0 END) AS day".$i;
		}
		
		$sql = "SELECT nip, nama, ".join(",", $label_select)."
			FROM (
				SELECT users.id, nip_baru as nip, users.name as nama, ".join(",", $label_case)."
			FROM users 
			LEFT JOIN surat_tugas_rincian ON users.nip_baru=surat_tugas_rincian.nip 
				AND YEAR(tanggal_mulai)=".$year." 
				AND MONTH(tanggal_mulai)=".$month." 
=======
			nip='" . $nip . "' AND status_aktif<>2 
			AND  (('" . $t_start . "' BETWEEN tanggal_mulai AND tanggal_selesai) OR 
			('" . $t_end . "' BETWEEN tanggal_mulai AND tanggal_selesai) OR 
			(tanggal_mulai>'" . $t_start . "' AND tanggal_selesai<'" . $t_end . "'))";

		$result = DB::select(DB::raw($sql));
		return $result;
	}

	public static function rekapUnitKerja($uk, $month, $year)
	{
		$d = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$label_select = [];
		$label_case = [];

		for ($i = 1; $i <= $d; $i++) {
			$label_select[] = 'day' . $i;
			$label_case[] = "COUNT(CASE WHEN ($i BETWEEN DAY(tanggal_mulai) AND DAY(tanggal_selesai)) THEN 0 END) AS day" . $i;
		}

		$sql = "SELECT nip, nama, " . join(",", $label_select) . "
			FROM (
				SELECT users.id, nip_baru as nip, users.name as nama, " . join(",", $label_case) . "
			FROM users 
			LEFT JOIN surat_tugas_rincian ON users.nip_baru=surat_tugas_rincian.nip 
				AND YEAR(tanggal_mulai)=" . $year . " 
				AND MONTH(tanggal_mulai)=" . $month . " 
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
				AND surat_tugas_rincian.nip IS NOT NULL 
				AND surat_tugas_rincian.status_aktif<>2  
				AND surat_tugas_rincian.nomor_spd IS NOT NULL
			LEFT JOIN surat_tugas ON surat_tugas.id=surat_tugas_rincian.id_surtug  
				AND surat_tugas.sumber_anggaran IN (1,2,4)  
				AND surat_tugas.mak IS NOT NULL 
				 
<<<<<<< HEAD
			WHERE kdkab='".$uk."' 
=======
			WHERE kdkab='" . $uk . "' 
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
				
			GROUP BY nip_baru, name, users.id
				ORDER BY users.id
			) AS CA";
<<<<<<< HEAD
			
		$result = DB::select(DB::raw($sql));
        return $result;
	}

    // public function listKegiatanByMonth($month){
=======

		$result = DB::select(DB::raw($sql));
		return $result;
	}

	// public function listKegiatanByMonth($month){
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
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

<<<<<<< HEAD
    //     $result = DB::select(DB::raw($sql));
=======
	//     $result = DB::select(DB::raw($sql));
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
	// 	return $result;
	// }
}
