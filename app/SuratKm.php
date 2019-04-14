<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratKm extends Model
{
    protected $table = 'surat_km';
    
    public function attributes()
    {
        return (new \App\Http\Requests\SuratKmRequest())->attributes();
    }
}
