<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LogBook extends Model
{
    protected $table = 'log_books';

    public function attributes()
    {
        return (new \App\Http\Requests\LogBookRequest())->attributes();
    }

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Rekap pengisian logbook per ketua tim (leader).
     * Leaders = distinct users.pimpinan_nik joined to users.nip_baru.
     * Counts distinct subordinates who filled logbook (not row count).
     *
     * @param string $mode day|month
     * @param string|null $tanggal Y-m-d (for day)
     * @param int|null $month
     * @param int|null $year
     * @return array
     */
    public function RekapPerPimpinan($mode = 'day', $tanggal = null, $month = null, $year = null)
    {
        if ($mode === 'month') {
            $month = (int) $month;
            $year = (int) $year;
            $dateJoin = "MONTH(lb.tanggal) = ? AND YEAR(lb.tanggal) = ? AND (lb.is_rencana = 0 OR lb.is_rencana IS NULL)";
            $bindings = [$month, $year];
        } else {
            $tanggal = date('Y-m-d', strtotime($tanggal ?: date('Y-m-d')));
            $dateJoin = "DATE(lb.tanggal) = ? AND (lb.is_rencana = 0 OR lb.is_rencana IS NULL)";
            $bindings = [$tanggal];
        }

        $sql = "SELECT
                leader.nip_baru AS leader_nip,
                leader.name AS leader_name,
                leader.nmjab AS leader_jabatan,
                leader.email AS leader_email,
                COUNT(DISTINCT u.id) AS total_anggota,
                COUNT(DISTINCT lb.user_id) AS user_isi_logbook
            FROM users u
            INNER JOIN users leader ON leader.nip_baru = u.pimpinan_nik AND leader.kdkab = '00'
            LEFT JOIN log_books lb ON lb.user_id = u.email AND $dateJoin
            WHERE u.pimpinan_nik IS NOT NULL
                AND u.pimpinan_nik <> ''
                AND u.is_active = 1
                AND u.kdkab = '00'
            GROUP BY leader.nip_baru, leader.name, leader.nmjab, leader.email
            ORDER BY user_isi_logbook DESC, leader.name ASC";

        $rows = DB::select(DB::raw($sql), $bindings);

        $result = [];
        foreach ($rows as $row) {
            $totalAnggota = (int) $row->total_anggota;
            $userIsi = (int) $row->user_isi_logbook;
            $persen = $totalAnggota > 0
                ? round(($userIsi / $totalAnggota) * 100, 1)
                : 0;

            $result[] = [
                'leader_nip' => $row->leader_nip,
                'leader_name' => $row->leader_name,
                'leader_jabatan' => $row->leader_jabatan,
                'leader_email' => $row->leader_email,
                'total_anggota' => $totalAnggota,
                'user_isi_logbook' => $userIsi,
                'persentase' => $persen,
            ];
        }

        return $result;
    }

    /**
     * Detail anggota + logbook (tanggal, isi) under a ketua tim for day/month filter.
     *
     * @param string $leaderNip
     * @param string $mode day|month
     * @param string|null $tanggal
     * @param int|null $month
     * @param int|null $year
     * @return array
     */
    public function DetailLogbookPerPimpinan($leaderNip, $mode = 'day', $tanggal = null, $month = null, $year = null)
    {
        if ($mode === 'month') {
            $month = (int) $month;
            $year = (int) $year;
            $dateJoin = "MONTH(lb.tanggal) = ? AND YEAR(lb.tanggal) = ? AND (lb.is_rencana = 0 OR lb.is_rencana IS NULL)";
            $bindings = [$month, $year, $leaderNip];
        } else {
            $tanggal = date('Y-m-d', strtotime($tanggal ?: date('Y-m-d')));
            $dateJoin = "DATE(lb.tanggal) = ? AND (lb.is_rencana = 0 OR lb.is_rencana IS NULL)";
            $bindings = [$tanggal, $leaderNip];
        }

        $sql = "SELECT
                u.name AS user_name,
                u.nip_baru AS user_nip,
                u.email AS user_email,
                lb.tanggal AS tanggal,
                lb.isi AS isi
            FROM users u
            LEFT JOIN log_books lb ON lb.user_id = u.email AND $dateJoin
            WHERE u.pimpinan_nik = ?
                AND u.pimpinan_nik IS NOT NULL
                AND u.pimpinan_nik <> ''
                AND u.is_active = 1
                AND u.kdkab = '00'
            ORDER BY u.name ASC, lb.tanggal ASC, lb.id ASC";

        $rows = DB::select(DB::raw($sql), $bindings);

        $grouped = [];
        foreach ($rows as $row) {
            $key = $row->user_email ?: $row->user_nip;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'user_name' => $row->user_name,
                    'user_nip' => $row->user_nip,
                    'user_email' => $row->user_email,
                    'tanggal' => [],
                    'isi' => [],
                ];
            }

            if ($row->tanggal) {
                $grouped[$key]['tanggal'][] = date('Y-m-d', strtotime($row->tanggal));
                $grouped[$key]['isi'][] = $row->isi;
            }
        }

        $result = [];
        foreach ($grouped as $item) {
            $result[] = [
                'user_name' => $item['user_name'],
                'user_nip' => $item['user_nip'],
                'user_email' => $item['user_email'],
                'tanggal' => $item['tanggal'],
                'isi' => $item['isi'],
            ];
        }

        return $result;
    }

    /**
     * Daily unique users who filled logbook (subordinates with a ketua tim) for a month.
     *
     * @param int $month
     * @param int $year
     * @return array list of ['date' => Y-m-d, 'total' => int]
     */
    public function RekapHarianSemuaPimpinan($month, $year)
    {
        $month = (int) $month;
        $year = (int) $year;

        $sql = "SELECT DATE(lb.tanggal) AS d, COUNT(DISTINCT lb.user_id) AS total
            FROM log_books lb
            INNER JOIN users u ON u.email = lb.user_id
            INNER JOIN users leader ON leader.nip_baru = u.pimpinan_nik AND leader.kdkab = '00'
            WHERE u.pimpinan_nik IS NOT NULL
                AND u.pimpinan_nik <> ''
                AND u.is_active = 1
                AND u.kdkab = '00'
                AND MONTH(lb.tanggal) = ?
                AND YEAR(lb.tanggal) = ?
                AND (lb.is_rencana = 0 OR lb.is_rencana IS NULL)
            GROUP BY d
            ORDER BY d ASC";

        $rows = DB::select(DB::raw($sql), [$month, $year]);

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'date' => $row->d,
                'total' => (int) $row->total,
            ];
        }

        return $result;
    }

    //rekap per unit kerja per hari
    public function RekapPerUnitKerjaPerHari($unit_kerja, $tanggal, $separate=' <br/> '){
        $str_where = "kdkab = '$unit_kerja' AND is_active=1";

        if($unit_kerja==111) $str_where = "kdesl='2' || kdesl='3'";

        $sql = "SELECT u.id, u.name, u.nip_baru, u.kdorg,  u.kdesl,
            GROUP_CONCAT(log_books.isi SEPARATOR '$separate') isi, 
            GROUP_CONCAT(log_books.hasil SEPARATOR '$separate') hasil
            
            FROM `users` u 
            LEFT JOIN log_books ON (log_books.user_id=u.email AND  log_books.tanggal='$tanggal' 
                AND (log_books.is_rencana=0 OR log_books.is_rencana IS NULL))
            
            WHERE $str_where
            GROUP BY u.id, u.name, u.nip_baru, u.kdorg , u.kdesl
            ORDER by kdorg";
            
        $result = DB::select(DB::raw($sql));
        return $result;
    }

    public  function RekapUkerPerBulan($unit_kerja, $month, $year){
        $sql = "SELECT u.id, u.name, u.nip_baru, COUNT(log_books.id) as total_logbook
            FROM `users` u 
            LEFT JOIN log_books ON (log_books.user_id=u.email 
            	AND MONTH(log_books.tanggal)=$month 
                AND YEAR(log_books.tanggal)=$year 
                AND (log_books.is_rencana=0 OR log_books.is_rencana IS NULL))
            
            WHERE u.kdkab = '$unit_kerja' 
            	AND u.is_active=1
            GROUP BY u.id, u.name, u.nip_baru
            ORDER by total_logbook DESC";

        $result = DB::select(DB::raw($sql));
        return $result;
    }

    /**
     * Rekap total logbook per date per user for a unit kerja in a month.
     * Returns array keyed by user id, then by date (Y-m-d), value = count.
     */
    public function RekapUkerPerDate($unit_kerja, $month, $year)
    {
        $sql = "SELECT u.id, DATE(lb.tanggal) as d, COUNT(lb.id) as cnt
            FROM users u
            INNER JOIN log_books lb ON lb.user_id = u.email
                AND MONTH(lb.tanggal) = ?
                AND YEAR(lb.tanggal) = ?
                AND (lb.is_rencana = 0 OR lb.is_rencana IS NULL)
            WHERE u.kdkab = ?
                AND u.is_active = 1
            GROUP BY u.id, d";
        $rows = DB::select(DB::raw($sql), [$month, $year, $unit_kerja]);

        $counts = [];
        foreach ($rows as $r) {
            if (!isset($counts[$r->id])) {
                $counts[$r->id] = [];
            }
            $counts[$r->id][$r->d] = (int) $r->cnt;
        }
        return $counts;
    }

    //rekap per pegawai dalam rentang waktu tertentu
    public function LogBookRekap($start_date, $end_date, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->where(
                [
                    ['log_books.tanggal', '>=', $start_date],
                    ['log_books.tanggal', '<=', $end_date],
                    ['log_books.user_id', '=', $user_id],
                ]

                // (function ($query) {
                //     $query->where('log_books.tanggal', '>=', $start_date)
                //         ->Where('log_books.tanggal', '<=', $end_date)
                //         ->Where('log_books.user_id', '=', $user_id);
                // })
            )
            ->where(
                (function ($query) {
                    $query->where('log_books.is_rencana', '=', 0)
                        ->orWhereNull('log_books.is_rencana');
                })
            )
            ->orderBy('log_books.tanggal', 'desc')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'user_id'           =>$value->user_id,
                'tanggal'           =>date('d M Y', strtotime($value->tanggal)),
                'real_tanggal'      =>date('m/d/Y', strtotime($value->tanggal)),
                'waktu_mulai'       =>date('H:i', strtotime($value->waktu_mulai)),
                'waktu_selesai'     =>date('H:i', strtotime($value->waktu_selesai)),
                'isi'               =>$value->isi,
                'hasil'             =>$value->hasil,
                'catatan_pimpinan'  =>$value->catatan_pimpinan,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
                'ckp_id'            =>$value->ckp_id,
                'volume'            =>$value->volume,
                'satuan'            =>$value->satuan,
                'pemberi_tugas'     =>$value->pemberi_tugas,
                'pemberi_tugas_id'     =>$value->pemberi_tugas_id,
                'pemberi_tugas_jabatan'     =>$value->pemberi_tugas_jabatan,
                'status_penyelesaian' =>$value->status_penyelesaian,
                'jumlah_jam' =>$value->jumlah_jam,
            );
        }

        return $result;
    }

    //rekap per pegawai dalam rentang waktu tertentu
    public function RencanaKerjaRekap($start_date, $end_date, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->where([
                ['log_books.tanggal', '>=', $start_date],
                ['log_books.tanggal', '<=', $end_date],
                ['log_books.user_id', '=', $user_id],
                ['log_books.is_rencana', '=', 1],
            ])
            ->orderBy('log_books.tanggal', 'desc')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'user_id'           =>$value->user_id,
                'tanggal'           =>date('d M Y', strtotime($value->tanggal)),
                'real_tanggal'      =>date('m/d/Y', strtotime($value->tanggal)),
                'waktu_mulai'       =>date('H:i', strtotime($value->waktu_mulai)),
                'waktu_selesai'     =>date('H:i', strtotime($value->waktu_selesai)),
                'isi'               =>$value->isi,
                'hasil'             =>$value->hasil,
                'catatan_pimpinan'  =>$value->catatan_pimpinan,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
                'ckp_id'            =>$value->ckp_id,
                'volume'            =>$value->volume,
                'satuan'            =>$value->satuan,
                'pemberi_tugas'     =>$value->pemberi_tugas,
                'pemberi_tugas_id'     =>$value->pemberi_tugas_id,
                'pemberi_tugas_jabatan'     =>$value->pemberi_tugas_jabatan,
                'status_penyelesaian' =>$value->status_penyelesaian,
                'jumlah_jam' =>$value->jumlah_jam,
            );
        }

        return $result;
    }

    //rekap tim
    public function LogBookRekapTim($month, $year, $user_id){
        $result = array();
        $datas = array();

        $datas = DB::table('log_books')
            ->leftJoin('users', 'log_books.user_id', '=', 'users.email')
            ->where(
                [
                    [\DB::raw('MONTH(tanggal)'), '=', $month],
                    [\DB::raw('YEAR(tanggal)'), '=', $year],
                    ['log_books.pemberi_tugas_id', '=', $user_id],
                ]
            )
            ->where(
                (function ($query) {
                    $query->where('log_books.is_rencana', '=', 0)
                        ->orWhereNull('log_books.is_rencana');
                })
            )
            ->select('log_books.*', 'users.name', 'users.nmjab')
            ->orderBy('log_books.tanggal', 'desc')
            ->get();

        foreach($datas as $key=>$value){
            $result[]=array(
                'id'                =>$value->id,
                'user_id'           =>$value->user_id,
                'user_name'           =>$value->name,
                'user_nmjab'           =>$value->nmjab,
                'tanggal'           =>date('d M Y', strtotime($value->tanggal)),
                'real_tanggal'      =>date('m/d/Y', strtotime($value->tanggal)),
                'waktu_mulai'       =>date('H:i', strtotime($value->waktu_mulai)),
                'waktu_selesai'     =>date('H:i', strtotime($value->waktu_selesai)),
                'isi'               =>$value->isi,
                'hasil'             =>$value->hasil,
                'catatan_pimpinan'  =>$value->catatan_pimpinan,
                'created_by'        =>$value->created_by,
                'updated_by'        =>$value->updated_by,
                'ckp_id'            =>$value->ckp_id,
                'volume'            =>$value->volume,
                'satuan'            =>$value->satuan,
                'pemberi_tugas'     =>$value->pemberi_tugas,
                'pemberi_tugas_id'     =>$value->pemberi_tugas_id,
                'pemberi_tugas_jabatan'     =>$value->pemberi_tugas_jabatan,
                'status_penyelesaian' =>$value->status_penyelesaian,
                'jumlah_jam' =>$value->jumlah_jam,
            );
        }

        return $result;
    }
}
