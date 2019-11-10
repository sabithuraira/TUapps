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

    public function OpnameRekap($i, /*$end_month,*/ $year){
        $label_select = "";
        $label_join = "";

        // for($i=$start_month;$i<=$end_month;$i++){
            $label_select .= ", IFNULL(op.sa_$i,0) as op_awal_$i, IFNULL(op.st_$i,0) as op_tambah_$i";

            $label_join .= ",SUM(CASE WHEN o.bulan =  $i THEN o.saldo_awal ELSE 0 END) sa_$i,
                SUM(CASE WHEN o.bulan =  $i THEN o.saldo_tambah ELSE 0 END) st_$i";
        // }

        $sql = "SELECT mb.id, mb.nama_barang, mb.harga_satuan, mb.satuan,
            IFNULL((SELECT SUM(jumlah_kurang) FROM opname_pengurangan WHERE id_barang=mb.id AND 
                bulan= $i AND tahun= $year),0) as pengeluaran  
            $label_select
                
            FROM master_barangs mb
            LEFT JOIN (
                SELECT o.id_barang $label_join 
                FROM opname_persediaan as o 
                WHERE tahun = $year 
                GROUP BY o.id_barang
            ) op ON op.id_barang=mb.id";

        // dd($sql);
        $result = DB::select(DB::raw($sql));

        return $result;
    }
}
