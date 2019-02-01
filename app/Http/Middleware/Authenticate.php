<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class Authenticate extends Middleware
{
    use AuthenticatesUsers;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        $is_cookie = true;
        // if (!Auth::check()) {
        
        $c_cookie = '';
        if(isset($_COOKIE['CommunityBPS'])) {
            $c_cookie = $_COOKIE["CommunityBPS"];
        }

        if(strlen($c_cookie)==0){
            $is_cookie = false;
            // print_r("c cookie len 0");die();
        }
        else{
            //340055914
            $c_nip = substr($c_cookie, 0 ,9);

            //This method use BPS SIMPEG API for Authentication
            //user your own API for this one
            $service_url    = 'insert your API URL';
            $curl           = curl_init($service_url);
            $curl_post_data = array(
                "apiKey" => 'insert your API key here',
                "kategori"=> 'view_pegawai',
                "nip" => $c_nip,
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = json_decode(curl_exec($curl));
            // print_r($curl_response);die();

            if(!isset($curl_response->error)){
                if($curl_response->total==0){
                    $is_cookie = false;
                    
                    // print_r("response total 0");die();
                }
                else{
                    $model= \App\User::where('email','=', $c_nip)->first();
                    $c_model = $curl_response->pegawai[0];
    
                    if($model==null){
                        $model = new \App\User;
                        $model->email = $c_model->niplama;
                        $model->nip_baru = $c_model->nipbaru;
                        $model->name = $c_model->namagelar;
                        $model->password = Hash::make($c_model->niplama);
                    }
                    
                    $model->urutreog = $c_model->urutreog;
                    $model->kdorg = $c_model->kdorg;
                    $model->nmorg = $c_model->nmorg;
                    $model->nmjab = $c_model->nmjab;
                    $model->flagwil = $c_model->flagwil;
                    $model->kdprop = $c_model->kdprop;
                    $model->kdkab = $c_model->kdkab;
                    $model->kdkec = $c_model->kdkec;
                    $model->nmwil = $c_model->nmwil;
                    $model->kdgol = $c_model->kdgol;
                    $model->nmgol = $c_model->nmgol;
                    $model->kdstjab = $c_model->kdstjab;
                    $model->nmstjab = $c_model->nmstjab;
                    $model->kdesl = $c_model->kdesl;
                    $model->save();
    
                    $data_request = array(
                        $this->username()=>$model->email,
                        'password'  =>$model->email
                    );
                    
                    if ($this->attemptLogin($data_request)) {
                        //set this with what path you want
                        return route('uker');
                    }
                }
            }
            else{
                $is_cookie = false;
            }
            
            curl_close($curl);
        }
        
        if(!$is_cookie){
            
            // print_r("! cookie");die();
            if (! $request->expectsJson()) {
                return route('guest');
            }
        }
        // }
    }

    protected function attemptLogin($params)
    {
        return $this->guard()->attempt(
            $params, true
        );
    }

    // protected function credentials(Request $request)
    // {
    //     return $request->only($this->username(), 'password');
    // }

    // public function handle($request, Closure $next, $guard = null)
    // {
    //     if (Auth::check()) {
    //         if (! $request->expectsJson()) {
    //             return route('guest');
    //         }
    //     }

    //     return $next($request);
    // }
}
