<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PokRincianAnggaran extends Model{
    protected $table = 'pok_rincian_anggaran';
    
    public function attributes(){
        return [
            'id_mata_anggaran' => 'Mata Anggaran',
            'label' => 'Label',
            'tahun' => 'Tahun',
            'volume' => 'Volume',
            'satuan' => 'Satuan',
            'harga_satuan' => 'Harga Satuan',
            'harga_jumlah' => 'Harga Jumlah',
        ];
    }
    
    public function mata_anggaran(){
        return $this->hasOne('App\PokMataAnggaran', 'id', 'id_mata_anggaran');
    }

    public function getDataAnggaran($tahun){
        // $sql = "SELECT 
        // program.kode as kode_program, program.label as label_program,
        // aktivitas.kode as kode_aktivitas, aktivitas.label as label_aktivitas,
        // kro.kode as kode_kro, kro.label as label_kro,
        // ro.kode as kode_r, ro.label as label_ro,
        // komponen.kode as kode_komponen, komponen.label as label_komponen,
        // sub_komponen.kode as kode_sub_komponen, sub_komponen.label as label_sub_komponen,
        // m.kode, m.label,
        // r.*
        // FROM 
        //     pok_rincian_anggaran r,
        //     pok_mata_anggaran m,
        //     pok_aktivitas aktivitas,
        //     pok_program program,
        //     pok_kro kro,
        //     pok_ro ro,
        //     pok_komponen komponen,
        //     pok_sub_komponen sub_komponen
        // WHERE
        //     r.id_mata_anggaran=m.id 
        //     AND r.tahun=2022
        // ORDER BY m.id_program, m.id_aktivitas, m.id_kro, m.id_ro, 
        //     m.id_komponen, m.id_sub_komponen, m.id";

        $sql = "SELECT 
                    m.id_program, m.id_aktivitas, m.id_kro, m.id_ro,
                    m.id_komponen, m.id_sub_komponen, m.id as id_mata_anggaran,
                    komponen.kode as kode_komponen, komponen.label as label_komponen,
                    sub_komponen.kode as kode_sub_komponen, sub_komponen.label as label_sub_komponen,
                    m.kode as kode_mata_anggaran, m.label as label_mata_anggaran,
                    r.*
                    FROM pok_mata_anggaran m
                    
                    INNER JOIN  pok_program program ON m.id_program=program.id 
                    INNER JOIN  pok_aktivitas aktivitas ON m.id_aktivitas=aktivitas.id 
                    INNER JOIN  pok_kro kro ON m.id_kro=kro.id 
                    INNER JOIN  pok_ro ro ON m.id_ro=ro.id 
                    INNER JOIN  pok_komponen komponen ON m.id_komponen=komponen.id 
                    INNER JOIN  pok_sub_komponen sub_komponen ON m.id_sub_komponen=sub_komponen.id 
                    INNER JOIN  pok_rincian_anggaran r ON m.id=r.id_mata_anggaran
                    
                    WHERE 
                        m.tahun=2022 AND m.unit_kerja=" . Auth::user()->kdprop.Auth::user()->kdkab . "
                    ORDER BY m.id_program, m.id_aktivitas, m.id_kro, m.id_ro, 
                        m.id_komponen, m.id_sub_komponen, m.id;";
                        
        $result = DB::select(DB::raw($sql));
        return $result;
    }
}
