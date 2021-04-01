<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ViconRequest;
use \DateTime;



class ViconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\Vicon::where('keperluan', 'LIKE', '%' . $keyword . '%')
                ->orWhere('ketua', 'LIKE', '%' . $keyword . '%')
                ->orderBy('tanggal', 'asc')
                ->orderBy('jamawalguna', 'asc')
                ->paginate();


        $datas->withPath('vicon');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('vicon.list', array(
                'datas' => $datas, 
                'keyword' => $keyword))->render());
        }

        return view('vicon.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\Vicon;
        $model->tanggal=date('Y-m-d');
        $model->jamawalguna = date('Y-m-d H:i');
        $model->jamakhirguna = date('Y-m-d H:i');
                      
        return view('vicon.create',compact('model'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $model= new \App\Vicon;
        $model->keperluan=$request->keperluan;
        $model->tanggal=$request->tanggal;
        $model->ketua=$request->ketua;
        
        $jam_awal=$request->tanggal.''.$request->jamawalguna;
        $model->jamawalguna = new DateTime($jam_awal);
        
        $jam_akhir=$request->tanggal.''.$request->jamakhirguna;
        $model->jamakhirguna = new DateTime($jam_akhir);
        $model->status=1;
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();

       $model->save();
        
        return redirect('vicon')->with('success', 'Data berhasil ditambahkan');
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
      $model = \App\Vicon::find($id);
        return view('vicon.edit',compact('model','id'));

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('vicon/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\Vicon::find($id);

        $model->tanggal=$request->get('tanggal');
        $model->keperluan=$request->get('keperluan');
        $model->ketua=$request->get('ketua');

        $jam_awal=$request->tanggal.''.$request->jamawalguna;
        $model->jamawalguna = new DateTime($jam_awal);
        
        $jam_akhir=$request->tanggal.''.$request->jamakhirguna;
        $model->jamakhirguna = new DateTime($jam_akhir);
        
        $model->status=$request->get('status');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('vicon');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\Vicon::find($id);
        $model->delete();
        return redirect('vicon')->with('success','Data berhasil dihapus');
        //
    }
}
