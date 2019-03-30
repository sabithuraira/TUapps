<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = Permission::all();
        return view('permission.index',compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Permission;
        if($request->id!=0 && Permission::find($request->id)!=null){
            $model = Permission::find($request->id);
        }
        
        $model->name = $request->permission_name;
        $model->save();

        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $model = \App\RincianKredit::find($id);
    //     $model->delete();
    //     return redirect('rincian_kredit')->with('success','Information has been  deleted');
    // }
}
