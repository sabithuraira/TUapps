<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RincianKreditRequest;

class RincianKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\RincianKredit::where('uraian', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('rincian_kredit');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('rincian_kredit.list', array('datas' => $datas))->render());
        }

        return view('rincian_kredit.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\RincianKredit;
        return view('rincian_kredit.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RincianKreditRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('rincian_kredit/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\RincianKredit;
        $model->uraian=$request->get('uraian');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('rincian_kredit')->with('success', 'Information has been added');
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
        $model = \App\RincianKredit::find($id);
        return view('rincian_kredit.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RincianKreditRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('rincian_kredit/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\RincianKredit::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('rincian_kredit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\RincianKredit::find($id);
        $model->delete();
        return redirect('rincian_kredit')->with('success','Information has been  deleted');
    }
}
