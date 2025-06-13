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

}
