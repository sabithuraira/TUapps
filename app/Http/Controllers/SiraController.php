<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiraRincianRequest;
use App\Http\Requests\SiraAkunRequest;

class SiraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');
        $datas = \App\SiraAkun::where('mak', 'LIKE', '%' . $keyword . '%')
            ->orWhere('akun', 'LIKE', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('sira');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('sira.list', array('datas' => $datas, 'keyword'=>$keyword))->render());
        }

        return view('sira.index',compact('datas', 'keyword'));
    }


    public function create_akun(){
        $model= new \App\SiraAkun;
        return view('sira.create_akun',compact('model'));
    }

    public function store_akun(SiraAkunRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\SiraAkun;
        $model->kode_mak=$request->get('kode_mak');
        $model->mak=$request->get('mak');
        $model->kode_akun=$request->get('kode_akun');
        $model->akun=$request->get('akun');
        $model->tahun=$request->get('tahun');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('sira')->with('success', 'Information has been added');
    }


    public function import_akun(){
        $model= new \App\SiraAkun;
        return view('sira.import_akun',compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model= new \App\SiraRincian;
        $akun = \App\SiraAkun::all();
        return view('sira.create',compact('model', 'akun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiraRincianRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\SiraRincian;
        $model->kode_mak=$request->get('kode_mak');
        $model->kode_akun=$request->get('kode_akun');
        $model->kode_fungsi=$request->get('kode_fungsi');

        $model->path_kak=$request->get('path_kak');
        $model->path_form_permintaan=$request->get('path_form_permintaan');
        $model->path_notdin=$request->get('path_notdin');
        $model->path_undangan=$request->get('path_undangan');
        $model->path_bukti_pembayaran=$request->get('path_bukti_pembayaran');
        $model->path_kuitansi=$request->get('path_kuitansi');
        $model->path_notulen=$request->get('path_notulen');
        $model->path_daftar_hadir=$request->get('path_daftar_hadir');
        $model->path_sk=$request->get('path_sk');
        $model->path_st=$request->get('path_st');

        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('sira')->with('success', 'Information has been added');
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
        $model = \App\PemegangBmn::find($id);
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('id', 'asc')
            ->get();
        return view('sira.edit',compact('model','id', 'list_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PemegangBmnRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/edit',$id)
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
        return redirect('sira');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\PemegangBmn::find($id);
        $model->delete();
        return redirect('sira')->with('success','Information has been  deleted');
    }
}
