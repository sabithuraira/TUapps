<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArsipJenis extends Model
{
    protected $table = 'arsip_jenis';

    protected $fillable = [
        'title',
        'deskripsi',
        'masa_retensi_tahun',
        'created_by',
        'updated_by',
    ];
}

