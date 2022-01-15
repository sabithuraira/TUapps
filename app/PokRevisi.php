<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokRevisi extends Model{
    protected $table = 'pok_revisi';
    
    public function getListStatusAttribute(){
        return array(
            0 => "<div class='badge badge-warning'>Menunggu Persetujuan PPK</div>", 
            1 => "<div class='badge badge-info'>Disetujui PPK</div>", 
            2 => "<div class='badge badge-danger'>Ditolak PPK</div>", 
            3 => "<div class='badge badge-success'>Sudah direvisi</div>", 
            4 => "<div class='badge badge-danger'>Dibatalkan</div>", 
        );
    }
    
    public function attributes(){
        return (new \App\Http\Requests\PokRevisiRequest())->attributes();
    }
    
    public function User(){
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}