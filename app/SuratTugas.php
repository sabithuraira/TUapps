<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratTugas extends Model
{
    protected $table = 'surat_tugas';

    public function attributes()
    {
        return (new \App\Http\Requests\SuratTugasRequest())->attributes();
    }

    public function unitKerja()
    {
        return $this->belongsTo('App\UnitKerja', 'unit_kerja');
    }

    public function MakRel()
    {
        return $this->hasOne('App\MataAnggaran', 'id', 'mak');
    }
    
    public function getListJenisAttribute()
    {
        return array(
            1 => 'Perjadin Organik Dalam Kota', 
            2 => 'Perjadin Organik Luar Kota', 
            3 => 'Honor/Upah/Transport Mitra', 
            4 => 'Lainnya (Kontrak, tanpa anggaran, dll)',
            // 5 => 'Pelatihan'
            6 => 'Perjadin Paket Meeting Luar Kota', 
        );
    }

    public function getListKategoriAttribute()
    {
        return array(
            1 => 'Biasa', 
            2 => 'Tim', 
            3 => 'Pelatihan'
        );
    }
    
    public function getListKodeJenisAttribute()
    {
        return array(
            1 => '524113', 
            2 => '524111', 
            3 => '521213',
            4 => '',
            5 => '524114',
            6 => '524119'
        );
    }
    
    public function getListSumberAnggaranAttribute()
    {
        if(Auth::user()->kdkab=='00'){
            return array(
                2 => 'DIPA BPS', 
                3 => 'Bukan DIPA BPS', 
            );
        }
        else{
            return array(
                1 => 'DIPA BPS', 
                2 => 'DIPA BPS Provinsi', 
                3 => 'Bukan DIPA BPS', 
            );
        }
    }
}
