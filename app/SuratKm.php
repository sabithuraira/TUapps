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
        return array(1 => 'Surat Masuk', 2 => 'Surat Keluar', 3=>'Memorandum');
    }

    public function getListPetunjukAttribute()
    {
        return array(
            9200 => 'Kepala', 
            9210 => 'Bagian Tata Usaha',
            9220 => 'Bidang Statistik Sosial',
            9230 => 'Bagian Statistik Produksi',
            9240 => 'Bagian Statistik Distribusi',
            9250 => 'Bagian Nerwilis Statistik',
            9260 => 'Bagian IPDS',
            9211 => 'Subbagian Bina Program',
            9212 => 'Subbagian Kepegawaian & Hukum',
            9213 => 'Subbagian Keuangan',
            9214 => 'Subbagian PBJ',
            9215 => 'Subbagian Umum',
        );
    }
}
