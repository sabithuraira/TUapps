<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpnamePenambahan extends Model
{
    protected $table = 'opname_penambahan';

    public function attributes()
    {
        return (new \App\Http\Requests\OpnamePenambahanRequest())->attributes();
    }
}
