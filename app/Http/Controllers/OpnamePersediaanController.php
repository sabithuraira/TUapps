<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MasterBarangRequest;

class OpnamePersediaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
            
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');

        $model = new \App\Opnamepersediaan();
        $datas = $model->OpnameRekap($month, $year);

        // dd($datas);

        if ($request->ajax()) {
            return \Response::json(\View::make('opname_persediaan.list', array('datas' => $datas))->render());
        }

        return view('opname_persediaan.index',compact('datas', 'year', 'month'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
            
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');

        $model = new \App\Opnamepersediaan();
        $datas = $model->OpnameRekap($month, $year);

        return view('opname_persediaan.form',compact('datas', 'year', 'month'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterBarangRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('master_barang/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        // dd($request->get('harga_satuan'));
        
        $model= new \App\MasterBarang;
        $model->nama_barang=$request->get('nama_barang');
        $model->unit_kerja= Auth::user()->kdprop.Auth::user()->kdkab;
        $model->satuan=$request->get('satuan');
        $model->harga_satuan=$request->get('harga_satuan');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('master_barang')->with('success', 'Data berhasil ditambahkan');
    }
}
