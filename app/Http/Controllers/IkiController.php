<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IkiRequest;

class IkiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\Iki::where('iki_label', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('iki');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('iki.list', array(
                'datas' => $datas, 
                'keyword' => $keyword))->render());
        }

        return view('iki.index',compact('datas', 'keyword'));
    }


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
