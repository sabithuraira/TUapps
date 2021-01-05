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
    
    public function getListJenisAttribute()
    {
        return array(
            1 => 'Perjadin Organik Dalam Kota', 
            2 => 'Perjadin Organik Luar Kota', 
            // 3 => 'Honor/Upah/Transport Mitra'
        );
    }
    
    public function getListSumberAnggaranAttribute()
    {
        if(Auth::user()->kdkab=='00'){
            return array(
                1 => 'DIPA BPS', 
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
