<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IkiBukti extends Model
{
    //
    protected $table = 'iki_bukti';
    protected $guarded = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'nip_baru', 'nip');
    }
}
