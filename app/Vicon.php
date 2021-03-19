<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vicon extends Model
{
    protected $table='vicon';

     public function attributes()
    {
        return (new \App\Http\Requests\ViconRequest())->attributes();
    }

     public function getListStatusAttribute()
    {
        return array(
            1 => 'Booked', 
            2 => 'Sedang Berlangsung',
            3=> 'Selesai', 
            
        );
    }
}
