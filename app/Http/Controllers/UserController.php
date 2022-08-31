<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');

        if(Auth::user()->kdkab!='00'){
            $datas = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
                ->where(
                    (function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('email', 'LIKE', '%' . $keyword . '%');
                    })
                )->paginate();
        }
        else{
            $datas = \App\UserModel::where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->paginate();
        }

        $datas->withPath('user');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('user.list', array('datas' => $datas))->render());
        }

        return view('user.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function edit($id){
        $model = \App\UserModel::find($id);

        $list_pegawai = \App\UserModel::where([
                ['id', '<>', 1],
                ['kdkab', '=', Auth::user()->kdkab]
            ])
            ->orWhere([['kdesl', '=', 2],])
            ->orderBy('name', 'ASC')->get();

        return view('user.edit',compact('model','id', 
            'list_pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('user/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\UserModel::find($id);
        $pimpinan = \App\UserModel::find($request->pimpinan_id);
        if($pimpinan!=null){
            $model->pimpinan_id    = $pimpinan->id;
            $model->pimpinan_nik    = $pimpinan->nip_baru;
            $model->pimpinan_nama    = $pimpinan->name;
            $model->pimpinan_jabatan    = $pimpinan->nmjab;
            $model->save();
        }

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\User::find($id);
        $model->delete();
        return redirect('user')->with('success','Information has been  deleted');
    }
}
