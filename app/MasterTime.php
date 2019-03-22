<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterTime extends Model
{
    protected $table = 'master_times';
    
    public function attributes()
    {
        return [
            'waktu' => 'Waktu',
        ];
    }
}
