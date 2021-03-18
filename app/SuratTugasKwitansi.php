<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratTugasKwitansi extends Model
{
    protected $table = 'surat_tugas_kwitansi';
    
    public function SuratIndukRel()
    {
        return $this->hasOne('App\SuratTugas', 'id', 'id_surtug');
    }
    
    public function SuratIndukPegawaiRel()
    {
        return $this->hasOne('App\SuratTugasRincian', 'id', 'id_surtug_pegawai');
    }

    public function attributes()
    {
        return (new \App\Http\Requests\SuratTugasRincianRequest())->attributes();
	}
}
