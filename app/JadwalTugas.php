<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function listKegiatanByMonth($month){
		$curr_year=date('Y');

		$sql="SELECT u.id, u.email, u.name, DAY(tanggal_mulai) as mulai, 
			DAY(tanggal_selesai) as selesai, j.nama_kegiatan
			FROM jadwal_tugas j, users u 
			WHERE 
			(YEAR(tanggal_mulai)='".$curr_year."' OR YEAR(tanggal_selesai)='".$curr_year."') AND 
			(MONTH(tanggal_mulai)='".$month."' OR MONTH(tanggal_selesai)='".$month."') AND 
			j.pegawai_id=u.email 
			ORDER BY tanggal_selesai DESC, tanggal_mulai DESC 
			LIMIT 1000;";

        $result = DB::select(DB::raw($sql));
		return $result;
	}
}
