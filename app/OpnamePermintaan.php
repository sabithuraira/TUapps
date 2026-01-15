<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpnamePermintaan extends Model
{
    protected $table = 'opname_permintaan';

    protected $fillable = [
        'id_barang',
        'tanggal_permintaan',
        'tanggal_penyerahan',
        'jumlah_diminta',
        'jumlah_disetujui',
        'unit_kerja',
        'unit_kerja4',
        'status_aktif'
    ];

    public function getListStatusAktifAttribute()
    {
        return array(
            1 => "Diajukan",
            2 => "Disetujui",
        );
    }

    public function getListLabelStatusAktifAttribute()
    {
        return array(
            1 => "Diajukan",
            2 => "Disetujui",
        );
    }

    public function masterBarang()
    {
        return $this->belongsTo('App\MasterBarang', 'id_barang');
    }

    public function unitKerja()
    {
        return $this->belongsTo('App\UnitKerja', 'unit_kerja');
    }

    public function unitKerja4()
    {
        return $this->belongsTo('App\UnitKerja4', 'unit_kerja4');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\UserModel', 'created_by', 'id');
    }

    public function attributes()
    {
        return (new \App\Http\Requests\OpnamePermintaanRequest())->attributes();
    }
}

