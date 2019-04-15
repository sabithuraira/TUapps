<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratKmRequest;

class SuratKmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\SuratKm::where('nomor_urut', 'LIKE', '%' . $keyword . '%')
            ->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
            ->orWhere('perihal', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('surat_km');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('surat_km.list', array('datas' => $datas))->render());
        }

        return view('surat_km.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\SuratKm;
        $model->tanggal = date('Y-m-d');
        return view('surat_km.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratKmRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_km/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\SuratKm;
        $model->uraian=$request->get('uraian');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('surat_km')->with('success', 'Information has been added');
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
        $model = \App\SuratKm::find($id);
        return view('surat_km.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuratKmRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_km/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\SuratKm::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('surat_km');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\SuratKm::find($id);
        $model->delete();
        return redirect('surat_km')->with('success','Information has been  deleted');
    }
}
