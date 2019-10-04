<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterBarang extends Model
{
    protected $table = 'master_barangs';

    public function attributes()
    {
        return (new \App\Http\Requests\MasterBarangRequest())->attributes();
    }
}
