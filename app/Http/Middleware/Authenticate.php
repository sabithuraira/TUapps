<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
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
        $c_cookie = $_COOKIE["CommunityBPS"];
        
        if(strlen($c_cookie)==0){
            $is_cookie = false;
        }
        else{
            //340055914
            $c_nip = substr($c_cookie, 0 ,9);

            $service_url    = 'http://pbd.bps.go.id/simpeg_api/bps16';
            $curl           = curl_init($service_url);
            $curl_post_data = array(
                "apiKey" => '4vl8i/WeNeRlRxM4KDk93VqdT0/LZ9g+GBITo+OiHVs=',
                "kategori"=> 'view_pegawai',
                "nip" => $c_nip,
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = curl_exec($curl);
            // print_r($curl_response);
            if($curl_response->total==0){
                $is_cookie = false;
            }
            else{
                $model= \App\User::find($id);
                if($model==null){
                    $c_model = $curl_response->pegawai[0];
                    $model = new \App\User;
                    $model->name = $c_model->niplama;
                    $model->name = $c_model->nipbaru;
                    $model->name = $c_model->namagelar;
                }

                $model->kode=$request->get('kode');
                $model->nama=$request->get('nama');
                $model->updated_by=Auth::id();
                $model->save();
            }


            curl_close($curl);
        }
        
        if(!$is_cookie){
            if (! $request->expectsJson()) {
                return route('guest');
            }
        }
        else{

        }
        // }
    }

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
