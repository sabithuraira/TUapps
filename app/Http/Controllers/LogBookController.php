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
        $all_dates = array();
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        
        $user = Auth::user();
        $user_id =  Auth::user()->email;

        if(strlen($request->get('start'))>0)
            $start =  date("Y-m-d", strtotime($request->get('start')));

        if(strlen($request->get('end'))>0)
            $end =  date("Y-m-d", strtotime($request->get('end')));

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');

        $model = new \App\LogBook;
        $datas = $model->LogBookRekap($start, $end, $user_id);

        return response()->json(['success'=>'Sukses', 
            'datas'=>$datas,
        ]);
    }

    public function dataKomentar(Request $request){
        $id = 0;

        if(strlen($request->get('id'))>0)
            $id = $request->get('id');

        $data = \App\LogBook::find($id);
        $result = "";

        if($data!=null) $result = $data->catatan_approve;

        return response()->json(['success'=>'Sukses', 'result'=>$result]);
    }

    public function saveKomentar(Request $request)
    {
        // print_r($request->get('id'));die();
        $data = \App\LogBook::find($request->get('id'));
        if($data!=null){
            $data->catatan_approve=$request->get('catatan_approve');
            $data->pimpinan_by = Auth::user()->email;
            $data->save();
        }
        
        return response()->json(['success'=>'Sukses']);
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
        $item_waktu = \App\MasterTime::all();

        return view('log_book.create', compact('model', 'item_waktu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model= new \App\LogBook;
        $model->user_id= Auth::user()->email;
        $model->tanggal=date("Y-m-d", strtotime($request->get('tanggal')));
        $model->waktu_mulai = date("h:i", strtotime($request->get('waktu_mulai')));
        $model->waktu_selesai = date("h:i", strtotime($request->get('waktu_selesai')));
        $model->isi = $request->get('isi');
        $model->hasil = $request->get('hasil');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return response()->json(['success'=>'Data berhasil ditambah']);
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
        $item_waktu = \App\MasterTime::all();

        return view('log_book.edit',compact('model','id', 'item_waktu'));
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
        $model->isi = $request->get('isi');
        
        // if($request->get('flag_ckp')!=''){
            $model->flag_ckp =  $request->get('flag_ckp');
        // }
        
        $model->waktu=$request->get('waktu');
        $model->updated_by=Auth::id();
        $model->save();

        return redirect('/log_book')->with('success', 'Information has been updated');
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
