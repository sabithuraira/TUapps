<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BsPemetaan2025 extends Model
{
    protected $table = 'bs_pemetaan2025';
    
    protected $fillable = ['kode_prov', 'kode_kab', 'kode_kec',
        'kode_desa', 'kode_sls', 'kode_subsls', 'nama_sls', 'ketua_sls',
        'jenis', 'klasifikasi', 'jumlah_kk', 'jumlah_bstt', 
        'jumlah_bsbtt', "jumlah_bsttk", "jumlah_bskeko", "dominan",
         "laporan_jumlah_kk", "laporan_jumlah_btt", "laporan_jumlah_btt_kosong", 
         "laporan_jumlah_bku", "laporan_jumlah_bbttn_non", "laporan_perkiraan_jumlah", 
         "status_selesai", "status_perubahan_batas",
        
        'created_by', 'updated_by', 'created_time', 'updated_time'];

    public function Rekapitulasi($kab=null, $kec=null, $desa=null){
        $label_select = "";
        $label_join = "";
        $label_where = "";

        if($desa!=null){ //sls in desaa
            $label_select = "s.id_sls as idw, s.nama_sls as nama,
                SUM(if(s.status_selesai=1, 1, 0)) AS jumlah_selesai, 
                SUM(if(s.status_perubahan_batas=1, 1, 0)) AS jumlah_berubah_batas, 
                SUM(s.jumlah_kk) AS jumlah_kk,
                SUM(s.jumlah_bstt) AS jumlah_bstt,
                SUM(s.jumlah_bsbtt) AS jumlah_bsbtt,
                SUM(s.jumlah_bsttk) AS jumlah_bsttk,
                SUM(s.jumlah_bskeko) AS jumlah_bskeko,
                SUM(s.laporan_jumlah_kk) AS laporan_jumlah_kk,
                SUM(s.laporan_jumlah_btt) AS laporan_jumlah_btt,
                SUM(if(s.laporan_jumlah_kk>s.laporan_jumlah_btt, s.laporan_jumlah_kk, s.laporan_jumlah_btt)) AS laporan_jumlah_maks, 
                SUM(s.laporan_jumlah_btt_kosong) AS laporan_jumlah_btt_kosong,
                SUM(s.laporan_jumlah_bku) AS laporan_jumlah_bku,
                SUM(s.laporan_jumlah_bbttn_non) AS laporan_jumlah_bbttn_non,
                SUM(s.laporan_perikiraan_jumlah) AS laporan_perikiraan_jumlah,
                COUNT(s.id_sls) AS total";

            $label_join = "";

            $label_where = "s.kode_kab='$kab' AND s.kode_kec='$kec' AND s.kode_desa='$desa'";
        }
        else if($desa==null && $kec!=null){ //desa in kecamatan
            $label_select = "w.id_desa as idw, w.nama_desa as nama, 
                SUM(if(s.status_selesai=1, 1, 0)) AS jumlah_selesai, 
                SUM(if(s.status_perubahan_batas=1, 1, 0)) AS jumlah_berubah_batas, 
                SUM(s.jumlah_kk) AS jumlah_kk,
                SUM(s.jumlah_bstt) AS jumlah_bstt,
                SUM(s.jumlah_bsbtt) AS jumlah_bsbtt,
                SUM(s.jumlah_bsttk) AS jumlah_bsttk,
                SUM(s.jumlah_bskeko) AS jumlah_bskeko,
                SUM(s.laporan_jumlah_kk) AS laporan_jumlah_kk,
                SUM(s.laporan_jumlah_btt) AS laporan_jumlah_btt,
                SUM(if(s.laporan_jumlah_kk>s.laporan_jumlah_btt, s.laporan_jumlah_kk, s.laporan_jumlah_btt)) AS laporan_jumlah_maks, 
                SUM(s.laporan_jumlah_btt_kosong) AS laporan_jumlah_btt_kosong,
                SUM(s.laporan_jumlah_bku) AS laporan_jumlah_bku,
                SUM(s.laporan_jumlah_bbttn_non) AS laporan_jumlah_bbttn_non,
                SUM(s.laporan_perikiraan_jumlah) AS laporan_perikiraan_jumlah,
                COUNT(s.id_sls) AS total";

            $label_join = " , desas w";

            $label_where = "s.kode_kab='$kab' AND s.kode_kec='$kec' AND 
                w.id_kab = s.kode_kab AND w.id_kec=s.kode_kec AND w.id_desa=s.kode_desa";
        }
        else if($desa==null && $kec==null && $kab!=null){ //kecamatan in kabupaten

            $label_select = "w.id_kec as idw, w.nama_kec as nama, 
                SUM(if(s.status_selesai=1, 1, 0)) AS jumlah_selesai, 
                SUM(if(s.status_perubahan_batas=1, 1, 0)) AS jumlah_berubah_batas, 
                SUM(s.jumlah_kk) AS jumlah_kk,
                SUM(s.jumlah_bstt) AS jumlah_bstt,
                SUM(s.jumlah_bsbtt) AS jumlah_bsbtt,
                SUM(s.jumlah_bsttk) AS jumlah_bsttk,
                SUM(s.jumlah_bskeko) AS jumlah_bskeko,
                SUM(s.laporan_jumlah_kk) AS laporan_jumlah_kk,
                SUM(s.laporan_jumlah_btt) AS laporan_jumlah_btt,
                SUM(if(s.laporan_jumlah_kk>s.laporan_jumlah_btt, s.laporan_jumlah_kk, s.laporan_jumlah_btt)) AS laporan_jumlah_maks, 
                SUM(s.laporan_jumlah_btt_kosong) AS laporan_jumlah_btt_kosong,
                SUM(s.laporan_jumlah_bku) AS laporan_jumlah_bku,
                SUM(s.laporan_jumlah_bbttn_non) AS laporan_jumlah_bbttn_non,
                SUM(s.laporan_perikiraan_jumlah) AS laporan_perikiraan_jumlah,
                COUNT(s.id_sls) AS total";

            $label_join = " , kecs w";

            $label_where = "s.kode_kab='$kab' AND w.id_kab = s.kode_kab AND w.id_kec=s.kode_kec";
        }
        else{ // all kabupaten in provinsi
            $label_select = "w.id_kab as idw, w.nama_kec as nama, 
                SUM(if(s.status_selesai=1, 1, 0)) AS jumlah_selesai, 
                SUM(if(s.status_perubahan_batas=1, 1, 0)) AS jumlah_berubah_batas, 
                SUM(s.jumlah_kk) AS jumlah_kk,
                SUM(s.jumlah_bstt) AS jumlah_bstt,
                SUM(s.jumlah_bsbtt) AS jumlah_bsbtt,
                SUM(s.jumlah_bsttk) AS jumlah_bsttk,
                SUM(s.jumlah_bskeko) AS jumlah_bskeko,
                SUM(s.laporan_jumlah_kk) AS laporan_jumlah_kk,
                SUM(s.laporan_jumlah_btt) AS laporan_jumlah_btt,
                SUM(if(s.laporan_jumlah_kk>s.laporan_jumlah_btt, s.laporan_jumlah_kk, s.laporan_jumlah_btt)) AS laporan_jumlah_maks, 
                SUM(s.laporan_jumlah_btt_kosong) AS laporan_jumlah_btt_kosong,
                SUM(s.laporan_jumlah_bku) AS laporan_jumlah_bku,
                SUM(s.laporan_jumlah_bbttn_non) AS laporan_jumlah_bbttn_non,
                SUM(s.laporan_perikiraan_jumlah) AS laporan_perikiraan_jumlah,
                COUNT(s.id_sls) AS total";

            $label_join = " , kabs w";

            $label_where = "w.id_kab=s.kode_kab";
        }

        // $label_where .= " AND s.status_sls=1 ";

        $sql = "SELECT $label_select
            FROM bs_pemetaan2025 s $label_join 
            WHERE $label_where 
            GROUP BY idw, nama";

        $result = DB::select(DB::raw($sql));

        return $result;
    }
}
