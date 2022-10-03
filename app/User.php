<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use App\Scopes\PegawaiScope;

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

    protected $appends = ['fotoUrl', 'pimpinan'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // protected static function boot(){
    //     parent::boot();
    //     static::addGlobalScope(new PegawaiScope);
    // }

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

    public function getPimpinanAttribute(){
        $bos = $this::find($this->pimpinan_id);
        if($bos==null) $bos = new UserModel;
        return $bos;
        // if($this->kdstjab<4){
        //     if($this->kdstjab==2 && $this->kdgol>32 && $this->kdgol<40){
        //         $bos = $this->getEselon3();

        //         if($bos!=null) return $bos;
        //         else{
        //             $bos = $this->getEselon2();

        //             if($bos!=null) return $bos;
        //             else return $this->getBosRI();
        //         }
        //     }
        //     else if($this->kdstjab==2 && $this->kdgol>40){
        //         $bos = $this->getEselon2();

        //         if($bos!=null) return $bos;
        //         else return $this->getBosRI();
        //     }
        //     else{
        //         $bos = $this::where([
        //             ['kdorg', '=', $this->kdorg],
        //             ['kdesl', '=', 4],
        //             ['kdprop', '=', $this->kdprop],
        //             ['kdkab', '=', $this->kdkab],
        //         ])->first();

        //         if($bos!=null) return $bos;
        //         else{
        //             $bos = $this->getEselon3();

        //             if($bos!=null) return $bos;
        //             else{
        //                 $bos = $this->getEselon2();

        //                 if($bos!=null) return $bos;
        //                 else return $this->getBosRI();
        //             }
        //         }
        //     }
        // }
        // else{
        //     if($this->kdesl==4){
        //         $bos = $this->getEselon3();

        //         if($bos!=null) return $bos;
        //         else{
        //             $bos = $this->getEselon2();

        //             if($bos!=null) return $bos;
        //             else return $this->getBosRI();
        //         }
        //     }
        //     else if($this->kdesl==3){
        //         $bos = $this->getEselon2();

        //         if($bos!=null) return $bos;
        //         else return $this->getBosRI();
        //     }
        //     else if($this->kdesl==2){
        //         return $this->getBosRI();
        //     }
        // }
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
            // ['kdkab', '=', $this->kdkab],
        ])->first();

        return $bos;
    }

    function getBosRI(){
        $bos = new User;
        $bos->name = 'Dr. Suhariyanto';
        $bos->nip_baru = '196106151983121001';
        $bos->nmjab = 'Kepala Badan Pusat Statistik';

        return $bos;
    }

    function getPegawaiAnda($keyword){
        $pegawai = array();

        $arr_where = [];
        $arr_where[] = ['kdprop', '=', $this->kdprop];
        $arr_where[] = ['id', '<>', $this->id];

        if(strlen($keyword)>0){
            $arr_where[] = ['name', 'LIKE', '%' . $keyword . '%'];
        }

        // if($this->kdstjab==4){
            // if($this->kdesl==4){

            //     $arr_where[] = ['kdorg', '=', $this->kdorg];
            //     $arr_where[] = ['kdstjab', '<>', 4];
            //     $arr_where[] = ['kdkab', '=',  $this->kdkab];

            //     $or_where[] = ['kdorg', '=', 92870];
            //     $or_where[] = ['kdstjab', '<>', 4];
            //     $or_where[] = ['kdkab', '=',  $this->kdkab];

            //     $pegawai = $this::where($arr_where)
            //         ->orWhere(
            //             (function ($query) use ($or_where) {
            //                 $query->where($or_where);
            //             })
            //         )->paginate();
            // }
            if($this->kdesl==3){
                if($this->kdkab=='00'){
                    $or_where1 = [];
                    $or_where2 = [];

                    $or_where1[] = [\DB::raw('substr(kdorg, 1, 3)'), '=', substr($this->kdorg,0,3)];
                    $or_where1[] = ['kdkab', '=',  $this->kdkab];

                    $or_where2[] = ['kdkab', '<>', '00'];
                    $or_where2[] = ['kdesl', '=', '3'];

                    $pegawai = $this::where($arr_where)
                        ->where(
                            (function ($query) use ($or_where1, $or_where2) {
                                $query->where($or_where1)
                                    ->orWhere($or_where2);
                            })
                        )
                        ->orderBy('kdorg')
                        ->paginate();
                }
                else{
                    $arr_where[] = [\DB::raw('substr(kdorg, 1, 3)'), '=', substr($this->kdorg,0,3)];
                    $arr_where[] = ['kdkab', '=',  $this->kdkab];
                    $pegawai = $this::where($arr_where)->paginate();
                }
            }
            else if($this->kdesl==2){
                $arr_where[] = [\DB::raw('substr(kdorg, 1, 2)'), '=', substr($this->kdorg,0,2)];
                $pegawai = $this::where($arr_where)->orderBy('kdorg')->paginate();
            }
            else{
                $pegawai = $this::where([
                    ['pimpinan_id', '=', $this->id],
                ])->orderBy('kdorg')->paginate();
            }
        // }
        // else{
        //     $pegawai = $this::where([
        //         ['kdstjab', '=', '999'],
        //     ])->paginate();
        // }

        if(Auth::user()->hasRole('superadmin')){
            $arr_where = [];
            $arr_where[] = ['kdprop', '=', $this->kdprop];
            // $arr_where[] = ['id', '<>', $this->id];

            if(strlen($keyword)>0){
                $arr_where[] = ['name', 'LIKE', '%' . $keyword . '%'];
            }

            // $arr_where[] = [\DB::raw('substr(kdorg, 1, 2)'), '=', substr($this->kdorg,0,2)];
            $pegawai = $this::where($arr_where)
                            ->orderBy('kdorg')->paginate();
        }

        return $pegawai;
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
        if($result !== FALSE) return true;
        else return false;
        // $headers=get_headers($url);
        // return stripos($headers[0],"200 OK")?true:false;
    }
}
