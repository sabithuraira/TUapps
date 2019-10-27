<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Opnamepersediaan extends Model
{
    protected $table = 'opname_persediaan';

    public function attributes()
    {
        return (new \App\Http\Requests\OpnamepersediaanRequest())->attributes();
    }

    public function OpnameRekap($start_month, $end_month, $year){
        $label_select = "";
        $label_join = "";

        for($i=$start_month;$i<$end_month;$i++){
            $label_select .= ", IFNULL(op.sa_1,0) as opa_1, IFNULL(op.st_1,0) as opt_1";

            $label_join .= ",SUM(CASE WHEN o.bulan =  1 THEN o.saldo_awal ELSE 0 END) sa_1,
                SUM(CASE WHEN o.bulan =  1 THEN o.saldo_tambah ELSE 0 END) st_1";
        }

        $sql = "SELECT mb.id, mb.nama_barang $label_select
                
            FROM master_barangs mb
            LEFT JOIN (
                SELECT o.id, o.id_barang $label_join 
                FROM opname_persediaan as o 
                WHERE year = $year
            ) op ON op.id_barang=mb.id";

        return $result;
    }
}
