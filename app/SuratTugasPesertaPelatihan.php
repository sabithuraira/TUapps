<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratTugasPesertaPelatihan extends Model
{
	protected $table = 'surat_tugas_peserta_pelatihan';

    public function attributes()
    {
        return (new \App\Http\Requests\SuratTugasPesertaPelatihanRequest())->attributes();
	}
	
    public function getListTingkatBiayaAttribute()
    {
        return array(
            1 => 'A', 2 => 'B', 3 => 'C'
        );
    }
	
    public function getListKendaraanAttribute()
    {
        return array( 
			1 => 'Kendaraan Umum', 
			2 => 'Kendaraan Dinas',
			3 => 'Kendaraan Pesawat',
		);
	}

	public function getListKategoriPesertaAttribute()
    {
        return array( 
			1 => 'Peserta', 
			2 => 'Pengajar',
			3 => 'Panitia',
		);
    }
}
