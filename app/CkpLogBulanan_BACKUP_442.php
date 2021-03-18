<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CkpLogBulanan extends Model
{
    protected $table = 'ckp_log_bulanan';

     public function triggerCkp($user_id, $user_id_int, $month, $year){
        // DB::statement('call updateCKPLog(?, ?, ?, ?)',[$month, $year, $user_id, $user_id_int]);
        // $sql = "IF EXISTS(SELECT * FROM ckp_log_bulanan
        //           WHERE user_id = '$user_id' AND month = $month AND year = $year) 
        //             THEN
        //             UPDATE ckp_log_bulanan,
        //                 (SELECT 
        //                     COALESCE(SUM(target_kuantitas),0) as ctarget_kuantitas,
        //                     COALESCE(SUM(realisasi_kuantitas),0) as crealisasi_kuantitas,
        //                     COALESCE(AVG(kualitas),0) as ckualitas,
        //                     COALESCE(AVG(kecepatan),0) as ckecepatan,
        //                     COALESCE(AVG(ketepatan),0) as cketepatan,
        //                     COALESCE(AVG(ketuntasan),0) as cketuntasan
        //                     FROM ckps
        //                     WHERE user_id='$user_id' AND month = $month AND year = $year) AS cdata 
                
        //                 SET  
        //                 target_kuantitas = cdata.ctarget_kuantitas, 
        //                 realisasi_kuantitas = cdata.crealisasi_kuantitas, 
        //                 kualitas = cdata.ckualitas, 
        //                 kecepatan = cdata.ckecepatan, 
        //                 ketepatan = cdata.cketepatan, 
        //                 ketuntasan = cdata.cketuntasan,
        //                 updated_at = NOW()
                
                        
        //                 WHERE user_id = '$user_id' AND month = $month AND year = $year ;
        //             ELSE
        //             INSERT INTO ckp_log_bulanan 
        //                 (target_kuantitas, realisasi_kuantitas, kualitas, 
        //                 kecepatan, ketepatan, ketuntasan, 
        //                 user_id, month, year, created_by, updated_by, 
        //                 created_at, updated_at) 
                
        //             (SELECT 
        //                     COALESCE(SUM(target_kuantitas),0) as ctarget_kuantitas,
        //                     COALESCE(SUM(realisasi_kuantitas),0) as crealisasi_kuantitas,
        //                     COALESCE(AVG(kualitas),0) as ckualitas,
        //                     COALESCE(AVG(kecepatan),0) as ckecepatan,
        //                     COALESCE(AVG(ketepatan),0) as cketepatan,
        //                     COALESCE(AVG(ketuntasan),0) as cketuntasan,
        //                     '$user_id', $month, $year, $user_id_int, $user_id_int,
        //                     NOW(), NOW()
        //                     FROM ckps
        //                     WHERE user_id='$user_id' AND month = $month AND year = $year);
        //             END IF;";

        $ckp_log = CkpLogBulanan::where([['user_id', '=', $user_id],
            ['month', '=', $month],['year', '=', $year],])->first();

        $sql = "";
        if ($ckp_log === null) {
            $sql = "INSERT INTO ckp_log_bulanan 
                (target_kuantitas, realisasi_kuantitas, kualitas, 
                kecepatan, ketepatan, ketuntasan, penilaian_pimpinan, 
                user_id, month, year, created_by, updated_by, 
                created_at, updated_at) 
        
            (SELECT 
                    COALESCE(SUM(target_kuantitas),0) as ctarget_kuantitas,
                    COALESCE(SUM(realisasi_kuantitas),0) as crealisasi_kuantitas,
                    COALESCE(AVG(kualitas),0) as ckualitas,
                    COALESCE(AVG(kecepatan),0) as ckecepatan,
                    COALESCE(AVG(ketepatan),0) as cketepatan,
                    COALESCE(AVG(ketuntasan),0) as cketuntasan,
                    COALESCE(AVG(penilaian_pimpinan),0) as cpenilaian_pimpinan,
                    '$user_id', $month, $year, $user_id_int, $user_id_int,
                    NOW(), NOW()
                    FROM ckps
                    WHERE user_id='$user_id' AND month = $month AND year = $year)";
        }
        else{
            $sql = "UPDATE ckp_log_bulanan,
                        (SELECT 
                            COALESCE(SUM(target_kuantitas),0) as ctarget_kuantitas,
                            COALESCE(SUM(realisasi_kuantitas),0) as crealisasi_kuantitas,
                            COALESCE(AVG(kualitas),0) as ckualitas,
                            COALESCE(AVG(kecepatan),0) as ckecepatan,
                            COALESCE(AVG(ketepatan),0) as cketepatan,
                            COALESCE(AVG(ketuntasan),0) as cketuntasan,
                            COALESCE(AVG(penilaian_pimpinan),0) as cpenilaian_pimpinan
                            FROM ckps
                            WHERE user_id='$user_id' AND month = $month AND year = $year) AS cdata 
                        SET target_kuantitas = cdata.ctarget_kuantitas, 
                            realisasi_kuantitas = cdata.crealisasi_kuantitas, 
                            kualitas = cdata.ckualitas, 
                            kecepatan = cdata.ckecepatan, 
                            ketepatan = cdata.cketepatan, 
                            ketuntasan = cdata.cketuntasan,
                            penilaian_pimpinan = cdata.cpenilaian_pimpinan,
                            updated_at = NOW()    
                        WHERE user_id = '$user_id' AND month = $month AND year = $year";
        }

        DB::statement($sql);
    }

    //rekap per unit kerja per hari
    public function RekapPerUnitKerjaPerBulan($unit_kerja, $month, $year){
        $str_where = "kdkab = '$unit_kerja'";

        if($unit_kerja==111) $str_where = "kdesl='2' || kdesl='3'";

        $sql = "SELECT u.id, u.name, u.nip_baru, u.kdorg,
            ckp_log_bulanan.target_kuantitas, 
            ckp_log_bulanan.realisasi_kuantitas, 
            ckp_log_bulanan.kualitas, 
            ckp_log_bulanan.kecepatan, 
            ckp_log_bulanan.ketepatan, 
            ckp_log_bulanan.ketuntasan, 
            ckp_log_bulanan.penilaian_pimpinan
            
            FROM `users` u 
            LEFT JOIN ckp_log_bulanan ON ckp_log_bulanan.user_id=u.email 
                AND ckp_log_bulanan.month=$month 
                AND ckp_log_bulanan.year=$year 
            
            WHERE $str_where
            ORDER by kdorg";
            
        $result = DB::select(DB::raw($sql));
        return $result;
    }
<<<<<<< HEAD
=======

    public function RekapCkpPegawaiPerTahun($user_id, $year){
        $label_sum_bulan = "";
        $label_union = "";

        for($i=1;$i<=12;++$i){
            if($i>1){
                $label_union .= " UNION ALL SELECT $i ";
                $label_sum_bulan .= ", SUM(CASE WHEN (month=$i) THEN ((realisasi_kuantitas/target_kuantitas*100)+kualitas)/2 ELSE 0 END) AS bulan$i";
            }
            else{
                $label_sum_bulan .= " SUM(CASE WHEN (month=$i) THEN ((realisasi_kuantitas/target_kuantitas*100)+kualitas)/2 ELSE 0 END) AS bulan$i";
            }
        }

        $sql = "SELECT $label_sum_bulan
                FROM (
                    SELECT 1 AS val
                    $label_union 
                ) AS daftar
                LEFT JOIN ckp_log_bulanan ON ckp_log_bulanan.month=daftar.val 
                AND ckp_log_bulanan.year=$year 
                WHERE user_id = '$user_id'";

                
        $result = DB::select(DB::raw($sql));
        return $result;
    }
>>>>>>> a94157905379bf0ebf9740f4c12e79d2333a1864
}
