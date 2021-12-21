<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokMataAnggaran extends Model{
    protected $table = 'pok_mata_anggaran';

    public function attributes()
    {
        return [
            'id_program' => 'Program',
            'id_aktivitas' => 'Aktivitas',
            'id_kro' => 'KRO',
            'id_ro' => 'RO',
            'id_komponen' => 'Komponen',
            'id_sub_komponen' => 'Sub Komponen',
        ];
    }
    
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
    
    public function sub_komponen(){
        return $this->hasOne('App\PokKomponen', 'id', 'id_sub_komponen');
    }
}
