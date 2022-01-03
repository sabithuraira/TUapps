<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokTransaksi extends Model{
    protected $table = 'pok_transaksi';
    
    public function rincian_anggaran(){
        return $this->hasOne('App\PokRincianAnggaran', 'id', 'id_rincian');
    }
}