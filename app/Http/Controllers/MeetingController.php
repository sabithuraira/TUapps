<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MeetingRequest;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\Meeting::where('judul', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('meeting');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('meeting.list', array('datas' => $datas))->render());
        }

        return view('meeting.index',compact('datas', 'keyword'));
    }

    public function loadPegawai(Request $request){
        $keyword = '';

        if(strlen($request->get('keyword'))>0)
            $keyword = $request->get('keyword');

        $model = \App\User::all();
        if(strlen($keyword)>0){
            $model = \App\User::where('name', 'LIKE', '%' . $keyword . '%')->get();
        }
        
        return response()->json(['success'=>'1', 'datas'=>$model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\Meeting;
        return view('meeting.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('meeting/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\Meeting;
        $model->judul =$request->get('judul');
        $model->deskripsi =$request->get('deskripsi');
        $model->notulen =$request->get('notulen');
        $model->keterangan =$request->get('keterangan');
        $model->waktu_mulai =$request->get('waktu_mulai');
        $model->waktu_selesai =$request->get('waktu_selesai');

        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('meeting')->with('success', 'Information has been added');
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
        $model = \App\Meeting::find($id);
        return view('meeting.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('meeting/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\Meeting::find($id);
        $model->judul =$request->get('judul');
        $model->deskripsi =$request->get('deskripsi');
        $model->notulen =$request->get('notulen');
        $model->keterangan =$request->get('keterangan');
        $model->waktu_mulai =$request->get('waktu_mulai');
        $model->waktu_selesai =$request->get('waktu_selesai');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('meeting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\Meeting::find($id);
        $model->delete();
        return redirect('meeting')->with('success','Information has been  deleted');
    }
}