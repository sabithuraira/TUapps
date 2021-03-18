<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sp2020Sls extends Model
{
    protected $table = 'sp2020_sls';
    
    protected $fillable = [ 'kd_prov', 'kd_kab', 'kd_kec',
        'kd_desa', 'id_sls', 'dp_j_penduduk', 'target_penduduk', 
        'realisasi_penduduk', 'peta_j_keluarga', 'updated_phone', 'nama_sls'];
    
    public function attributes()
    {
        return [
            'kd_prov' => 'Provinsi',
            'kd_kab' => 'Kabupaten',
            'kd_kec' => 'Kecamatan',
            'kd_desa' => 'Desa',
            'id_sls' => 'ID SLS/Non SLS',
            'dp_j_penduduk' => 'Jumlah Penduduk DP',
            'target_penduduk' => 'target_penduduk',
            'realisasi_penduduk' => 'realisasi_penduduk',
            'peta_j_keluarga' => 'Jumlah Keluarga Pemetaan',
            'updated_phone' => 'Diupdate oleh',
        ];
    }


    public function Rekapitulasi($kab=null, $kec=null, $desa=null){
        $label_select = "";
        $label_join = "";
        $label_where = "";

        if($desa!=null){ //sls in kecamatan
            $label_select = "s.id_sls as idw, s.nama_sls as nama, SUM(s.dp_j_penduduk) as penduduk_dp, 
                SUM(s.target_penduduk) as target_penduduk, 
                SUM(s.realisasi_penduduk) as realisasi_penduduk";

            $label_join = "";

            $label_where = "s.kd_kab='$kab' AND s.kd_kec='$kec' AND s.kd_desa='$desa'";
        }
        else if($desa==null && $kec!=null){ //desa in kecamatan
            $label_select = "w.idDesa as idw, w.nmDesa as nama, SUM(s.dp_j_penduduk) as penduduk_dp, 
                SUM(s.target_penduduk) as target_penduduk, 
                SUM(s.realisasi_penduduk) as realisasi_penduduk";

            $label_join = " , p_desa w";

            $label_where = "s.kd_kab='$kab' AND s.kd_kec='$kec' AND 
                w.idKab = s.kd_kab AND w.idKec=s.kd_kec AND w.idDesa=s.kd_desa";
        }
        else if($desa==null && $kec==null && $kab!=null){ //kecamatan in kabupaten

            $label_select = "w.idKec as idw, w.nmKec as nama, SUM(s.dp_j_penduduk) as penduduk_dp, 
                SUM(s.target_penduduk) as target_penduduk, 
                SUM(s.realisasi_penduduk) as realisasi_penduduk";

            $label_join = " , p_kec w";

            $label_where = "s.kd_kab='$kab' AND w.idKab = s.kd_kab AND w.idKec=s.kd_kec";
        }
        else{ // all kabupaten in provinsi
            $label_select = "w.idKab as idw, w.nmKab as nama, SUM(s.dp_j_penduduk) as penduduk_dp, 
                SUM(s.target_penduduk) as target_penduduk, 
                SUM(s.realisasi_penduduk) as realisasi_penduduk";

            $label_join = " , p_kab w";

            $label_where = "w.idKab=s.kd_kab";
        }

        $sql = "SELECT $label_select
            FROM sp2020_sls s $label_join 
            WHERE $label_where 
            GROUP BY idw, nama";

        $result = DB::select(DB::raw($sql));

        return $result;
    }
}
