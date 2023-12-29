<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IkiMaster extends Model
{
    //
    protected $table = 'iki_master';
    protected $guarded = [];

    public function ikibukti(): HasMany
    {
        return $this->hasMany(IkiBukti::class, 'id_iki', 'id');
    }

    public static function getListReferensiJenisAttribute()
    {
        return [
            'Tidak Masuk Bukti Dukung Atasan',
            'Masuk Bukti Dukung Atasan',
            'Masuk Bukti Dukung & Realisasi Atasan'
        ];
    }

    public static function getNamaBulanAttribute()
    {

        return [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];
    }
}
