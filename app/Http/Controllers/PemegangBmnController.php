<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PemegangBmnRequest;

class PemegangBmnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\PemegangBmn::where('nama', 'LIKE', '%' . $keyword . '%')
            ->orWhere('nama_barang', 'LIKE', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('pemegang_bmn');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('pemegang_bmn.list', array('datas' => $datas, 'keyword'=>$keyword))->render());
        }

        return view('pemegang_bmn.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\PemegangBmn;
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('id', 'asc')
            ->get();
        return view('pemegang_bmn.create',compact('model', 'list_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PemegangBmnRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('pemegang_bmn/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\PemegangBmn;
        $user_barang = \App\UserModel::find($request->get('id_pemegang'));
        $model->id_pemegang=$user_barang->id;
        $model->nip_baru=$user_barang->nip_baru;
        $model->nama=$user_barang->name;
        $model->nama_barang=$request->get('nama_barang');
        $model->serial_number=$request->get('serial_number');
        $model->deskripsi_barang=$request->get('deskripsi_barang');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('pemegang_bmn')->with('success', 'Information has been added');
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
        $model = \App\PemegangBmn::find($id);
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('id', 'asc')
            ->get();
        return view('pemegang_bmn.edit',compact('model','id', 'list_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PemegangBmnRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('pemegang_bmn/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\PemegangBmn::find($id);
        $user_barang = \App\UserModel::find($request->get('id_pemegang'));
        $model->id_pemegang=$user_barang->id;
        $model->nip_baru=$user_barang->nip_baru;
        $model->nama=$user_barang->name;
        $model->nama_barang=$request->get('nama_barang');
        $model->serial_number=$request->get('serial_number');
        $model->deskripsi_barang=$request->get('deskripsi_barang');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('pemegang_bmn');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\PemegangBmn::find($id);
        $model->delete();
        return redirect('pemegang_bmn')->with('success','Information has been  deleted');
    }
}
