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


    public function syncRealisasi($id){
        $model = \App\SiraAkun::find($id);

        $total = \App\SiraAkunRealisasi::where('kode_mak', $model->kode_mak)
                                        ->where('kode_akun', $model->kode_akun)->sum('realisasi');

        $model->realisasi = $total;
        $model->save();
    }
}
