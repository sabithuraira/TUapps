<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimMaster extends Model
{
    protected $table = 'master_tim';

    public function attributes()
    {
        return [
            'nama_tim' => 'Nama Tim',
            'kode_prov' => 'Provinsi',
            'kode_kab' => 'Kab/Kota',
            'tahun' => 'Tahun',
            'nama_ketua_tim' => 'Ketua Tim',
            'nik_ketua_tim' => 'NIP Ketua Tim',
            'jumlah_anggota' => 'Jumlah Anggota',
        ];
    }
    
    public function CreatedBy(){
        return $this->hasOne('App\UserModel', 'id', 'created_by');
    }
}
