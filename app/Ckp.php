<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ckp extends Model
{
    protected $table = 'ckps';

    public function attributes()
    {
        return (new \App\Http\Requests\CkpRequest())->attributes();
    }
}
