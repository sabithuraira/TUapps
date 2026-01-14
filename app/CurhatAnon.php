<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurhatAnon extends Model
{
    protected $table = 'curhat_anon';

    protected $fillable = [
        'content',
        'status_verifikasi'
    ];

    public function getListStatusVerifikasiAttribute()
    {
        return array(
            1 => "Belum Verifikasi",
            2 => "Disetujui",
            3 => "Tidak Disetujui",
        );
    }

    public function getListLabelStatusVerifikasiAttribute()
    {
        return array(
            1 => "Belum Verifikasi",
            2 => "Disetujui",
            3 => "Tidak Disetujui",
        );
    }
}

