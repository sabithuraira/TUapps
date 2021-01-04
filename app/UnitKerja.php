<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerjas';

    public function attributes()
    {
        return [
            'kode' => 'Kode Wilayah',
            'nama' => 'Nama',
            'kepala_nip' => 'Kepala',
            'kepala_nama' => 'Kepala',
            'bendahara_nip' => 'Bendahara',
            'bendahara_nama' => 'Bendahara',
            'ppk_nip' => 'PPK',
            'ppk_nama' => 'PPK',
            'ppspm_nip' => 'PPSPM',
            'ppspm_nama' => 'PPSPM',
            'ibu_kota' => 'Ibu Kota Wilayah',
            'alamat_kantor' => 'Alamat Kantor',
            'kontak_kantor' => 'Kontak Kantor',
        ];
    }

    public function opnamePengurangans()
    {
        return $this->hasMany('App\OpnamePengurangan');
    }
}
