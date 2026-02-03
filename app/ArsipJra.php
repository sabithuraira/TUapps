<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArsipJra extends Model
{
    protected $table = 'arsip_jra';

    protected $fillable = [
        'label_jra',
        'deskripsi_jra',
        'aktif_tahun',
        'inaktif_tahun',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user who created this record
     */
    public function createdBy()
    {
        return $this->belongsTo('App\UserModel', 'created_by', 'id');
    }

    /**
     * Get the user who last updated this record
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\UserModel', 'updated_by', 'id');
    }
}
