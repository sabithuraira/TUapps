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

    public function getPimpinanAttribute(){
        if($this->kdstjab<4){
            if($this->kdstjab==2 && $this->kdgol>32){
                $bos = $this->getEselon3();
    
                if($bos!=null) return $bos;
                else{
                    $bos = $this->getEselon2();
                    
                    if($bos!=null) return $bos;
                    else return $this->getBosRI();
                }
            }
            else{
                $bos = $this::where([
                    ['kdorg', '=', $this->kdorg],
                    ['kdesl', '=', 4], 
                    ['kdprop', '=', $this->kdprop], 
                    ['kdkab', '=', $this->kdkab], 
                ])->first();
    
                if($bos!=null) return $bos;
                else{
                    $bos = $this->getEselon3();
    
                    if($bos!=null) return $bos;
                    else{
                        $bos = $this->getEselon2();
                        
                        if($bos!=null) return $bos;
                        else return $this->getBosRI();
                    }
                }
            }
        }
        else{
            if($this->kdesl==4){
                $bos = $this->getEselon3();

                if($bos!=null) return $bos;
                else{
                    $bos = $this->getEselon2();
                    
                    if($bos!=null) return $bos;
                    else return $this->getBosRI();
                }
            }
            else if($this->kdesl==3){
                $bos = $this->getEselon2();
                
                if($bos!=null) return $bos;
                else return $this->getBosRI();
            }
        }
    }

    function getEselon3(){
        $kdorg = substr($this->kdorg, 0,3).'00';
        $bos = $this::where([
            ['kdorg', '=', $kdorg],
            ['kdesl', '=', 3], 
            ['kdprop', '=', $this->kdprop], 
            ['kdkab', '=', $this->kdkab], 
        ])->first();

        return $bos;
    }

    function getEselon2(){
        $kdorg = substr($this->kdorg, 0,2).'000';
        $bos = $this::where([
            ['kdorg', '=', $kdorg],
            ['kdesl', '=', 2], 
            ['kdprop', '=', $this->kdprop], 
            ['kdkab', '=', $this->kdkab], 
        ])->first();

        return $bos;
    }

    function getBosRI(){
        $bos = new User;
        $bos->name = 'Dr. Suhariyanto';
        $bos->nip_baru = '196106151983121001';

        return $bos;
    }


    

    function is_foto_exist($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        //for https setting
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
    }
}
