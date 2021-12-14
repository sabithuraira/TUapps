<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokKro extends Model{
    protected $table = 'pok_kro';
    
    public function program(){
        return $this->hasOne('App\PokProgram', 'id', 'id_program');
    }
    
    public function aktivitas(){
        return $this->hasOne('App\PokAktivitas', 'id', 'id_aktivitas');
    }
}
