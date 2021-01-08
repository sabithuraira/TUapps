<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';

    public function getListPangkatAttribute()
    {
        return array(
            'II/a' => 'Pengatur Muda', 
            'II/b' => 'Pengatur Muda Tingkat I', 
            'II/c' => 'Pegatur Tingkat I' , 
            'II/d' => 'Pengatur' , 
            'III/a' => 'Penata Muda',  
            'III/b' => 'Penata Muda Tingkat I',  
            'III/c' => 'Penata' , 
            'III/d' => 'Penata Tingkat I',  
            'IV/a' => 'Pembina',  
            'IV/b' => 'Pembina Tingkat I',  
            'IV/c' => 'Pembina Utama Muda',  
            'IV/d' => 'Pembina Utama Madya',
            'IV/e' => 'Pembina Utama'
        );
	}
}
