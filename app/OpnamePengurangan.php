<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpnamePengurangan extends Model
{
    protected $table = 'opname_pengurangan';

    public function attributes()
    {
        return (new \App\Http\Requests\OpnamePenguranganRequest())->attributes();
    }
}
