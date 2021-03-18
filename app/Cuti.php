<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    //
    protected $table = "cuti";
    public function attributes()
    {
        return (new \App\Http\Requests\CutiRequest())->attributes();
    }

    public function getListStatusAttribute()
    {
        return array(
            0 => "<div class='badge badge-info'>Menunggu Konfirmasi</div>",
            1 => "<div class='badge badge-success'>Disetujui</div>",
            2 => "<div class='badge badge-primary'>Disetujui dengan Perubahan</div>",
            4 => "<div class='badge badge-warning'>Ditangguhkan</div>",
            5 => "<div class='badge badge-danger'>Tidak Disetujui</div>",
        );
    }

    public function getListLabelStatusAttribute()
    {
        return array(
            0 => "Menunggu Konfirmasi",
            1 => "Disetujui",
            2 => "Disetujui dengan Perubahan",
            4 => "Ditangguhkan",
            5 => "Tidak Disetujui",
        );
    }
    public function getListJenisCutiAttribute()
    {
        return array(
            'Cuti Tahunan' => 'Cuti Tahunan',
            'Cuti Besar' => 'Cuti Besar',
            'Cuti Sakit' => 'Cuti Sakit',
            'Cuti Melahirkan' => 'Cuti Melahirkan',
            'Cuti Karena Alasan Penting' => 'Cuti Karena Alasan Penting',
            'Cuti di Luar Tanggungan Negara' => 'Cuti di Luar Tanggungan Negara',
        );
    }
    public function getCatatanCutiAttribute()
    {
        return array(
            'cuti_tahunan_sebelum' => null,
            'cuti_tahunan' => null,
            'cuti_besar' => null,
            'cuti_sakit' => null,
            'cuti_melahirkan' => null,
            'cuti_penting' => null,
            'cuti_luar_tanggungan' => null,

            'keterangan_cuti_tahunan_sebelum' => null,
            'keterangan_cuti_tahunan' => null,
            'keterangan_cuti_besar' => null,
            'keterangan_cuti_sakit' => null,
            'keterangan_cuti_melahirkan' => null,
            'keterangan_cuti_penting' => null,
            'keterangan_luar_tanggunan' => null,



        );
    }
}
