<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MasterBarangRequest;

class MasterBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\MasterBarang::where('nama_barang', 'LIKE', '%' . $keyword . '%')
            ->where('unit_kerja', '=', Auth::user()->kdprop.Auth::user()->kdkab)
            ->paginate();

        $datas->withPath('master_barang');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('master_barang.list', array('datas' => $datas))->render());
        }

        return view('master_barang.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\MasterBarang;
        return view('master_barang.create', 
            compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterBarangRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('master_barang/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        // dd($request->get('harga_satuan'));
        
        $model= new \App\MasterBarang;
        $model->nama_barang=$request->get('nama_barang');
        $model->unit_kerja= Auth::user()->kdprop.Auth::user()->kdkab;
        $model->satuan=$request->get('satuan');
        $model->harga_satuan=$request->get('harga_satuan');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('master_barang')->with('success', 'Data berhasil ditambahkan');
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
        $model = \App\MasterBarang::find($id);
        return view('master_barang.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterBarangRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('master_barang/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\MasterBarang::find($id);

        $model->nama_barang=$request->get('nama_barang');
        $model->unit_kerja= Auth::user()->kdprop.Auth::user()->kdkab;
        $model->satuan=$request->get('satuan');
        $model->harga_satuan=$request->get('harga_satuan');

        $model->updated_by=Auth::id();
        $model->save();
        return redirect('master_barang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\MasterBarang::find($id);
        $model->delete();
        return redirect('master_barang')->with('success','Data berhasil dihapus');
    }
}
