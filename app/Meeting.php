<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Meeting extends Model
{
    protected $table = 'meeting';
    
    protected $appends = ['totalPeserta'];

    public function attributes()
    {
        return (new \App\Http\Requests\MeetingRequest())->attributes();
    }

    public function getTotalPesertaAttribute(){
        return \App\MeetingPeserta::where('meeting_id', '=', $this->id)->count();
    }

    public function getIsPesertaAttribute(){
        $total = \App\MeetingPeserta::where('meeting_id', '=', $this->id)
            ->where('pegawai_id','=', Auth::user()->email)->count();
        
        if($total==0) {
            return false;
        }    
        return true;
    }
}
