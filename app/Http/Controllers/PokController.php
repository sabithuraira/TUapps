<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PokImport;

class PokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $tahun = date('Y');
        if(strlen($request->tahun)>0) $tahun = $request->tahun;

        $model = new \App\PokRincianAnggaran;
        $datas = $model->getDataAnggaran($tahun);
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))->where('kdkab', '=', Auth::user()->kdkab)->get();

        return view('pok.index', compact(
            'tahun', 'model', 'datas',
            'list_pegawai'
        ));
    }

    public function upload_pok(Request $request){
        $model = new \App\PokMataAnggaran();
        return view('pok.upload_pok',compact('model'));
    }

    public function import_pok(Request $request){
        // Excel::import(new Sp2020SlsPartialImport(), $request->file('excel_file'));
        Excel::import(new PokImport($request->tahun), $request->file('excel_file'));
        return redirect('pok/import_pok')->with('success', 'Information has been added');
    }

    public function save_pj(Request $request){
        if(strlen($request->get('rincian_id'))>0){
            $model =  \App\PokRincianAnggaran::find($request->get('rincian_id'));
            if($model!=null){
                $model->id_pj = $request->get('id_pegawai');
                $model_pegawai = \App\UserModel::find($request->get('id_pegawai'));
                
                if($model_pegawai!=null){
                    $model->nip_pj = $model_pegawai->nip_baru;
                    $model->nama_pj = $model_pegawai->name;
                }

                if($model->save()){
                    return response()->json(['status'=>'success', 
                        'datas' => $model,
                    ]);
                }
            }
        }

        return response()->json(['status'=>'error', 
            'datas' => null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}