<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models=\App\UnitKerja::all();
        return view('index',compact('UnitKerjas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $models= new \App\UnitKerja;
        $models->kode=$request->get('kode');
        $models->nama=$request->get('nama');
        $models->created_by=1;
        $models->updated_by=1;
        $models->save();
        
        return redirect('UnitKerjas')->with('success', 'Information has been added');
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
        return view('edit',compact('UnitKerja','id'));
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
        $model->name=$request->get('name');
        $model->email=$request->get('email');
        $model->number=$request->get('number');
        $model->office=$request->get('office');
        $model->save();
        return redirect('UnitKerjas');
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
        return redirect('UnitKerjas')->with('success','Information has been  deleted');
    }
}
