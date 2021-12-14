<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokAktivitas extends Model{
    protected $table = 'pok_aktivitas';
    
    public function program(){
        return $this->hasOne('App\PokProgram', 'id', 'id_program');
    }
}
