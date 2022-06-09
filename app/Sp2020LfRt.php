<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sp2020LfRt extends Model
{
    protected $table = 'sp2020lf_rt';
    
    protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
        'kd_desa', 'idbs', 'status_rt', 'nama_krt', 
        'jumlah_art', 'jumlah_perempuan_1549', 'jumlah_mati'];

    public function Rekapitulasi($kab=null, $kec=null, $desa=null, $bs=null){
        $label_select = "";
        $label_join = "";
        $label_where = "";

        if($bs!=null){
        }
        else if($bs==null && $desa!=null){ //sls in desa
            $label_select = "sp2020lf_bs.idbs as idw, sp2020lf_bs.nama_sls as nama, 
                COUNT(sp2020lf_rt.idbs) AS terlapor,
                COUNT(sp2020lf_bs.idbs) AS total,
                sp2020lf_bs.c2_terima_kortim AS kortim,
                sp2020lf_bs.c2_terima_koseka AS koseka,
                SUM(sp2020lf_rt.jumlah_art) as jumlah_art,  
                SUM(sp2020lf_rt.jumlah_perempuan_1549) as jumlah_perempuan_1549, 
                SUM(sp2020lf_rt.jumlah_mati) as jumlah_mati";

            $label_join = "";

            $label_where = " WHERE sp2020lf_bs.kd_kab='$kab' AND 
                sp2020lf_bs.kd_kec='$kec' AND 
                sp2020lf_bs.kd_desa='$desa' ";
        }
        else if($bs==null && $desa==null && $kec!=null){ //desa in kecamatan
            $label_select = "w.idDesa as idw, w.nmDesa as nama, 
                COUNT(sp2020lf_rt.idbs) AS terlapor,
                COUNT(sp2020lf_bs.idbs) AS total,
                sp2020lf_bs.c2_terima_kortim AS kortim,
                sp2020lf_bs.c2_terima_koseka AS koseka,
                SUM(sp2020lf_rt.jumlah_art) as jumlah_art, 
                SUM(sp2020lf_rt.jumlah_perempuan_1549) as jumlah_perempuan_1549, 
                SUM(sp2020lf_rt.jumlah_mati) as jumlah_mati";

            $label_join = " INNER JOIN p_desa as w ON 
                sp2020lf_bs.kd_kab=w.idKab AND 
                sp2020lf_bs.kd_kec=w.idKec AND 
                sp2020lf_bs.kd_desa=w.idDesa ";

            $label_where = " WHERE sp2020lf_bs.kd_kab='$kab' AND 
                sp2020lf_bs.kd_kec='$kec'  ";
        }
        else if($bs==null && $desa==null && $kec==null && $kab!=null){ //kecamatan in kabupaten
            $label_select = "w.idKec as idw, w.nmKec as nama, 
                COUNT(sp2020lf_rt.idbs) AS terlapor,
                COUNT(sp2020lf_bs.idbs) AS total,
                SUM(sp2020lf_bs.c2_terima_kortim) AS kortim,
                SUM(sp2020lf_bs.c2_terima_koseka) AS koseka,
                SUM(sp2020lf_rt.jumlah_art) as jumlah_art, 
                SUM(sp2020lf_rt.jumlah_perempuan_1549) as jumlah_perempuan_1549, 
                SUM(sp2020lf_rt.jumlah_mati) as jumlah_mati";

            $label_join = " INNER JOIN p_kec as w ON sp2020lf_bs.kd_kab=w.idKab AND 
                sp2020lf_bs.kd_kec=w.idKec ";

            $label_where = " WHERE sp2020lf_bs.kd_kab='$kab' ";
        }
        else{ // all kabupaten in provinsi
            $label_select = "w.idKab as idw, w.nmKab as nama, 
                COUNT(sp2020lf_rt.idbs) AS terlapor,
                COUNT(sp2020lf_bs.idbs) AS total,
                SUM(sp2020lf_bs.c2_terima_kortim) AS kortim,
                SUM(sp2020lf_bs.c2_terima_koseka) AS koseka,
                SUM(sp2020lf_rt.jumlah_art) as jumlah_art, 
                SUM(sp2020lf_rt.jumlah_perempuan_1549) as jumlah_perempuan_1549, 
                SUM(sp2020lf_rt.jumlah_mati) as jumlah_mati";

            $label_join = " INNER JOIN p_kab as w ON sp2020lf_bs.kd_kab=w.idKab ";
        }
        
        if($bs!=null){
            $sql = "SELECT sp2020lf_rt.nurts as idw, sp2020lf_rt.nama_krt as nama, 
                    1 AS terlapor,
                    1 AS total,
                    1 AS kortim,
                    1 AS koseka,
                    sp2020lf_rt.jumlah_art as jumlah_art, 
                    sp2020lf_rt.jumlah_perempuan_1549 as jumlah_perempuan_1549, 
                    sp2020lf_rt.jumlah_mati as jumlah_mati 
                FROM sp2020lf_rt 
                WHERE sp2020lf_rt.kd_kab='$kab' AND 
                    sp2020lf_rt.kd_kec='$kec' AND 
                    sp2020lf_rt.kd_desa='$desa' AND 
                    sp2020lf_rt.idbs='$bs' ";
        }
        else{
            $sql = "SELECT $label_select 
                FROM sp2020lf_bs $label_join 
                LEFT JOIN sp2020lf_rt ON sp2020lf_rt.idbs=sp2020lf_bs.idbs 
                $label_where 
                GROUP BY idw, nama, kortim, koseka";
        }

        // print_r($sql);die();

        $result = DB::select(DB::raw($sql));
        return $result;
    }
}
