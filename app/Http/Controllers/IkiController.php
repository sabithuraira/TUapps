<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IkiRequest;

class IkiController extends Controller
{
    public function store(Request $request)
    {
        $model = \App\Iki::find($request->get("id"));
        if($model==null){
            $model= new \App\Iki;
            $model->user_id= Auth::user()->email;
        }
        $model->iki_label=$request->get('iki_label');
        $model->save();
        
        return response()->json(['success'=>'Data berhasil ditambah']);
    }
}
