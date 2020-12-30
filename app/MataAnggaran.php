<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataAnggaran extends Model
{
    protected $table = 'mata_anggaran';

    
    public function attributes()
    {
        return (new \App\Http\Requests\MataAnggaranRequest())->attributes();
    }
}
