<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeKredit extends Model
{
    protected $table = 'type_kredits';
    
    public function attributes()
    {
        return [
            'uraian' => 'Uraian',
        ];
    }
}
