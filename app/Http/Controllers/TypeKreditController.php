<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TypeKreditRequest;

class TypeKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\TypeKredit::where('uraian', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('type_kredit');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('type_kredit.list', array('datas' => $datas))->render());
        }

        return view('type_kredit.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\TypeKredit;
        return view('type_kredit.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeKreditRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('type_kredit/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\TypeKredit;
        $model->uraian=$request->get('uraian');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('type_kredit')->with('success', 'Information has been added');
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
        $model = \App\TypeKredit::find($id);
        return view('type_kredit.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeKreditRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('type_kredit/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\TypeKredit::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('type_kredit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\TypeKredit::find($id);
        $model->delete();
        return redirect('type_kredit')->with('success','Information has been  deleted');
    }
}
