<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sp2020LfBs extends Model
{
    protected $table = 'sp2020lf_bs';
    
    protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
        'kd_desa', 'idbs', 'jumlah_ruta', 'jumlah_laki', 
        'jumlah_perempuan', 'jumlah_ruta_ada_mati', 'nks', 
        'jenis_sampel', 'jumlah_kk_lama', 'nama_sls'
    ];

    public function Rekapitulasi($kab=null, $kec=null, $desa=null){
        $label_select = "";
        $label_join = "";
        $label_where = "";

        if($desa!=null){ //sls in desaa
            $label_select = "s.idbs as idw, s.nama_sls as nama, 
                SUM(if(s.jumlah_ruta IS NOT NULL, 1, 0)) AS terlapor,
                COUNT(s.idbs) AS total,
                SUM(s.jumlah_ruta) as jumlah_ruta, 
                SUM(s.jumlah_laki) as jumlah_laki, 
                SUM(s.jumlah_perempuan) as jumlah_perempuan, 
                SUM(s.jumlah_ruta_ada_mati) as jumlah_ruta_ada_mati";

            $label_join = "";

            $label_where = "s.kd_kab='$kab' AND s.kd_kec='$kec' AND s.kd_desa='$desa'";
        }
        else if($desa==null && $kec!=null){ //desa in kecamatan
            $label_select = "w.idDesa as idw, w.nmDesa as nama, 
                SUM(if(s.jumlah_ruta IS NOT NULL, 1, 0)) AS terlapor,
                COUNT(s.idbs) AS total,
                SUM(s.jumlah_ruta) as jumlah_ruta, 
                SUM(s.jumlah_laki) as jumlah_laki, 
                SUM(s.jumlah_perempuan) as jumlah_perempuan, 
                SUM(s.jumlah_ruta_ada_mati) as jumlah_ruta_ada_mati";

            $label_join = " , p_desa w";

            $label_where = "s.kd_kab='$kab' AND s.kd_kec='$kec' AND 
                w.idKab = s.kd_kab AND w.idKec=s.kd_kec AND w.idDesa=s.kd_desa";
        }
        else if($desa==null && $kec==null && $kab!=null){ //kecamatan in kabupaten

            $label_select = "w.idKec as idw, w.nmKec as nama, 
                SUM(if(s.jumlah_ruta IS NOT NULL, 1, 0)) AS terlapor,
                COUNT(s.idbs) AS total,
                SUM(s.jumlah_ruta) as jumlah_ruta, 
                SUM(s.jumlah_laki) as jumlah_laki, 
                SUM(s.jumlah_perempuan) as jumlah_perempuan, 
                SUM(s.jumlah_ruta_ada_mati) as jumlah_ruta_ada_mati";

            $label_join = " , p_kec w";

            $label_where = "s.kd_kab='$kab' AND w.idKab = s.kd_kab AND w.idKec=s.kd_kec";
        }
        else{ // all kabupaten in provinsi
            $label_select = "w.idKab as idw, w.nmKab as nama, 
                SUM(if(s.jumlah_ruta IS NOT NULL, 1, 0)) AS terlapor,
                COUNT(s.idbs) AS total,
                SUM(s.jumlah_ruta) as jumlah_ruta, 
                SUM(s.jumlah_laki) as jumlah_laki, 
                SUM(s.jumlah_perempuan) as jumlah_perempuan, 
                SUM(s.jumlah_ruta_ada_mati) as jumlah_ruta_ada_mati";

            $label_join = " , p_kab w";

            $label_where = "w.idKab=s.kd_kab";
        }

        $sql = "SELECT $label_select
            FROM sp2020lf_bs s $label_join 
            WHERE $label_where 
            GROUP BY idw, nama";

        $result = DB::select(DB::raw($sql));

        return $result;
    }
}
