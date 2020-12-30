<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratTugasRequest;

class SuratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\SuratTugasRincian::where('nama', 'LIKE', '%' . $keyword . '%')
            ->orWhere('tujuan_tugas', 'LIKE', '%' . $keyword . '%')
            ->orWhere('nomor_st', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('surat_tugas');
        $datas->appends($request->all());

        return view('surat_tugas.index',compact('datas', 'keyword'));
    }

    public function calendar(Request $request)
    {
        $unit_kerja = \App\UnitKerja::all();

        $cur_unit_kerja =  \App\UnitKerja::where('kode','=',config('app.kode_prov').Auth::user()->kdkab)->first()->id;
        return view('surat_tugas.calendar', compact(
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

        $datas = \App\UserModel::where('kdprop', '=', substr($kode_unit_kerja,0,2))
                    ->where('kdkab','=',substr($kode_unit_kerja,2))
                    ->get();

        return response()->json(['success'=>'1', 'datas'=>$datas]);
    }
    
	public function listkegiatan(Request $request){
        $month=1;
        if(strlen($request->get('month'))>0){
            $month = $request->get('month');
        }

        $model = new \App\SuratTugas();
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
        $model= new \App\SuratTugas;
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab','=',Auth::user()->kdkab)
                    ->get();

                    
        $list_pejabat = \App\User::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab','=',Auth::user()->kdkab)
                    ->where('kdesl',"<=",2)->get();
                    
                    
        $list_anggaran = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop.Auth::user()->kdkab)->get();

        $model_rincian = new \App\SuratTugasRincian;

        return view('surat_tugas.create', 
            compact('list_pegawai', 'model', 'list_pejabat', 'model_rincian', 'list_anggaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratTugasRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_tugas/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $total_utama = $request->get('total_utama');

        $model= new \App\SuratTugas;
        $model->jenis_st=$request->get('jenis_st');
        $model->sumber_anggaran=$request->get('sumber_anggaran');
        $model->mak=$request->get('mak');
        $model->tugas=$request->get('tugas');
        $model->unit_kerja=Auth::user()->kdprop.Auth::user()->kdkab;
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();

        if($model->save()){
            for($i=1;$i<=$total_utama;++$i){
                if(strlen($request->get('u_nipau'.$i))>0 && strlen($request->get('u_namaau'.$i))>0 
                    && strlen($request->get('u_jabatanau'.$i))>0 && strlen($request->get('u_tujuan_tugasau'.$i))>0
                    && strlen($request->get('u_tanggal_mulaiau'.$i))>0 && strlen($request->get('u_tanggal_selesaiau'.$i))>0
                    && strlen($request->get('u_pejabat_ttd_nipau'.$i))>0 && strlen($request->get('u_pejabat_ttd_namaau'.$i))>0
                    && strlen($request->get('u_tingkat_biayaau'.$i))>0 && strlen($request->get('u_kendaraanau'.$i))>0){
                    
                    $model_r = new \App\SuratTugasRincian;
                    $model_r->id_surtug =  $model->id;
                    $model_r->nip  = $request->get('u_nipau'.$i);
                    $model_r->nama   = $request->get('u_namaau'.$i);
                    $model_r->jabatan = $request->get('u_jabatanau'.$i);
                    $model_r->tujuan_tugas  = $request->get('u_tujuan_tugasau'.$i);
                    $model_r->tanggal_mulai       = date('Y-m-d', strtotime($request->get('u_tanggal_mulaiau'.$i)));
                    $model_r->tanggal_selesai       = date('Y-m-d', strtotime($request->get('u_tanggal_selesaiau'.$i)));
                    $model_r->tingkat_biaya  = $request->get('u_tingkat_biayaau'.$i);
                    $model_r->kendaraan  = $request->get('u_kendaraanau'.$i);
                    $model_r->pejabat_ttd_nip  = $request->get('u_pejabat_ttd_nipau'.$i);
                    $model_r->pejabat_ttd_nama  = $request->get('u_pejabat_ttd_namaau'.$i);
                    
                    ////////////////
                    $nomor_st = 1;
                    $nomor_spd = 1;
                    $datas = \App\SuratTugasRincian::where('unit_kerja', '=', Auth::user()->kdprop.Auth::user()->kdkab)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if($datas!=null){
                        $exp_nomor_st = explode("/",$datas->nomor_st)[0];
                        $exp_nomor_spd = explode("/",$datas->nomor_spd)[0];
                        $prev_nomor_st = (int)$exp_nomor_st;
                        $prev_nomor_spd = (int)$exp_nomor_spd;
                        $nomor_st = $prev_nomor_st + 1;;
                        $nomor_spd = $prev_nomor_spd + 1;
                    }

                    while(strlen($nomor_st)<4)
                        $nomor_st = '0'.$nomor_st;
                        
                    while(strlen($nomor_spd)<4)
                        $nomor_spd = '0'.$nomor_spd;
                    ////////
                    
                    $model_r->nomor_st = $nomor_st.'/BPS'.Auth::user()->kdprop.Auth::user()->kdkab.'/'.date('m').'/'.date('Y');
                    if(Auth::user()->kdkab=='00'){
                        $model_r->nomor_spd = $nomor_spd.'/'.Auth::user()->kdprop.Auth::user()->kdkab.'/SPD/'.date('m').'/'.date('Y');
                    }
                    else{
                        $model_r->nomor_spd = $nomor_spd.'/'.Auth::user()->kdprop.'00/'.Auth::user()->kdprop.Auth::user()->kdkab.'/SPD/'.date('m').'/'.date('Y');
                    }

                    $model_r->unit_kerja = Auth::user()->kdprop.Auth::user()->kdkab;
                    $model_r->status_kumpul_lpd = 0;
                    $model_r->status_kumpul_kelengkapan = 0;
                    $model_r->status_pembayaran = 0;
                    $model_r->created_by=Auth::id();
                    $model_r->updated_by=Auth::id();
                    $model_r->save();
                }
            }
        }
        return redirect('surat_tugas')->with('success', 'Information has been added');
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
        $model = \App\SuratTugas::find($id);
        return view('surat_tugas.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuratTugasRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_tugas/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\SuratTugas::find($id);
        $model->uraian=$request->get('uraian');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('surat_tugas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\SuratTugas::find($id);
        $model->delete();
        return redirect('surat_tugas')->with('success','Information has been  deleted');
    }
}
