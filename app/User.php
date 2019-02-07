<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getFotoUrlAttribute(){
        $nip_id = substr($this->email, -5);
        if($this->is_foto_exist("https://community.bps.go.id/images/avatar/".$nip_id.".JPG")){
            return "https://community.bps.go.id/images/avatar/".$nip_id.".JPG";
        }
        else{
            return "https://community.bps.go.id/images/avatar/".$nip_id.".jpg";    
        }
    }

    function is_foto_exist($url){
        $ch = curl_init($url);    
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if($code == 200){
           $status = true;
        }else{
          $status = false;
        }
        curl_close($ch);
       return $status;
    }
}
