<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiraAkunRealisasi extends Model
{
    protected $table = 'sira_akun_realisasi';

    public function attributes()
    {
        return (new \App\Http\Requests\SiraAkunRealisasiRequest())->attributes();
    }

    public function getListFungsiAttribute()
    {
        return array(
            1 => 'Subbagian Umum', 
            2 => 'Fungsi Sosial', 
            3 => 'Fungsi Nerwilis', 
            4 => 'Fungsi Statistik Distribusi',
            5 => 'Fungsi Statistik Produksi',
            6 => 'Fungsi IPDS', 
        );
    }

    public function getListJenisAttribute()
    {
        return array(
            1 => 'Subbagian Umum', 
            2 => 'Fungsi Sosial', 
            3 => 'Fungsi Nerwilis', 
            4 => 'Fungsi Statistik Distribusi',
            5 => 'Fungsi Statistik Produksi',
            6 => 'Fungsi IPDS', 
        );
    }
}
