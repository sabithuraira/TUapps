<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemegangBmn extends Model
{
    protected $table = 'pemegang_bmn';

    public function attributes()
    {
        return (new \App\Http\Requests\PemegangBmnRequest())->attributes();
    }
}
