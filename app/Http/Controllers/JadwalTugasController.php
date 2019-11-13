<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\JadwalTugasRequest;

class JadwalTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $keyword = $request->get('search');
        // $datas = \App\JadwalTugas::where('nama_kegiatan', 'LIKE', '%' . $keyword . '%')
        //     ->paginate();

        // $datas->withPath('jadwal_tugas');
        // $datas->appends($request->all());

        // if ($request->ajax()) {
        //     return \Response::json(\View::make('jadwal_tugas.list', array('datas' => $datas))->render());
        // }

        // return view('jadwal_tugas.index',compact('datas', 'keyword'));
        $month = date('m');
        $year = date('Y');

        return view('jadwal_tugas.index',compact('month', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\JadwalTugas;
        $item_jenis = \App\TypeKredit::all();
        return view('jadwal_tugas.create', 
            compact('item_jenis', 'model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JadwalTugasRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('jadwal_tugas/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\JadwalTugas;
        $model->uraian=$request->get('uraian');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('jadwal_tugas')->with('success', 'Information has been added');
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
        $model = \App\JadwalTugas::find($id);
        return view('jadwal_tugas.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JadwalTugasRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('jadwal_tugas/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\JadwalTugas::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('jadwal_tugas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\JadwalTugas::find($id);
        $model->delete();
        return redirect('jadwal_tugas')->with('success','Information has been  deleted');
    }
}
