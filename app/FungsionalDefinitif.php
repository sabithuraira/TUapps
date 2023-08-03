<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FungsionalDefinitif extends Model
{
    //
    protected $table = "jafung_definitif";

    public function User($kd_wilayah)
    {

        // $kd_wilayah = $this->kd_wilayah;
        // dd();
        return $this->hasMany('App\User', 'nmjab', 'nama_jabatan')->where('kdkab', 'LIKE', '%' . substr($kd_wilayah, 2, 2) . '%')->get();
    }
}
