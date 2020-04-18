<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CkpLogBulanan extends Model
{
    protected $table = 'ckp_log_bulanan';

     public function triggerCkp($user_id, $user_id_int, $month, $year){
        // DB::statement('call updateCKPLog(?, ?, ?, ?)',[$month, $year, $user_id, $user_id_int]);
        $sql = "IF EXISTS(SELECT * FROM ckp_log_bulanan
                  WHERE user_id = '$user_id' AND month = $month AND year = $year) 
                    THEN
                    UPDATE ckp_log_bulanan,
                        (SELECT 
                            COALESCE(SUM(target_kuantitas),0) as ctarget_kuantitas,
                            COALESCE(SUM(realisasi_kuantitas),0) as crealisasi_kuantitas,
                            COALESCE(AVG(kualitas),0) as ckualitas,
                            COALESCE(AVG(kecepatan),0) as ckecepatan,
                            COALESCE(AVG(ketepatan),0) as cketepatan,
                            COALESCE(AVG(ketuntasan),0) as cketuntasan
                            FROM ckps
                            WHERE user_id='$user_id' AND month = $month AND year = $year) AS cdata 
                
                        SET  
                        target_kuantitas = cdata.ctarget_kuantitas, 
                        realisasi_kuantitas = cdata.crealisasi_kuantitas, 
                        kualitas = cdata.ckualitas, 
                        kecepatan = cdata.ckecepatan, 
                        ketepatan = cdata.cketepatan, 
                        ketuntasan = cdata.cketuntasan,
                        updated_at = NOW()
                
                        
                        WHERE user_id = '$user_id' AND month = $month AND year = $year ;
                    ELSE
                    INSERT INTO ckp_log_bulanan 
                        (target_kuantitas, realisasi_kuantitas, kualitas, 
                        kecepatan, ketepatan, ketuntasan, 
                        user_id, month, year, created_by, updated_by, 
                        created_at, updated_at) 
                
                    (SELECT 
                            COALESCE(SUM(target_kuantitas),0) as ctarget_kuantitas,
                            COALESCE(SUM(realisasi_kuantitas),0) as crealisasi_kuantitas,
                            COALESCE(AVG(kualitas),0) as ckualitas,
                            COALESCE(AVG(kecepatan),0) as ckecepatan,
                            COALESCE(AVG(ketepatan),0) as cketepatan,
                            COALESCE(AVG(ketuntasan),0) as cketuntasan,
                            '$user_id', $month, $year, $user_id_int, $user_id_int,
                            NOW(), NOW()
                            FROM ckps
                            WHERE user_id='$user_id' AND month = $month AND year = $year);
                    END IF;";
        DB::statement($sql);
    }
}
