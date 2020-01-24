<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Opnamepersediaan extends Model
{
    protected $table = 'opname_persediaan';

    public function attributes()
    {
        return (new \App\Http\Requests\OpnamepersediaanRequest())->attributes();
    }

    public function triggerPersediaan($id_barang, $month, $year, $nama_barang){
        $model_op = \App\Opnamepersediaan::where('id_barang', '=' ,$id_barang)
                    ->where('bulan', '=', $month)
                    ->where('tahun', '=', $year)
                    ->first();

        if($model_op==null) {
            $model_op= new \App\Opnamepersediaan;
            $model_op->id_barang = $id_barang;
            $model_op->nama_barang = $nama_barang;
            $model_op->bulan = $month;
            $model_op->tahun = $year;
            $model_op->saldo_awal = 0;
            $model_op->harga_awal = 0;
            $model_op->created_by=Auth::id();
            $model_op->updated_by=Auth::id();
        }

        $jumlah_kurang = \App\OpnamePengurangan::where('id_barang', '=' ,$id_barang)
                        ->where('bulan', '=', $month)
                        ->where('tahun', '=', $year)
                        ->sum("jumlah_kurang");
                        
        $jumlah_harga_kurang = \App\OpnamePengurangan::where('id_barang', '=' ,$id_barang)
                    ->where('bulan', '=', $month)
                    ->where('tahun', '=', $year)
                    ->sum("harga_kurang");

        $jumlah_tambah = \App\OpnamePenambahan::where('id_barang', '=' ,$id_barang)
                        ->where('bulan', '=', $month)
                        ->where('tahun', '=', $year)
                        ->sum("jumlah_tambah");
                        
        $jumlah_harga_tambah = \App\OpnamePenambahan::where('id_barang', '=' ,$id_barang)
                        ->where('bulan', '=', $month)
                        ->where('tahun', '=', $year)
                        ->sum("harga_tambah");

        $model_op->saldo_tambah = $jumlah_tambah;
        $model_op->harga_tambah = $jumlah_harga_tambah;
        $model_op->saldo_kurang = $jumlah_kurang;
        $model_op->harga_kurang = $jumlah_harga_kurang;

        if($model_op->save()){
            $this->triggerAllMonth($id_barang, $month, $year, $nama_barang);
            // $jumlah_next_saldo = $model_op->saldo_awal + $model_op->saldo_tambah - $model_op->saldo_kurang;
            // $jumlah_next_harga = $model_op->harga_awal + $model_op->harga_tambah - $model_op->harga_kurang;
                
            // $next_month = ($month+1);
            // $next_year = $year;

            // if($month==12){
            //     $next_month = 1;
            //     $next_year = ($year+1);
            // }

            // $model_next = \App\Opnamepersediaan::where('id_barang', '=' ,$id_barang)
            //             ->where('bulan', '=', $next_month)
            //             ->where('tahun', '=', $next_year)
            //             ->first();

            // if($model_next==null) {
            //     $model_next= new \App\Opnamepersediaan;
            //     $model_next->id_barang = $id_barang;
            //     $model_next->bulan = $next_month;
            //     $model_next->tahun = $next_year;
            //     $model_next->created_by=Auth::id();
            //     $model_next->saldo_tambah = 0;
            //     $model_next->harga_tambah = 0;
            //     $model_next->saldo_kurang = 0;
            //     $model_next->harga_kurang = 0;
            // }

            // $model_next->nama_barang = $nama_barang;
            // $model_next->saldo_awal = $jumlah_next_saldo;
            // $model_next->harga_awal = $jumlah_next_harga;
            // $model_next->updated_by=Auth::id();
            // $model_next->save();
        }
    }

    //trigger all table persediaan value depend on previous month
    public function triggerAllMonth($id_barang, $month, $year, $nama_barang){
        $c_year = date('Y');
        $c_month = date('n');
        $user_id = Auth::id();

        for($y = $year;$y<=$c_year;++$y){
            if($y==$c_year){
                for($m =$month;$m<=$c_month-1;++$m){
                    $next_month = $m + 1;
                    $next_year = $y;

                    // $sql_where = "id_barang = $id_barang AND bulan = $m AND tahun = $y";
                    // $sql_where_next = "id_barang = $id_barang AND bulan = $next_month AND tahun = $next_year";

                    // $sqlnya = "IF EXISTS(SELECT * FROM opname_persediaan WHERE $sql_where_next) 
                    //     THEN
                    //         UPDATE opname_persediaan,
                    //             (SELECT 
                    //                 (saldo_awal+saldo_tambah-saldo_kurang) as total_saldo,
                    //                 (harga_awal+harga_tambah-harga_kurang) as total_harga    
                    //             FROM opname_persediaan WHERE $sql_where) AS prev_data 
                    //         SET saldo_awal = prev_data.total_saldo, harga_awal = prev_data.total_harga  
                    //         WHERE $sql_where_next ;
                    //     ELSE 
                    //         INSERT INTO opname_persediaan 
                    //         (id_barang, nama_barang, bulan, saldo_awal, harga_awal, saldo_tambah, harga_tambah, 
                    //         created_by, updated_by, tahun, saldo_kurang, harga_kurang) 
                    //         (SELECT $id_barang, $nama_barang, $next_month, 
                    //             (saldo_awal+saldo_tambah-saldo_kurang),
                    //             (harga_awal+harga_tambah-harga_kurang),
                    //             0, 0 , $user_id, $user_id, $next_year, 0, 0
                    //         FROM opname_persediaan WHERE $sql_where);
                    //     END IF;";
                            
                    // DB::statement(DB::raw($sqlnya));
                    DB::statement('call updatePersediaan(?, ?, ?, ?, ?, ?, ?)',[$m, $y, $id_barang, $nama_barang, $user_id, $next_month, $next_year]);
                }
            }
            else{
                for($m = $month;$m<=12;++$m){
                    if($m==12){
                        $next_month = 1;
                        $next_year = $y + 1;
                    }
                    else{
                        $next_month = $m + 1;
                        $next_year = $y;
                    }

                    DB::statement('call updatePersediaan(?, ?, ?, ?, ?, ?, ?)',[$m, $y, $id_barang, $nama_barang, $user_id, $next_month, $next_year]);
                }
            }

            $month = 1;
        }
    }

    public function OpnameRekap($i, $year){
        $label_select = "";
        $label_join = "";

        // for($i=$start_month;$i<=$end_month;$i++){
            $label_select .= ", IFNULL(op.saldo_awal,0) as op_awal,
                IFNULL(op.saldo_kurang,0) as op_kurang, 
                IFNULL(op.saldo_tambah,0) as op_tambah";

            $label_join .= ",SUM(CASE WHEN o.bulan =  $i THEN o.saldo_awal ELSE 0 END) saldo_awal,
                SUM(CASE WHEN o.bulan =  $i THEN o.saldo_kurang ELSE 0 END) saldo_kurang,
                SUM(CASE WHEN o.bulan =  $i THEN o.saldo_tambah ELSE 0 END) saldo_tambah";
        // }

        $sql = "SELECT mb.id, mb.nama_barang, mb.harga_satuan, mb.satuan
            $label_select
                
            FROM master_barangs mb
            LEFT JOIN (
                SELECT o.id_barang $label_join 
                FROM opname_persediaan as o 
                WHERE tahun = $year 
                GROUP BY o.id_barang
            ) op ON op.id_barang=mb.id";

        $result = DB::select(DB::raw($sql));

        return $result;
    }

    public function KartuKendali($barang, $month, $year){
        $sql = "SELECT op.id as id, jumlah_kurang as jumlah,
                        uk.nama as label, harga_kurang as harga, tanggal, 2 as jenis 
                    FROM `opname_pengurangan` op, unit_kerja4 uk WHERE 
                    bulan=$month AND tahun=$year AND id_barang=$barang
                    AND op.unit_kerja4=uk.id
                UNION
                SELECT id, jumlah_tambah as jumlah,
                        nama_penyedia, harga_tambah as harga, tanggal, 1 as jenis
                    FROM `opname_penambahan` WHERE 
                    bulan=$month AND tahun=$year AND id_barang=$barang
                    ORDER BY tanggal";

        $result = DB::select(DB::raw($sql));
        return $result;
    }
}
