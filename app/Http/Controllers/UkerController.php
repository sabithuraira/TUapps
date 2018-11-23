<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UkerRequest;

class UkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = \App\UnitKerja::all();
        return view('uker.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('uker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UkerRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('uker/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\UnitKerja;
        $model->kode=$request->get('kode');
        $model->nama=$request->get('nama');
        $model->created_by=1;
        $model->updated_by=1;
        $model->save();
        
        return redirect('uker')->with('success', 'Information has been added');
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
    public function edit($id)
    {
        $model = \App\UnitKerja::find($id);
        return view('uker.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model= \App\UnitKerja::find($id);
        $model->kode=$request->get('kode');
        $model->nama=$request->get('nama');
        $model->created_by=1;
        $model->updated_by=1;
        $model->save();
        return redirect('uker');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\UnitKerja::find($id);
        $model->delete();
        return redirect('uker')->with('success','Information has been  deleted');
    }
}
