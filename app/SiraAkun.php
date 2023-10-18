<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiraAkun extends Model
{
    protected $table = 'sira_akun';

    public function attributes()
    {
        return (new \App\Http\Requests\SiraAkunRequest())->attributes();
    }
}
