<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiAndaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = '';

        $user = Auth::user();
        $user_id =  Auth::user()->email;
        $model = \App\User::where('email', '=', $user_id)->first();

        $datas = $model->getPegawaiAnda();
        // print_r($datas);die();
        // if(count($datas)>0){
            $datas->withPath('pegawai_anda');
            $datas->appends($request->all());
        // }

        return view('pegawai_anda.index',compact('datas', 'keyword'));
    }
}
