<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LogBookRequest;

class LogBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dataLogBook(Request $request){
        $datas=array();
        $start = date('Y-m-d');
        $end = date('Y-m-d');

        if(strlen($request->get('start'))>0)
            $start =  date("Y-m-d", strtotime($request->get('start')));

        if(strlen($request->get('end'))>0)
            $end =  date("Y-m-d", strtotime($request->get('end')));

        $model = new \App\LogBook;
        $datas = $model->LogBookRekap($start, $end);

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas=array();

        $start = date('m/d/Y');
        $end = date('m/d/Y');

        $model = new \App\LogBook;

        return view('log_book.index', compact('model', 
            'datas', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new \App\LogBook;
        $model->tanggal = date('Y-m-d');

        return view('log_book.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogBookRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('log_book/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\LogBook;
        $model->tanggal= date("Y-m-d", strtotime($request->get('tanggal')));
        $model->isi=$request->get('isi');
        $model->is_approve=2;
        $model->catatan_approve='';
        $model->user_id = Auth::user()->email;
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('log_book')->with('success', 'Information has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = \App\LogBook::find($id);
        return view('log_book.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LogBookRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('log_book/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= \App\LogBook::find($id);
        $model->tanggal= date("Y-m-d", strtotime($request->get('tanggal')));
        $model->isi=$request->get('isi');
        $model->updated_by=Auth::id();
        $model->save();

        return redirect('log_book');
    }

    public function show($id)
    {
        $model = \App\LogBook::find($id);
        return view('log_book.show',compact('model','id'));
    }
    
    public function print($id)
    {
        $model = \App\LogBook::find($id);
        return view('log_book.print',compact('model','id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $model = \App\LogBook::find($id);
        $model->delete();
        return redirect('log_book')->with('success','Information has been  deleted');
    }
}
