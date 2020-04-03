<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table = 'meeting';

    public function attributes()
    {
        return (new \App\Http\Requests\MeetingRequest())->attributes();
    }

    public function getTotalPesertaAttribute(){
        return \App\MeetingPeserta::where('meeting_id', '=', $this->id)->count();
    }
}
