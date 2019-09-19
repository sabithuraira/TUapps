<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalDinas extends Model
{
    protected $table = 'jadwal_dinas';
    
    public function PegawaiRel()
    {
        return $this->hasOne('App\User', 'email', 'pegawai_id');
    }

    public function attributes()
    {
        return (new \App\Http\Requests\JadwalDinasRequest())->attributes();
    }
}
