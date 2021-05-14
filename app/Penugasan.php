<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $table = 'penugasan';

    public function attributes()
    {
        return [
            'isi' => 'Isi',
            'keterangan' => 'Keterangan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'satuan' => 'Satuan',
            'jenis_periode' => 'Jenis Periode',
        ];
    }
}
