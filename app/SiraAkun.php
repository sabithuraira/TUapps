<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiraAkun extends Model
{
    protected $table = 'sira_akun';

    public function attributes()
    {
        return (new \App\Http\Requests\SiraAkunRequest())->attributes();
    }

    public function syncRealisasi($id){
        $model = \App\SiraAkun::find($id);

        $total = \App\SiraAkunRealisasi::where('kode_mak', $model->kode_mak)
                                        ->where('kode_akun', $model->kode_akun)->sum('realisasi');

        $model->realisasi = $total;
        $model->save();
    }

    public function getListFungsiAttribute()
    {
        return array(
            1 => 'Subbagian Umum', 
            2 => 'Fungsi Sosial', 
            3 => 'Fungsi Nerwilis', 
            4 => 'Fungsi Statistik Distribusi',
            5 => 'Fungsi Statistik Produksi',
            6 => 'Fungsi IPDS', 
        );
    }

    public function getListJenisAttribute()
    {
        return array(
            1 => 'Subbagian Umum', 
            2 => 'Fungsi Sosial', 
            3 => 'Fungsi Nerwilis', 
            4 => 'Fungsi Statistik Distribusi',
            5 => 'Fungsi Statistik Produksi',
            6 => 'Fungsi IPDS', 
        );
    }

    public function rekapPagu(){
        $sql = "SELECT 
                    SUM(CASE WHEN kode_fungsi=1 THEN (pagu-realisasi) ELSE 0 END) umum,
                    SUM(CASE WHEN kode_fungsi=2 THEN (pagu-realisasi) ELSE 0 END) sosial,
                    SUM(CASE WHEN kode_fungsi=3 THEN (pagu-realisasi) ELSE 0 END) nerwilis,
                    SUM(CASE WHEN kode_fungsi=4 THEN (pagu-realisasi) ELSE 0 END) distribusi,
                    SUM(CASE WHEN kode_fungsi=5 THEN (pagu-realisasi) ELSE 0 END) produksi,
                    SUM(CASE WHEN kode_fungsi=6 THEN (pagu-realisasi) ELSE 0 END) ipds
                FROM `sira_akun` WHERE 1";

        $result = DB::select(DB::raw($sql));
        return $result;
    }

    public function rekapRealisasi(){
        // $sql = "SELECT 
        //             SUM(CASE WHEN kode_fungsi=1 THEN realisasi ELSE 0 END) umum,
        //             SUM(CASE WHEN kode_fungsi=2 THEN realisasi ELSE 0 END) sosial,
        //             SUM(CASE WHEN kode_fungsi=3 THEN realisasi ELSE 0 END) nerwilis,
        //             SUM(CASE WHEN kode_fungsi=4 THEN realisasi ELSE 0 END) distribusi,
        //             SUM(CASE WHEN kode_fungsi=5 THEN realisasi ELSE 0 END) produksi,
        //             SUM(CASE WHEN kode_fungsi=6 THEN realisasi ELSE 0 END) ipds
        //         FROM `sira_akun_realisasi` WHERE 1";
        $sql = "SELECT 
                    SUM(CASE WHEN kode_fungsi=1 THEN realisasi ELSE 0 END) umum,
                    SUM(CASE WHEN kode_fungsi=2 THEN realisasi ELSE 0 END) sosial,
                    SUM(CASE WHEN kode_fungsi=3 THEN realisasi ELSE 0 END) nerwilis,
                    SUM(CASE WHEN kode_fungsi=4 THEN realisasi ELSE 0 END) distribusi,
                    SUM(CASE WHEN kode_fungsi=5 THEN realisasi ELSE 0 END) produksi,
                    SUM(CASE WHEN kode_fungsi=6 THEN realisasi ELSE 0 END) ipds
                FROM `sira_akun` WHERE 1";

        $result = DB::select(DB::raw($sql));
        return $result;
    }
}
