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
            'II/c' => 'Pengatur' , 
            'II/d' => 'Pengatur Tingkat I' , 
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

    public function getJumlahDl(){
        $nip = $this->nip_baru;
        $sql = "";
    }

    public function getFotoUrlAttribute(){
        $nip_id = substr($this->email, -5);
        if(strlen($this->foto)>0){
            if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$this->foto)){
                return "https://community.bps.go.id/images/avatar/".$this->foto; 
            }
            else if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$nip_id.".JPG")){
                return "https://community.bps.go.id/images/avatar/".$nip_id.".JPG";
            }
            else{
                return "https://community.bps.go.id/images/avatar/".$nip_id.".jpg";    
            }
        }
        else{
            // $nip_id = '10080'; //10080 55914
            if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$nip_id.".JPG")){
                return "https://community.bps.go.id/images/avatar/".$nip_id.".JPG";
            }
            else{
                return "https://community.bps.go.id/images/avatar/".$nip_id.".jpg";    
            }
        }
    }

    function is_foto_exist($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($ch);
        curl_close($ch);
        if($result !== FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
        // $headers=get_headers($url);
        // return stripos($headers[0],"200 OK")?true:false;
    }
}
