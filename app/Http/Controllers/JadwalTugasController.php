<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\JadwalTugasRequest;

class JadwalTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unit_kerja = \App\UnitKerja::all();

        $cur_unit_kerja =  \App\UnitKerja::where('kode','=',config('app.kode_prov').Auth::user()->kdkab)->first()->id;
        return view('jadwal_tugas.index', compact(
            'unit_kerja', 'cur_unit_kerja'
        ));
    }

    public function calendar(Request $request)
    {
        $unit_kerja = \App\UnitKerja::all();

        $cur_unit_kerja =  \App\UnitKerja::where('kode','=',config('app.kode_prov').Auth::user()->kdkab)->first()->id;
        return view('jadwal_tugas.calendar', compact(
            'unit_kerja', 'cur_unit_kerja'
        ));
    }

	public function listPegawai(Request $request){
        $kode_unit_kerja = config('app.kode_prov').'00';

        if(strlen($request->get('unit_kerja'))>0){
            $model_uk = \App\UnitKerja::find($request->get('unit_kerja'));
            if($model_uk!=null)
                $kode_unit_kerja = $model_uk->kode;
        }

        $datas = \App\User::where('kdprop', '=', substr($kode_unit_kerja,0,2))
                    ->where('kdkab','=',substr($kode_unit_kerja,2))
                    ->get();

        return response()->json(['success'=>'1', 'datas'=>$datas]);
    }
    
	public function listkegiatan(Request $request){
        $month=1;
        if(strlen($request->get('month'))>0){
            $month = $request->get('month');
        }

        $model = new \App\JadwalTugas();
        $data = $model->listKegiatanByMonth($month);

        return response()->json(['data'=>$data]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\JadwalTugas;
        $list_pegawai = \App\User::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab','=',Auth::user()->kdkab)
                    ->get();

                    
        $list_pejabat = \App\User::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab','=',Auth::user()->kdkab)
                    ->where('kdesl',"<=",2)
                    ->get();

        return view('jadwal_tugas.create', 
            compact('list_pegawai', 'model', 'list_pejabat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JadwalTugasRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('jadwal_tugas/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\JadwalTugas;
        $model->uraian=$request->get('uraian');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('jadwal_tugas')->with('success', 'Information has been added');
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
        $model = \App\JadwalTugas::find($id);
        return view('jadwal_tugas.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JadwalTugasRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('jadwal_tugas/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\JadwalTugas::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('jadwal_tugas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\JadwalTugas::find($id);
        $model->delete();
        return redirect('jadwal_tugas')->with('success','Information has been  deleted');
    }
}
