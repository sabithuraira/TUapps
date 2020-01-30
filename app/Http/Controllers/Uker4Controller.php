<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Uker4Request;

class Uker4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\UnitKerja4::where('nama', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('uker4');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('uker4.list', array('datas' => $datas))->render());
        }

        return view('uker4.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\UnitKerja4;
        return view('uker4.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Uker4Request $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('uker4/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\UnitKerja4;
        $model->is_kabupaten=$request->get('is_kabupaten');
        $model->nama=$request->get('nama');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('uker4')->with('success', 'Information has been added');
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
        $model = \App\UnitKerja4::find($id);
        return view('uker4.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Uker4Request $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('uker4/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\UnitKerja4::find($id);
        $model->is_kabupaten=$request->get('is_kabupaten');
        $model->nama=$request->get('nama');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('uker4');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\UnitKerja4::find($id);
        $model->delete();
        return redirect('uker4')->with('success','Information has been  deleted');
    }
}
