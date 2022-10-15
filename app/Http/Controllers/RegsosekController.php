<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegsosekSlsRequest;

class RegsosekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // $kab = $request->get('kab');
        // $kec = $request->get('kec');
        // $desa = $request->get('desa');
        $keyword = $request->get('keyword');

        $arr_condition = [];
        $arr_condition[] = ['status_sls', '=', 1];

        if(strlen($keyword)>=2){
            $prov = substr($keyword, 0, 2);
            $arr_condition[] = ['kode_prov', '=', $prov];
        }

        if(strlen($keyword)>=4){
            $kab = substr($keyword, 2, 2);
            $arr_condition[] = ['kode_kab', '=', $kab];
        }

        if(strlen($keyword)>=7){
            $kec = substr($keyword, 4, 3);
            $arr_condition[] = ['kode_kec', '=', $kec];
        }

        if(strlen($keyword)>=10){
            $desa = substr($keyword, 7, 3);
            $arr_condition[] = ['kode_desa', '=', $desa];
        }

        if(strlen($keyword)>=14){
            $idsls = substr($keyword, 10, 4);
            $arr_condition[] = ['id_sls', '=', $idsls];
        }
        // if(strlen($kab)>0) $arr_condition[] = ['kode_kab', '=', $kab];
        // if(strlen($kec)>0) $arr_condition[] = ['kode_kec', '=', $kec];
        // if(strlen($desa)>0) $arr_condition[] = ['kode_desa', '=', $desa];

        $datas = \App\RegsosekSls::where($arr_condition)->paginate();

        $datas->withPath('regsosek');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('regsosek.list', array('datas' => $datas, 'keyword' => $keyword))->render());
        }

        return view('regsosek.index',compact('datas', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model= new \App\RegsosekSls;
        return view('regsosek.create', 
            compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegsosekSlsRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('regsosek/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $arr_condition = [];
        $arr_condition[] = ['kode_prov', '=', '16'];
        $arr_condition[] = ['status_sls', '=', 1];
        
        if(strlen($request->kode_kab)>0) $arr_condition[] = ['kode_kab', '=', $request->kode_kab];
        if(strlen($request->kode_kec)>0) $arr_condition[] = ['kode_kec', '=', $request->kode_kec];
        if(strlen($request->kode_desa)>0) $arr_condition[] = ['kode_desa', '=', $request->kode_desa];
        if(strlen($request->id_sls)>0) $arr_condition[] = ['id_sls', '=', $request->id_sls];
        if(strlen($request->id_sub_sls)>0) $arr_condition[] = ['id_sub_sls', '=', $request->id_sub_sls];
        
        $model_check = \App\RegsosekSls::where($arr_condition)->first();
        if($model_check!=null){
            return redirect('regsosek/create')
                        ->withErrors(['general'  => ['Data SLS ini sudah ada']])
                        ->withInput();
        }

        $model= new \App\RegsosekSls;
        $model->kode_prov= '16';
        $model->kode_kab = $request->kode_kab;
        $model->kode_kec = $request->kode_kec;
        $model->kode_desa = $request->kode_desa;
        $model->id_sls = $request->id_sls;
        $model->id_sub_sls = $request->id_sub_sls;
        $model->nama_sls = $request->nama_sls;

        $model->sls_op = 1;
        $model->j_keluarga_sls = 0;
        $model->jenis_sls = 1;
        $model->status_sls = 1;

        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('regsosek')->with('success', 'Data berhasil ditambahkan');
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
        $model = \App\RegsosekSls::find($id);
        return view('regsosek.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){   
        $model= \App\RegsosekSls::find($id);

        $model->nama_sls= $request->nama_sls;
        $model->j_keluarga_sls= $request->j_keluarga_sls;
        $model->j_tidak_miskin= $request->j_tidak_miskin;
        $model->j_miskin= $request->j_miskin;
        $model->j_sangat_miskin= $request->j_sangat_miskin;
        $model->updated_by=Auth::id();
        $model->save();

        return redirect('regsosek');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\RegsosekSls::find($id);
        $model->status_sls = 0;
        $model->save();
        return redirect('regsosek')->with('success','Data berhasil dihapus');
    }
}
