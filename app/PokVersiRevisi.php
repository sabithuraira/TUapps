<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokVersiRevisi extends Model{
    protected $table = 'pok_versi_revisi';
    
    public function attributes(){
        return (new \App\Http\Requests\PokVersiRevisiRequest())->attributes();
    }
}
