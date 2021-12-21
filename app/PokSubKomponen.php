<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokSubKomponen extends Model{
    protected $table = 'pok_sub_komponen';
    
    public function program(){
        return $this->hasOne('App\PokProgram', 'id', 'id_program');
    }
    
    public function aktivitas(){
        return $this->hasOne('App\PokAktivitas', 'id', 'id_aktivitas');
    }
    
    public function kro(){
        return $this->hasOne('App\PokKro', 'id', 'id_kro');
    }
    
    public function ro(){
        return $this->hasOne('App\PokRo', 'id', 'id_ro');
    }
    
    public function komponen(){
        return $this->hasOne('App\PokKomponen', 'id', 'id_komponen');
    }
}
