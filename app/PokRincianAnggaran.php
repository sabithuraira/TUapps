<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokRincianAnggaran extends Model{
    protected $table = 'pok_rincian_anggaran';
    
    public function attributes()
    {
        return [
            'id_mata_anggaran' => 'Mata Anggaran',
            'label' => 'Label',
            'tahun' => 'Tahun',
            'volume' => 'Volume',
            'satuan' => 'Satuan',
            'harga_satuan' => 'Harga Satuan',
            'harga_jumlah' => 'Harga Jumlah',
        ];
    }
    
    public function mata_anggaran(){
        return $this->hasOne('App\PokMataAnggaran', 'id', 'id_mata_anggaran');
    }
}
