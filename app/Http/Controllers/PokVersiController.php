<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PokVersiRevisiRequest;

class PokVersiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');
        $datas = \App\PokVersiRevisi::where('versi', 'LIKE', '%' . $keyword . '%')
            ->orWhere('keterangan', 'LIKE', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('pok_versi');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('pok_versi.list', array('datas' => $datas, 'keyword'=>$keyword))->render());
        }

        return view('pok_versi.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model= new \App\PokVersiRevisi;
        return view('pok_versi.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PokVersiRevisiRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('pok_versi/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\PokVersiRevisi;
        $model->versi=$request->get('versi');
        $model->keterangan=$request->get('keterangan');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('pok_versi')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $model = \App\PokVersiRevisi::find($id);
        return view('pok_versi.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PokVersiRevisiRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('pok_versi/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\PokVersiRevisi::find($id);
        $model->versi=$request->get('versi');
        $model->keterangan=$request->get('keterangan');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('pok_versi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\PokVersiRevisi::find($id);
        $model->delete();
        return redirect('pok_versi')->with('success','Information has been  deleted');
    }
}
