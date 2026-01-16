<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArsipKlasifikasi extends Model
{
    protected $table = 'arsip_klasifikasi';

    protected $fillable = [
        'kode',
        'kode_2',
        'kode_3',
        'kode_4',
        'kode_gabung',
        'judul',
        'created_by',
        'updated_by',
    ];
}

