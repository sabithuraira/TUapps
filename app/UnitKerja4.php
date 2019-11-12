<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitKerja4 extends Model
{
    protected $table = 'unit_kerja4';

    public function attributes()
    {
        return [
            'is_kabupaten' => 'Apakah Kabupaten',
            'nama' => 'Nama',
        ];
    }
}
