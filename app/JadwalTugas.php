<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalTugas extends Model
{
    protected $table = 'jadwal_tugas';
    
    public function PegawaiRel()
    {
        return $this->hasOne('App\User', 'email', 'pegawai_id');
    }
    
    public function unitKerja()
    {
        return $this->belongsTo('App\UnitKerja', 'unit_kerja');
    }
    
    public function unitKerja4()
    {
        return $this->belongsTo('App\UnitKerja4', 'unit_kerja');
    }

    public function attributes()
    {
        return (new \App\Http\Requests\JadwalTugasRequest())->attributes();
    }
}
