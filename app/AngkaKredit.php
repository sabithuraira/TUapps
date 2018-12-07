<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AngkaKredit extends Model
{
    protected $table = 'angka_kredits';
    
    public function Jenis()
    {
        return $this->hasOne('App\TypeKredit', 'id', 'jenis');
    }
}
