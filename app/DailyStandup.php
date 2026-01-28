<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyStandup extends Model
{
    protected $table = 'daily_standup';

    protected $fillable = [
        'pegawai_nip',
        'tim_id',
        'tanggal',
        'isi',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the tim master that owns this daily standup
     */
    public function timMaster()
    {
        return $this->belongsTo('App\TimMaster', 'tim_id', 'id');
    }

    /**
     * Get the user who created this daily standup
     */
    public function createdBy()
    {
        return $this->belongsTo('App\UserModel', 'created_by', 'id');
    }

    /**
     * Get the user who last updated this daily standup
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\UserModel', 'updated_by', 'id');
    }
}
