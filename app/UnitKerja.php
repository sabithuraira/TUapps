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
        ];
    }
}
