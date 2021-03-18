<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UnitKerja extends Model
{
    protected $table = 'unit_kerjas';

    public function attributes()
    {
        return [
            'kode' => 'Kode Wilayah',
            'nama' => 'Nama',
            'kepala_nip' => 'Kepala',
            'kepala_nama' => 'Kepala',
            'bendahara_nip' => 'Bendahara',
            'bendahara_nama' => 'Bendahara',
            'ppk_nip' => 'PPK',
            'ppk_nama' => 'PPK',
            'ppspm_nip' => 'PPSPM',
            'ppspm_nama' => 'PPSPM',
            'ibu_kota' => 'Ibu Kota Wilayah',
            'alamat_kantor' => 'Alamat Kantor',
            'kontak_kantor' => 'Kontak Kantor',
        ];
    }

    public function opnamePengurangans()
    {
        return $this->hasMany('App\OpnamePengurangan');
    }

    public static function rekapDlPerUk(){
        $sql = "SELECT unit_kerjas.id, unit_kerjas.nama, COUNT(surat_tugas_rincian.id) as total
                FROM `unit_kerjas` 
                LEFT JOIN  surat_tugas_rincian ON 
                    surat_tugas_rincian.unit_kerja=unit_kerjas.kode AND 
                    surat_tugas_rincian.nip IS NOT NULL AND
                    surat_tugas_rincian.status_aktif<>2 AND 
				    surat_tugas_rincian.nomor_spd IS NOT NULL AND 
                    CURDATE() BETWEEN surat_tugas_rincian.tanggal_mulai AND surat_tugas_rincian.tanggal_selesai 
                LEFT JOIN surat_tugas ON surat_tugas.id=surat_tugas_rincian.id_surtug AND 
                    surat_tugas.sumber_anggaran IN (1,2,4) AND surat_tugas.mak IS NOT NULL 
                GROUP BY unit_kerjas.id, unit_kerjas.nama";

        $result = DB::select(DB::raw($sql));
        return $result;
    }
}
