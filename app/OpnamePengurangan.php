<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpnamePengurangan extends Model
{
    protected $table = 'opname_pengurangan';

    protected $fillable = [
        'id_barang',
        'bulan',
        'tahun',
        'jumlah_kurang',
        'harga_kurang',
        'unit_kerja',
        'unit_kerja4',
        'tanggal',
        'created_by',
        'updated_by'
    ];

    public function attributes()
    {
        return (new \App\Http\Requests\OpnamePenguranganRequest())->attributes();
    }

    public function unitKerja(){
        return $this->belongsTo('App\UnitKerja4', 'unit_kerja4');
    }

    public function masterBarang()
    {
        return $this->belongsTo('App\MasterBarang', 'id_barang');
    }
}
