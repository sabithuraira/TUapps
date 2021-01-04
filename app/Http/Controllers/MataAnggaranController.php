<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MataAnggaranRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MataAnggaranPartialImport;

class MataAnggaranController extends Controller
{
    public function upload_some(){
        $model = new \App\MataAnggaran();
        return view('mata_anggaran.upload_some',compact('model'));
    }

    public function import_some(Request $request){
        Excel::import(new MataAnggaranPartialImport(), $request->file('excel_file'));
        return redirect('mata_anggaran/import_some')->with('success', 'Information has been added');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop.Auth::user()->kdkab)
            ->paginate();

        $datas->withPath('mata_anggaran');
        $datas->appends($request->all());

        return view('mata_anggaran.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\MataAnggaran;
        return view('mata_anggaran.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MataAnggaranRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('mata_anggaran/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\MataAnggaran;
        $model->kode=$request->get('kode');
        $model->nama=$request->get('nama');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('mata_anggaran')->with('success', 'Information has been added');
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
        $model = \App\MataAnggaran::find($id);
        return view('mata_anggaran.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MataAnggaranRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('mata_anggaran/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\MataAnggaran::find($id);
        $model->kode=$request->get('kode');
        $model->nama=$request->get('nama');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('mata_anggaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\MataAnggaran::find($id);
        $model->delete();
        return redirect('mata_anggaran')->with('success','Information has been  deleted');
    }
}
