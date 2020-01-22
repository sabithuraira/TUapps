<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingPeserta extends Model
{
    protected $table = 'meeting_peserta';

    public function attributes()
    {
        return (new \App\Http\Requests\MeetingRequest())->attributes();
    }
}
