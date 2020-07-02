<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IkiRequest;
use Illuminate\Support\Facades\Crypt;

class IkiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');

        $datas = \App\Iki::where('iki_label', 'LIKE', '%' . $keyword . '%')
            ->where('user_id', '=', Auth::user()->email)
            ->paginate();

        // if(Auth::user()->hasRole('superadmin')){
        //     $datas = \App\Iki::where('iki_label', 'LIKE', '%' . $keyword . '%')
        //         ->paginate();
        // }

        $datas->withPath('iki');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('iki.list', array(
                'datas' => $datas, 
                'keyword' => $keyword))->render());
        }

        return view('iki.index',compact('datas', 'keyword'));
    }

    public function create()
    {
        $model= new \App\Iki;
        return view('iki.create', 
            compact('model'));
    }
    
    public function store_master(IkiRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('iki/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= new \App\Iki;
        $model->user_id =Auth::user()->email;
        $model->iki_label =$request->get('iki_label');
        $model->save();
        
        return redirect('iki')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $real_id = Crypt::decrypt($id);
        $model = \App\Iki::find($real_id);
        return view('iki.edit',compact('model','id', 'real_id'));
    }

    public function update(IkiRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('iki/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $real_id = Crypt::decrypt($id);
        $model= \App\Iki::find($real_id);
        $model->iki_label =$request->get('iki_label');
        $model->save();
        return redirect('iki');
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
