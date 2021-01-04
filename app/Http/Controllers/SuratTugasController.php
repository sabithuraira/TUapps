<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratTugasRequest;
use Illuminate\Support\Facades\Crypt;

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
        $datas = \App\SuratTugasRincian::where('unit_kerja', '=', Auth::user()->kdprop.Auth::user()->kdkab)
                ->where(
                    (function ($query) use ($keyword) {
                        $query-> where('nama', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tujuan_tugas', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('nomor_st', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->orderBy('created_at', 'desc')
                ->paginate();

        $datas->withPath('surat_tugas');
        $datas->appends($request->all());

        return view('surat_tugas.index',compact('datas', 'keyword'));
    }
    
    public function daftar(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\SuratTugasRincian::where('unit_kerja', '=', Auth::user()->kdprop.Auth::user()->kdkab)
                ->where(
                    (function ($query) use ($keyword) {
                        $query-> where('nama', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tujuan_tugas', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('nomor_st', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->orderBy('created_at', 'desc')
                ->paginate();

        $datas->withPath('surat_tugas/daftar');
        $datas->appends($request->all());

        return view('surat_tugas.daftar',compact('datas', 'keyword'));
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

        if(Auth::user()->kdkab=='00'){            
            $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                        ->where('kdkab','=',Auth::user()->kdkab)
                        ->where(
                            (function ($query) {
                                $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                            }))->get();
        }
        else{
            $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                        ->where('kdkab','=',Auth::user()->kdkab)
                        ->where(
                            (function ($query) {
                                $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                            }))->get();
        }
                    
                    
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
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);

        if($model_rincian->status_aktif==1){
            $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))->where('kdkab','=',Auth::user()->kdkab)->get();

            if(Auth::user()->kdkab=='00'){            
                $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                            ->where('kdkab','=',Auth::user()->kdkab)
                            ->where(
                                (function ($query) {
                                    $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                                }))->get();
            }
            else{
                $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                            ->where('kdkab','=',Auth::user()->kdkab)
                            ->where(
                                (function ($query) {
                                    $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                                }))->get();
            }
                                
            $list_anggaran = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop.Auth::user()->kdkab)->get();

            return view('surat_tugas.edit',compact('model','id', 'real_id', 
                'list_pegawai', 'list_pejabat', 'list_anggaran', 'model_rincian'));
        }
        else{
            abort(403, 'Data telah dibatalkan, permintaan tidak diberikan');
        }

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
        
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);

        $model->jenis_st=$request->get('jenis_st');
        $model->sumber_anggaran=$request->get('sumber_anggaran');
        $model->mak=$request->get('mak');
        $model->tugas=$request->get('tugas');
        $model->updated_by=Auth::id();
        $model->save();
        
        /////////
        $model_rincian->nip  = $request->get('nip');
        $model_rincian->nama   = $request->get('nama');
        $model_rincian->jabatan = $request->get('jabatan');
        $model_rincian->tujuan_tugas  = $request->get('tujuan_tugas');
        $model_rincian->tanggal_mulai   = date('Y-m-d', strtotime($request->get('tanggal_mulai')));
        $model_rincian->tanggal_selesai = date('Y-m-d', strtotime($request->get('tanggal_selesai')));
        $model_rincian->tingkat_biaya  = $request->get('tingkat_biaya');
        $model_rincian->kendaraan  = $request->get('kendaraan');
        $model_rincian->pejabat_ttd_nip  = $request->get('pejabat_ttd_nip');
        $model_rincian->pejabat_ttd_nama  = $request->get('pejabat_ttd_nama');
        $model_rincian->updated_by=Auth::id();
        $model_rincian->save();
        ///////////
        return redirect('surat_tugas')->with('success', 'Data berhasil diperbaharui');
    }

    public function edit_unit_kerja()
    {
        $model = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop.Auth::user()->kdkab)->first();
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)->where('kdkab','=',Auth::user()->kdkab)->get();

        return view('surat_tugas.edit_unit_kerja',compact('model','list_pegawai'));
    }

    public function update_unit_kerja(Request $request)
    {
        $model = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop.Auth::user()->kdkab)->first();
        $model->kepala_nip  =$request->get('kepala_nip');
        $model->kepala_nama =$request->get('kepala_nama');
        $model->ppk_nip =$request->get('ppk_nip');
        $model->ppk_nama =$request->get('ppk_nama');
        $model->bendahara_nip =$request->get('bendahara_nip');
        $model->bendahara_nama =$request->get('bendahara_nama');
        $model->ppspm_nip =$request->get('ppspm_nip');
        $model->ppspm_nama =$request->get('ppspm_nama');
        $model->ibu_kota =$request->get('ibu_kota');
        $model->alamat_kantor =$request->get('alamat_kantor');
        $model->kontak_kantor =$request->get('kontak_kantor');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('surat_tugas')->with('success', 'Data berhasil diperbaharui');
    }

    public function set_lpd(Request $request){
        if($request->form_id_data!=''){
            
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);

            if($model_rincian->status_kumpul_lpd==0){
                $model_rincian->status_kumpul_lpd = 1;
            }
            else{
                $model_rincian->status_kumpul_lpd = 0;    
            }

            $model_rincian->save();

            return response()->json(['result'=>'Data berhasil disimpan']);
        }
        else{
            return response()->json(['result'=>'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }
    
    public function set_kelengkapan(Request $request){
        if($request->form_id_data!=''){
            
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);

            if($model_rincian->status_kumpul_kelengkapan==0){
                $model_rincian->status_kumpul_kelengkapan = 1;
            }
            else{
                $model_rincian->status_kumpul_kelengkapan = 0;    
            }

            $model_rincian->save();

            return response()->json(['result'=>'Data berhasil disimpan']);
        }
        else{
            return response()->json(['result'=>'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function set_pembayaran(Request $request){
        if($request->form_id_data!=''){
            
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);

            if($model_rincian->status_pembayaran==0) $model_rincian->status_pembayaran = 1;
            else $model_rincian->status_pembayaran = 0;    

            $model_rincian->save();

            return response()->json(['result'=>'Data berhasil disimpan']);
        }
        else{
            return response()->json(['result'=>'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }
    
    public function set_aktif(Request $request){
        if($request->form_id_data!=''){
            
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);
            
            $model_rincian->status_aktif = 2;
            $model_rincian->save();
            return response()->json(['result'=>'Data berhasil disimpan']);
        }
        else{
            return response()->json(['result'=>'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
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
