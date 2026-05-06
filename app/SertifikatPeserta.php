<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SertifikatPeserta extends Model
{
    protected $table = 'sertifikat_peserta';

    protected $fillable = [
        'sertifikat_induk_id',
        'nama_peserta',
        'nomor_urut',
        'nomor_sertifikat',
    ];

    public function induk()
    {
        return $this->belongsTo(SertifikatInduk::class, 'sertifikat_induk_id');
    }
}
