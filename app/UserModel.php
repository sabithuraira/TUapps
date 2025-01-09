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
        $nip_id = substr($this->email, -5);

        if($this->is_foto_exist("https://simpeg.bps.go.id/apis/pegawai/avatar/".$this->email)){
            return "https://simpeg.bps.go.id/apis/pegawai/avatar/".$this->email; 
        }
        // if(strlen($this->foto)>0){
        //     if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$this->foto)){
        //         return "https://community.bps.go.id/images/avatar/".$this->foto; 
        //     }
        //     else if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$nip_id.".JPG")){
        //         return "https://community.bps.go.id/images/avatar/".$nip_id.".JPG";
        //     }
        //     else{
        //         return "https://community.bps.go.id/images/avatar/".$nip_id.".jpg";    
        //     }
        // }
        // else{
        //     // $nip_id = '10080'; //10080 55914
        //     if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$nip_id.".JPG")){
        //         return "https://community.bps.go.id/images/avatar/".$nip_id.".JPG";
        //     }
        //     else{
        //         return "https://community.bps.go.id/images/avatar/".$nip_id.".jpg";    
        //     }
        // }
    }

    function is_foto_exist($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($ch);
        curl_close($ch);
        if($result !== FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
        // $headers=get_headers($url);
        // return stripos($headers[0],"200 OK")?true:false;
    }
}
