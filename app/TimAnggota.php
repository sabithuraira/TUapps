<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimAnggota extends Model
{
    protected $table = 'anggota_tim';

    public function attributes()
    {
        return [
            'id_tim' => 'Tim',
            'nama_anggota' => 'Nama',
            'nik_anggota' => 'NIP',
            'status_keanggotaan' => 'Status Anggota',
            'is_active' => 'Apakah Aktif?',
        ];
    }

    public function TimIndukRel()
    {
        return $this->hasOne('App\TimAnggota', 'id', 'id_tim');
    }

    public function CreatedBy(){
        return $this->hasOne('App\UserModel', 'id', 'created_by');
    }
}
