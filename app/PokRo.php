<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokRo extends Model{
    protected $table = 'pok_ro';
    
    public function program(){
        return $this->hasOne('App\PokProgram', 'id', 'id_program');
    }
    
    public function aktivitas(){
        return $this->hasOne('App\PokAktivitas', 'id', 'id_aktivitas');
    }
    
    public function kro(){
        return $this->hasOne('App\PokKro', 'id', 'id_kro');
    }
}
