<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataAnggaran extends Model
{
    protected $table = 'mata_anggaran';

    
    public function attributes()
    {
        return (new \App\Http\Requests\MataAnggaranRequest())->attributes();
    }

    public function getKodeMakAttribute()
    {
        return $this->kode_program.'.'.$this->kode_ro.'.'.$this->kode_komponen.'.'.$this->kode_subkomponen;
	}
}
