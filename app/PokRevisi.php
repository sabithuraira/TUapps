<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokRevisi extends Model{
    protected $table = 'pok_revisi';
    
    public function getListStatusAttribute(){
        return array(
            1 => "<div class='badge badge-warning'>Diajukan</div>", 
            2 => "<div class='badge badge-info'>Disetujui PPK</div>", 
            4 => "<div class='badge badge-success'>Sudah direvisi</div>", 
            5 => "<div class='badge badge-warning'>Konfirmasi PPK</div>", 
            6 => "<div class='badge badge-warning'>Proses Pembayaran</div>", 
            7 => "<div class='badge badge-success'>Sudah dibayar/selesai</div>",
        );
    }
}