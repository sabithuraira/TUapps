<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RincianKredit extends Model
{
    protected $table = 'rincian_kredits';

    public function Jenis()
    {
        return $this->hasOne('App\TypeKredit', 'id', 'jenis');
    }
}
