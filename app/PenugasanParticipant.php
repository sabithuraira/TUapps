<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenugasanParticipant extends Model
{
    protected $table = 'penugasan_participant';

    public function PenugasanIndukRel()
    {
        return $this->hasOne('App\Penugasan', 'id', 'penugasan_id');
    }
}
