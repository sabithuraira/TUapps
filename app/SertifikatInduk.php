<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SertifikatInduk extends Model
{
    protected $table = 'sertifikat_induk';

    protected $fillable = [
        'kegiatan',
        'deskripsi',
        'tanggal',
        'kode_satker',
        'klasifikasi_arsip',
        'nomor_urut_start',
        'nomor_urut_end',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function peserta()
    {
        return $this->hasMany(SertifikatPeserta::class, 'sertifikat_induk_id');
    }

    /**
     * Format: B-{nomor_urut}/{kode_satker}/{klasifikasi_arsip}/{tahun}
     */
    public static function formatNomorSertifikat($nomorUrut, $kodeSatker, $klasifikasiArsip, $tanggal)
    {
        $year = \Carbon\Carbon::parse($tanggal)->format('Y');

        return 'B-'.((int) $nomorUrut).'/'.$kodeSatker.'/'.$klasifikasiArsip.'/'.$year;
    }

    public function refreshNomorUrutRangeFromPeserta()
    {
        if ($this->peserta()->count() === 0) {
            $this->nomor_urut_start = null;
            $this->nomor_urut_end = null;
        } else {
            $this->nomor_urut_start = (int) $this->peserta()->min('nomor_urut');
            $this->nomor_urut_end = (int) $this->peserta()->max('nomor_urut');
        }
        $this->save();
    }
}
