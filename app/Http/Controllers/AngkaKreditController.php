<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AngkaKreditRequest;

class AngkaKreditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\AngkaKredit::where('butir_kegiatan', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('angka_kredit');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('angka_kredit.list', array('datas' => $datas))->render());
        }

        return view('angka_kredit.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item_jenis = \App\TypeKredit::all();
        return view('angka_kredit.create', 
            compact('item_jenis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AngkaKreditRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('angka_kredit/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\AngkaKredit;
        $model->uraian=$request->get('uraian');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('angka_kredit')->with('success', 'Information has been added');
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
        $model = \App\AngkaKredit::find($id);
        return view('angka_kredit.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AngkaKreditRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('angka_kredit/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\AngkaKredit::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('angka_kredit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\AngkaKredit::find($id);
        $model->delete();
        return redirect('angka_kredit')->with('success','Information has been  deleted');
    }
}
