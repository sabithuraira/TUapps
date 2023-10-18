<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiraRincian extends Model
{
    protected $table = 'sira_rincian';

    public function attributes()
    {
        return (new \App\Http\Requests\SiraRincianRequest())->attributes();
    }
}
