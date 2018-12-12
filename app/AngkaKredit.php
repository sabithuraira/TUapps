<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AngkaKredit extends Model
{
    protected $table = 'angka_kredits';
    
    public function Jenis()
    {
        return $this->hasOne('App\TypeKredit', 'id', 'jenis');
    }
    
    public function attributes()
    {
        return [
            'jenis' => 'Peruntukan',
            'kode' => 'kode',
            'butir_kegiatan' => 'Butir Kegiatan',
            'satuan_hasil' => 'Satuan Hasil',
            'angka_kredit' => 'Angka Kredit',
            'batas_penilaian' => 'Batas Penilaian',
            'pelaksana' => 'Pelaksana Bukti',
            'bukti_fisik' => 'Bukti Fisik',
        ];
    }
}
