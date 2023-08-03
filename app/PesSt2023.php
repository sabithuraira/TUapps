<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PesSt2023 extends Model
{
    protected $table = 'pes_st2023';
    
    protected $fillable = ['kode_prov', 'kode_kab', 'kode_kec',
        'kode_desa', 'id_sls', 'id_sub_sls', 'nama_sls', 
        'jenis_sls', 'jml_ruta_tani', 'jml_art_tani', 'jml_ruta_pes'
        , 'jml_art_pes', "status_selesai"];


    // public function Rekapitulasi($kab=null, $kec=null, $desa=null){
    //     $label_select = "";
    //     $label_join = "";
    //     $label_where = "";

    //     if($desa!=null){ //sls in desaa
    //         $label_select = "s.id_sls as idw, s.nama_sls as nama,
    //             SUM(if(s.kode_pcl IS NOT NULL OR j_keluarga_pengakuan>0, 1, 0)) AS jumlah_selesai_vk, 
    //             SUM(if(s.status_selesai_pcl<>0, 1, 0)) AS jumlah_selesai, 
    //             SUM(s.j_keluarga_pengakuan) AS jumlah_sls,
    //             SUM(s.j_keluarga_pcl) AS jumlah_pcl,
    //             SUM(s.j_keluarga_pml) AS jumlah_pml,
    //             SUM(s.j_keluarga_koseka) AS jumlah_koseka,
    //             SUM(s.j_keluarga_sls) AS jumlah_prelist,
    //             COUNT(s.id_sls) AS total";

    //         $label_join = "";

    //         $label_where = "s.kode_kab='$kab' AND s.kode_kec='$kec' AND s.kode_desa='$desa'";
    //     }
    //     else if($desa==null && $kec!=null){ //desa in kecamatan
    //         $label_select = "w.idDesa as idw, w.nmDesa as nama, 
    //             SUM(if(s.kode_pcl IS NOT NULL OR j_keluarga_pengakuan>0, 1, 0)) AS jumlah_selesai_vk, 
    //             SUM(if(s.status_selesai_pcl<>0, 1, 0)) AS jumlah_selesai, 
    //             SUM(s.j_keluarga_pengakuan) AS jumlah_sls,
    //             SUM(s.j_keluarga_pcl) AS jumlah_pcl,
    //             SUM(s.j_keluarga_pml) AS jumlah_pml,
    //             SUM(s.j_keluarga_koseka) AS jumlah_koseka,
    //             SUM(s.j_keluarga_sls) AS jumlah_prelist,
    //             COUNT(s.id_sls) AS total";

    //         $label_join = " , p_desa w";

    //         $label_where = "s.kode_kab='$kab' AND s.kode_kec='$kec' AND 
    //             w.idKab = s.kode_kab AND w.idKec=s.kode_kec AND w.idDesa=s.kode_desa";
    //     }
    //     else if($desa==null && $kec==null && $kab!=null){ //kecamatan in kabupaten

    //         $label_select = "w.idKec as idw, w.nmKec as nama, 
    //             SUM(if(s.kode_pcl IS NOT NULL OR j_keluarga_pengakuan>0, 1, 0)) AS jumlah_selesai_vk, 
    //             SUM(if(s.status_selesai_pcl<>0, 1, 0)) AS jumlah_selesai, 
    //             SUM(s.j_keluarga_pengakuan) AS jumlah_sls,
    //             SUM(s.j_keluarga_pcl) AS jumlah_pcl,
    //             SUM(s.j_keluarga_pml) AS jumlah_pml,
    //             SUM(s.j_keluarga_koseka) AS jumlah_koseka,
    //             SUM(s.j_keluarga_sls) AS jumlah_prelist,
    //             COUNT(s.id_sls) AS total";

    //         $label_join = " , p_kec w";

    //         $label_where = "s.kode_kab='$kab' AND w.idKab = s.kode_kab AND w.idKec=s.kode_kec";
    //     }
    //     else{ // all kabupaten in provinsi
    //         $label_select = "w.idKab as idw, w.nmKab as nama, 
    //             SUM(if(s.kode_pcl IS NOT NULL OR j_keluarga_pengakuan>0, 1, 0)) AS jumlah_selesai_vk, 
    //             SUM(if(s.status_selesai_pcl<>0, 1, 0)) AS jumlah_selesai, 
    //             SUM(s.j_keluarga_pengakuan) AS jumlah_sls,
    //             SUM(s.j_keluarga_pcl) AS jumlah_pcl,
    //             SUM(s.j_keluarga_pml) AS jumlah_pml,
    //             SUM(s.j_keluarga_koseka) AS jumlah_koseka,
    //             SUM(s.j_keluarga_sls) AS jumlah_prelist,
    //             COUNT(s.id_sls) AS total";

    //         $label_join = " , p_kab w";

    //         $label_where = "w.idKab=s.kode_kab";
    //     }

    //     $label_where .= " AND s.status_sls=1 ";

    //     $sql = "SELECT $label_select
    //         FROM regsosek_sls s $label_join 
    //         WHERE $label_where 
    //         GROUP BY idw, nama";

    //     $result = DB::select(DB::raw($sql));

    //     return $result;
    // }
}
