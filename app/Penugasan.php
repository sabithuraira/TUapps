<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

        // print_r($participant);
        // die();

        $label = "<ul>";
        foreach($participant as $key=>$value){
            $label .= "<li><small>".$value['user_nip_baru']." - ".$value['user_nama']."</small></li>";
        }
        
        $label .= "</ul>";

        return $label;
    }
}
