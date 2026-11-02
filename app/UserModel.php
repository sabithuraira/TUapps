<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    protected $table = 'users';

    public function getListPangkatAttribute(){
        return array(
            'II/a' => 'Pengatur Muda', 
            'II/b' => 'Pengatur Muda Tingkat I', 
            'II/c' => 'Pengatur' , 
            'II/d' => 'Pengatur Tingkat I' , 
            'III/a' => 'Penata Muda',  
            'III/b' => 'Penata Muda Tingkat I',  
            'III/c' => 'Penata' , 
            'III/d' => 'Penata Tingkat I',  
            'IV/a' => 'Pembina',  
            'IV/b' => 'Pembina Tingkat I',  
            'IV/c' => 'Pembina Utama Muda',  
            'IV/d' => 'Pembina Utama Madya',
            'IV/e' => 'Pembina Utama',
            'VII' => 'Pengatur'
        );
	}

    public $statusAktif = [
            1 => 'Aktif', 
            2 => 'Pindah/Pensiun', 
    ];

    public function getJumlahDl(){
        $nip = $this->nip_baru;
        // $sql = "SELECT SUM(DATEDIFF(str.tanggal_selesai, str.tanggal_mulai)+1) as total_hari
        //         FROM surat_tugas_rincian as str, surat_tugas st 
        //         WHERE st.id = str.id_surtug AND 
        //             st.sumber_anggaran<>3 AND 
        //             str.nip='198908232012111001' AND  
        //             str.status_aktif<>2";
        $cur_year = date('Y');

        $total_biasa = DB::table("surat_tugas_rincian")
                    ->join("surat_tugas","surat_tugas_rincian.id_surtug","=","surat_tugas.id")
                    ->where('surat_tugas.sumber_anggaran', '<>', 3)
                    ->where('surat_tugas_rincian.nip', '=', $nip)
                    ->where('surat_tugas_rincian.status_aktif', '<>', 2)
                    ->whereNotNull('surat_tugas_rincian.nomor_spd')
                    ->where(\DB::raw('YEAR(surat_tugas_rincian.tanggal_mulai)'), '=', $cur_year)
                    ->sum(\DB::raw('DATEDIFF(surat_tugas_rincian.tanggal_selesai, surat_tugas_rincian.tanggal_mulai)+1'));
                    
        // $total_pelatihan = DB::table("surat_tugas_peserta_pelatihan")
        //             ->join("surat_tugas_rincian","surat_tugas_rincian.id","=","surat_tugas_peserta_pelatihan.id_surtug")
        //             ->join("surat_tugas","surat_tugas_rincian.id_surtug","=","surat_tugas.id")
        //             ->where('surat_tugas.sumber_anggaran', '<>', 3)
        //             ->where('surat_tugas_peserta_pelatihan.nip', '=', $nip)
        //             ->where('surat_tugas_rincian.status_aktif', '<>', 2)
        //             ->whereNotNull('surat_tugas_rincian.nomor_spd')
        //             ->where(\DB::raw('YEAR(surat_tugas_rincian.tanggal_mulai)'), '=', $cur_year)
        //             ->sum(\DB::raw('DATEDIFF(surat_tugas_rincian.tanggal_selesai, surat_tugas_rincian.tanggal_mulai)+1'));

        return $total_biasa;// + $total_pelatihan;
    }

    public function getJumlahDlByNip($nip, $cur_year){
        // $cur_year = date('Y');

        $user_kab = UserModel::where('nip_baru', '=', $nip)->first();
        $kode_kab = '';
        $total_biasa = 0;
        if($user_kab!=null) $kode_kab = $user_kab->kdkab;
        

        if($kode_kab=='00'){
            $total_biasa = DB::table("surat_tugas_rincian")
                ->join("surat_tugas","surat_tugas_rincian.id_surtug","=","surat_tugas.id")
                ->where('surat_tugas.sumber_anggaran', '<>', 3)
                // ->where('surat_tugas.jenis_st', '<>', 3)
                ->whereIn('surat_tugas.jenis_st', array(2,5))
                ->where('surat_tugas_rincian.nip', '=', $nip)
                ->where('surat_tugas_rincian.status_aktif', '<>', 2)
                ->whereNotNull('surat_tugas_rincian.nomor_spd')
                ->where(\DB::raw('YEAR(surat_tugas_rincian.tanggal_mulai)'), '=', $cur_year)
                ->sum(\DB::raw('DATEDIFF(surat_tugas_rincian.tanggal_selesai, surat_tugas_rincian.tanggal_mulai)+1'));
        }
        else{
            $total_biasa = DB::table("surat_tugas_rincian")
                ->join("surat_tugas","surat_tugas_rincian.id_surtug","=","surat_tugas.id")
                ->where('surat_tugas.sumber_anggaran', '<>', 3)
                // ->where('surat_tugas.jenis_st', '<>', 3)
                ->whereIn('surat_tugas.jenis_st', array(2,3,5))
                ->where('surat_tugas_rincian.nip', '=', $nip)
                ->where('surat_tugas_rincian.status_aktif', '<>', 2)
                ->whereNotNull('surat_tugas_rincian.nomor_spd')
                ->where(\DB::raw('YEAR(surat_tugas_rincian.tanggal_mulai)'), '=', $cur_year)
                ->sum(\DB::raw('DATEDIFF(surat_tugas_rincian.tanggal_selesai, surat_tugas_rincian.tanggal_mulai)+1'));
        }

        
                    
        // $total_pelatihan = DB::table("surat_tugas_peserta_pelatihan")
        //             ->join("surat_tugas_rincian","surat_tugas_rincian.id","=","surat_tugas_peserta_pelatihan.id_surtug")
        //             ->join("surat_tugas","surat_tugas_rincian.id_surtug","=","surat_tugas.id")
        //             ->where('surat_tugas.sumber_anggaran', '<>', 3)
        //             ->where('surat_tugas_peserta_pelatihan.nip', '=', $nip)
        //             ->where('surat_tugas_rincian.status_aktif', '<>', 2)
        //             ->whereNotNull('surat_tugas_rincian.nomor_spd')
        //             ->where(\DB::raw('YEAR(surat_tugas_rincian.tanggal_mulai)'), '=', $cur_year)
        //             ->sum(\DB::raw('DATEDIFF(surat_tugas_rincian.tanggal_selesai, surat_tugas_rincian.tanggal_mulai)+1'));

        return $total_biasa; // + $total_pelatihan;
    }

    public function getFotoUrlAttribute(){
        $simpegUrl = "https://simpeg.bps.go.id/apis/pegawai/avatar/" . $this->email;
        if ($this->is_foto_exist($simpegUrl)) {
            return $simpegUrl;
        }

        $base = "https://community.bps.go.id/images/avatar/";
        $nipLama = $this->email;
        $nipBaru = $this->nip_baru;
        $candidates = [];

        // Stored filename, e.g. 340065304_20261014041047.jpg
        if (strlen((string) $this->foto) > 0) {
            $foto = $this->foto;
            if (!preg_match('/\.(jpe?g|png|gif)$/i', $foto)) {
                $foto .= '.jpg';
            }
            $candidates[] = $base . $foto;
        }

        // nip lama + nip baru
        if (strlen((string) $nipLama) > 0 && strlen((string) $nipBaru) > 0) {
            $candidates[] = $base . $nipLama . '_' . $nipBaru . '.jpg';
            $candidates[] = $base . $nipLama . '_' . $nipBaru . '.JPG';
        }

        // nip lama only
        if (strlen((string) $nipLama) > 0) {
            $candidates[] = $base . $nipLama . '.jpg';
            $candidates[] = $base . $nipLama . '.JPG';
        }

        foreach ($candidates as $url) {
            if ($this->is_foto_exist($url)) {
                return $url;
            }
        }

        return !empty($candidates) ? $candidates[0] : $simpegUrl;
    }

    function is_foto_exist($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }
}
