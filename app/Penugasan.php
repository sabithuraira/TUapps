<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penugasan extends Model
{
    protected $table = 'penugasan';

    public function attributes()
    {
        return [
            'isi' => 'Isi',
            'keterangan' => 'Keterangan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'satuan' => 'Satuan',
            'jenis_periode' => 'Jenis Periode',
        ];
    }

    public function getStatusDataAttribute(){
        return [
            0 => '<span class="badge badge-warning">Belum Selesai</span>',
            1 => '<span class="badge badge-success">Selesai</span>',
        ];
    }

    public function getListJenisPeriodeAttribute()
    {
        return array(
            1 => 'Bulanan', 
            2 => 'Triwulan', 
            3 => 'Subround', 
            4 => 'Tahunan', 
        );
    }

    public function getListPesertaAttribute(){
        $participant = PenugasanParticipant::where('penugasan_id', '=', $this->id)
                ->limit(3)->get();

        $label = "<ul>";
        foreach($participant as $key=>$value){
            $label .= "<li><small>".$value['user_nip_baru']." - ".$value['user_nama']."</small></li>";
        }
        
        $label .= "</ul>";

        return $label;
    }

    
    public function CreatedBy(){
        return $this->hasOne('App\UserModel', 'id', 'created_by');
    }
    
    public function FungsiLabel(){
        return $this->hasOne('App\UnitKerja4', 'id', 'ditugaskan_oleh_fungsi');
    }

    public function Rekap($bulan, $year, $user){
        $datas = array();

        $datas = DB::table('penugasan_participant')
            ->join('penugasan', 'penugasan.id', '=', 'penugasan_participant.penugasan_id')
            ->where('penugasan_participant.user_id', '=', $user)
            ->where(
                (function ($query) use ($bulan) {
                    if($bulan!=''){
                        $query->where(DB::raw('MONTH(penugasan.tanggal_mulai)'), '=', $bulan)
                            ->orWhere(DB::raw('MONTH(penugasan.tanggal_selesai)'), '=', $bulan);
                    }
                })
            )
            ->where(
                (function ($query) use ($year) {
                    if($year!=''){
                        $query->where(DB::raw('YEAR(penugasan.tanggal_mulai)'), '=', $year)
                            ->orWhere(DB::raw('YEAR(penugasan.tanggal_selesai)'), '=', $year);
                    }
                })
            )
            ->select('penugasan.isi','penugasan.keterangan', 
                'penugasan.tanggal_mulai','penugasan.tanggal_selesai','penugasan.satuan', 
                'penugasan.jenis_periode', 'penugasan.unit_kerja', 
                'penugasan.ditugaskan_oleh_fungsi', 'penugasan.status', 'penugasan_participant.*')
            ->orderBy('penugasan.tanggal_mulai', 'desc')
            ->get();

        return $datas;
    }
}
