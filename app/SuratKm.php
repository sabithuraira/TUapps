<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratKm extends Model
{
    protected $table = 'surat_km';
    
    public function attributes()
    {
        return (new \App\Http\Requests\SuratKmRequest())->attributes();
    }

    public function getListJenisAttribute()
    {
        return array(
            1 => 'Surat Masuk', 
            2 => 'Surat Dinas Keluar', 
            3 => 'Memorandum / Nota Dinas', 
            4 => 'Surat Pengantar', 
            5 => 'Disposisi', 
            6 => 'Surat Keputusan', 
            7 => 'Surat Keterangan', 
        );
    }

    public function getListPetunjukAttribute()
    {
        return array(
            9200 => 'Kepala', 
            9210 => 'Bagian Tata Usaha',
            9220 => 'Bidang Statistik Sosial',
            9230 => 'Bidang Statistik Produksi',
            9240 => 'Bidang Statistik Distribusi',
            9250 => 'Bidang Nerwilis Statistik',
            9260 => 'Bidang IPDS',
            9211 => 'Subbagian Bina Program',
            9212 => 'Subbagian Kepegawaian & Hukum',
            9213 => 'Subbagian Keuangan',
            9214 => 'Subbagian PBJ',
            9215 => 'Subbagian Umum',
        );
    }

    public function getListTingkatKeamananAttribute()
    {
        return array(
            'B' => 'Biasa', 
            'R' => 'Rahasia', 
        );
    }
}
