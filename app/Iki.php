<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Iki extends Model
{
    protected $table = 'iki';

    public function User()
    {
        return $this->hasOne('App\User', 'email', 'user_id');
    }
    
    public function attributes()
    {
        return (new \App\Http\Requests\IkiRequest())->attributes();
    }
}
