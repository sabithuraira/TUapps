<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SiraRincianRequest;
use App\Http\Requests\SiraAkunRequest;
use App\Http\Requests\SiraAkunRealisasiRequest;
use App\Imports\SiraPartialImport;

class SiraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');
        $datas = \App\SiraAkun::where('mak', 'LIKE', '%' . $keyword . '%')
            ->orWhere('akun', 'LIKE', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('sira');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('sira.list', array('datas' => $datas, 'keyword'=>$keyword))->render());
        }

        return view('sira.index',compact('datas', 'keyword'));
    }


    public function create_akun(){
        $model= new \App\SiraAkun;
        return view('sira.create_akun',compact('model'));
    }

    public function store_akun(SiraAkunRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/create_akun')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\SiraAkun;
        $model->kode_mak=$request->get('kode_mak');
        $model->mak=$request->get('mak');
        $model->kode_akun=$request->get('kode_akun');
        $model->akun=$request->get('akun');
        $model->tahun=$request->get('tahun');
        $model->pagu=$request->get('pagu');
        $model->realisasi=0;
        $model->kode_fungsi=$request->get('kode_fungsi');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('sira')->with('success', 'Information has been added');
    }

    public function edit_akun($id){
        $model= \App\SiraAkun::find($id);
        return view('sira.edit_akun',compact('model', 'id'));
    }

    public function update_akun(SiraAkunRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/edit_akun', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= \App\SiraAkun::find($id);
        $model->kode_mak=$request->get('kode_mak');
        $model->mak=$request->get('mak');
        $model->kode_akun=$request->get('kode_akun');
        $model->akun=$request->get('akun');
        $model->tahun=$request->get('tahun');
        $model->pagu=$request->get('pagu');
        $model->kode_fungsi=$request->get('kode_fungsi');
        $model->updated_by=Auth::id();
        $model->save();

        $model->syncRealisasi($id);
        
        return redirect('sira')->with('success', 'Information has been added');
    }

    public function import_akun(){
        $model= new \App\SiraAkun;
        return view('sira.import_akun',compact('model'));
    }

    public function upload_akun(Request $request){
        Excel::import(new SiraPartialImport($request->tahun), $request->file('excel_file'));
        return redirect('sira')->with('success', 'Data berhasil di import');
    }

    public function create_realisasi($id){
        $akun= \App\SiraAkun::find($id);
        $model= new \App\SiraAkunRealisasi;
        return view('sira.create_akun_realisasi',compact('model', 'akun', 'id'));
    }

    public function store_realisasi(SiraAkunRealisasiRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/'.$id.'/create_realisasi')
                        ->withErrors($validator)
                        ->withInput();
        }

        $akun= \App\SiraAkun::find($id);
        $model= new \App\SiraAkunRealisasi;
        $model->kode_mak= $akun->kode_mak;
        $model->kode_akun=  $akun->kode_akun;
        $model->kode_fungsi =$request->get('kode_fungsi');
        $model->realisasi = $request->get('realisasi');
        $model->keterangan = $request->get('keterangan');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();

        $akun->syncRealisasi($id);
        
        return redirect('sira/'.$id.'/show')->with('success', 'Information has been added');
    }

    public function edit_realisasi($id){
        $model= \App\SiraAkunRealisasi::find($id);
        $akun= \App\SiraAkun::where('kode_akun', $model->kode_akun)
                    ->where('kode_mak', $model->kode_mak)->first();
        return view('sira.edit_akun_realisasi',compact('model', 'id', 'akun'));
    }

    public function update_realisasi(SiraAkunRealisasiRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/'.$id.'/edit_realisasi', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= \App\SiraAkunRealisasi::find($id);
        $model->kode_fungsi =$request->get('kode_fungsi');
        $model->realisasi = $request->get('realisasi');
        $model->keterangan = $request->get('keterangan');
        $model->updated_by=Auth::id();
        $model->save();

        $akun= \App\SiraAkun::where('kode_akun', $model->kode_akun)
                    ->where('kode_mak', $model->kode_mak)->first();

        $myAkun = new \App\SiraAkun;
        $myAkun->syncRealisasi($akun->id);
        
        return redirect('sira/'.$akun->id.'/show')->with('success', 'Information has been added');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model= new \App\SiraRincian;
        $akun = \App\SiraAkun::all();
        return view('sira.create',compact('model', 'akun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // if (isset($request->validator) && $request->validator->fails()) {
        //     return redirect('sira/create')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        $model= new \App\SiraRincian;
        $model->kode_mak=$request->get('kode_mak');
        $model->kode_akun= $request->get('kode_akun');
        $model->kode_fungsi=$request->get('kode_fungsi');
        $model->jenis = 1;
        $bukti = 0;

        $model->path_kak=$request->get('path_kak');
        if($model->path_kak!='' && $model->path_kak!=null) $bukti++;

        $model->path_form_permintaan=$request->get('path_form_permintaan');
        if($model->path_form_permintaan!='' && $model->path_form_permintaan!=null) $bukti++;

        if($model->kode_akun=='522111' || $model->kode_akun=='522112' || 
                $model->kode_akun=='522113' 
                || $model->kode_akun=='522119'
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524113'
                || $model->kode_akun=='524111'
                || $model->kode_akun=='522141'
                || $model->kode_akun=='522151' 
                || $model->kode_akun=='521811' 
                || $model->kode_akun=='521219' 
                || $model->kode_akun=='521213' 
                || $model->kode_akun=='521211'){
            $model->path_bukti_pembayaran=$request->get('path_bukti_pembayaran');
            if($model->path_bukti_pembayaran!='' && $model->path_bukti_pembayaran!=null) $bukti++;
            // $model->path_kuitansi=$request->get('path_kuitansi');
        }

        // $model->path_notdin=$request->get('path_notdin');

        if($model->kode_akun=='521211' || $model->kode_akun=='522151' 
                || $model->kode_akun=='524114' || $model->kode_akun=='524119'){
            $model->path_undangan=$request->get('path_undangan');
            if($model->path_undangan!='' && $model->path_undangan!=null) $bukti++;
        }

        if($model->kode_akun=='521211' || $model->kode_akun=='524114' || $model->kode_akun=='524119'){
            $model->path_notulen=$request->get('path_notulen');
            if($model->path_notulen!='' && $model->path_notulen!=null) $bukti++;
        }


        if($model->kode_akun=='521211' 
                || $model->kode_akun=='521213' 
                || $model->kode_akun=='522151'  
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524119'){
            $model->path_daftar_hadir=$request->get('path_daftar_hadir');
            if($model->path_daftar_hadir!='' && $model->path_daftar_hadir!=null) $bukti++;
        }

        if($model->kode_akun=='521213' || $model->kode_akun=='522151'){
            $model->path_sk=$request->get('path_sk');
            if($model->path_sk!='' && $model->path_sk!=null) $bukti++;
        }

        
        if($model->kode_akun=='521213' 
                || $model->kode_akun=='524111' 
                || $model->kode_akun=='524113' 
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524119' 
                || $model->kode_akun=='522119'){
            $model->path_st=$request->get('path_st');
            if($model->path_st!='' && $model->path_st!=null) $bukti++;
        }

        if($model->kode_akun=='521213' 
                || $model->kode_akun=='521811' 
                || $model->kode_akun=='522141'){
            $model->path_spk=$request->get('path_spk');
            if($model->path_spk!='' && $model->path_spk!=null) $bukti++;
        }

        if($model->kode_akun=='521213' 
                || $model->kode_akun=='522141' 
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524119'){
            $model->path_bast=$request->get('path_bast');
            if($model->path_bast!='' && $model->path_bast!=null) $bukti++;
        }

        if($model->kode_akun=='521213' || $model->kode_akun=='522151'){
            $model->path_rekap_belanja=$request->get('path_rekap_belanja');
            if($model->path_rekap_belanja!='' && $model->path_rekap_belanja!=null) $bukti++;
        }

        if($model->kode_akun=='521213' || $model->kode_akun=='524114' || $model->kode_akun=='524119'){
            $model->path_laporan=$request->get('path_laporan');
            if($model->path_laporan!='' && $model->path_laporan!=null) $bukti++;
        }

        if($model->kode_akun=='521213' 
                || $model->kode_akun=='522151' 
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524119'){
            $model->path_jadwal=$request->get('path_jadwal');
            if($model->path_jadwal!='' && $model->path_jadwal!=null) $bukti++;
        }

        if($model->kode_akun=='521219' || $model->kode_akun=='524119'){
            $model->path_drpp=$request->get('path_drpp');
            if($model->path_drpp!='' && $model->path_drpp!=null) $bukti++;
        }

        if($model->kode_akun=='521219' 
                || $model->kode_akun=='522141' 
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524119'){
            $model->path_invoice=$request->get('path_invoice');
            if($model->path_invoice!='' && $model->path_invoice!=null) $bukti++;
        }

        if($model->kode_akun=='521219'){
            $model->path_resi_pengiriman=$request->get('path_resi_pengiriman');
            if($model->path_resi_pengiriman!='' && $model->path_resi_pengiriman!=null) $bukti++;
        }

        if($model->kode_akun=='521219' 
                || $model->kode_akun=='522141'){
            $model->path_npwp_rekkor=$request->get('path_npwp_rekkor');
            if($model->path_npwp_rekkor!='' && $model->path_npwp_rekkor!=null) $bukti++;
        }

        if($model->kode_akun=='521811'){
            $model->path_tanda_terima=$request->get('path_tanda_terima');
            if($model->path_tanda_terima!='' && $model->path_tanda_terima!=null) $bukti++;
        }

        if($model->kode_akun=='522151'){
            $model->path_cv=$request->get('path_cv');
            if($model->path_cv!='' && $model->path_cv!=null) $bukti++;
        }

        if($model->kode_akun=='522151'){
            $model->path_bahan_paparan=$request->get('path_bahan_paparan');
            if($model->path_bahan_paparan!='' && $model->path_bahan_paparan!=null) $bukti++;
        }

        if($model->kode_akun=='522141'){
            $model->path_ba_pembayaran=$request->get('path_ba_pembayaran');
            if($model->path_ba_pembayaran!='' && $model->path_ba_pembayaran!=null) $bukti++;
        }

        if($model->kode_akun=='524111' 
                || $model->kode_akun=='524113'  
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='524119'  
                || $model->kode_akun=='522119'){
            $model->path_spd_visum=$request->get('path_spd_visum');
            if($model->path_spd_visum!='' && $model->path_spd_visum!=null) $bukti++;

            $model->path_presensi_uang_makan=$request->get('path_presensi_uang_makan');
            if($model->path_presensi_uang_makan!='' && $model->path_presensi_uang_makan!=null) $bukti++;
        }

        if($model->kode_akun=='524111'){
            $model->path_rincian_perjadin=$request->get('path_rincian_perjadin');
            if($model->path_rincian_perjadin!='' && $model->path_rincian_perjadin!=null) $bukti++;
        }

        if($model->kode_akun=='524111' || $model->kode_akun=='522119'){
            $model->path_bukti_transport=$request->get('path_bukti_transport');
            if($model->path_bukti_transport!='' && $model->path_bukti_transport!=null) $bukti++;
        }

        if($model->kode_akun=='524111'){
            $model->path_bukti_inap=$request->get('path_bukti_inap');
            if($model->path_bukti_inap!='' && $model->path_bukti_inap!=null) $bukti++;
        }

        if($model->kode_akun=='524111' || $model->kode_akun=='524113'){
            $model->path_lpd=$request->get('path_lpd');
            if($model->path_lpd!='' && $model->path_lpd!=null) $bukti++;
        }

        if($model->kode_akun=='524111' 
                || $model->kode_akun=='524113' 
                || $model->kode_akun=='524114' 
                || $model->kode_akun=='522119'){
            $model->path_rekap_perjadin=$request->get('path_rekap_perjadin');
            if($model->path_rekap_perjadin!='' && $model->path_rekap_perjadin!=null) $bukti++;
        }

        if($model->kode_akun=='524113' 
                || $model->kode_akun=='524114'){
            $model->path_sp_kendaraan_dinas=$request->get('path_sp_kendaraan_dinas');
            if($model->path_sp_kendaraan_dinas!='' && $model->path_sp_kendaraan_dinas!=null) $bukti++;
        }

        if($model->kode_akun=='524113'){
            $model->path_daftar_rill=$request->get('path_daftar_rill');
            if($model->path_daftar_rill!='' && $model->path_daftar_rill!=null) $bukti++;
        }

        ///////////
        if($model->kode_akun=='522111' || $model->kode_akun=='522112' || 
            $model->kode_akun=='522113'){
            $model->target_bukti = 3;
        }

        if($model->kode_akun=='521211'){
            $model->target_bukti = 6;
        }

        if($model->kode_akun=='521213'){
            $model->target_bukti = 9;
        }

        if($model->kode_akun=='521219'){
            $model->target_bukti = 7;
        }

        if($model->kode_akun=='521811'){
            $model->target_bukti = 5;
        }

        if($model->kode_akun=='522151' || $model->kode_akun=='524113'){
            $model->target_bukti = 10;
        }

        if($model->kode_akun=='522141' 
            || $model->kode_akun=='522119' 
            || $model->kode_akun=='524114'){
            $model->target_bukti = 8;
        }
        ///////////

        $model->realisasi_bukti = $bukti;
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('sira')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $model = \App\SiraAkun::find($id);
        $rincian = \App\SiraRincian::where('kode_mak', '=', $model->kode_mak)
                        ->where('kode_akun', '=', $model->kode_akun)->get();

        $realisasi = \App\SiraAkunRealisasi::where('kode_mak', '=', $model->kode_mak)
                        ->where('kode_akun', '=', $model->kode_akun)->get();

        //$myUrl =  "https://st23.bpssumsel.com/api/file/";
        $myUrl = "http://localhost/mon_st2023/public/api/file/";

        return view('sira.show',compact('model', 'id', 
                'realisasi',
                'rincian', 'myUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $model = \App\PemegangBmn::find($id);
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('id', 'asc')
            ->get();
        return view('sira.edit',compact('model','id', 'list_user'));
    }

    public function getAkun($kode_mak){
        $result = \App\SiraAkun::where('kode_mak', '=', $kode_mak)->get();
        return response()->json(['status'  => 'success', 'datas'=>$result]);
    }


    public function getDashboard(){
        $model = new \App\SiraAkun;
        $data1 = $model->rekapPagu();

        $result1 = array(
            $data1[0]->umum,
            $data1[0]->sosial,
            $data1[0]->nerwilis,
            $data1[0]->distribusi,
            $data1[0]->produksi,
            $data1[0]->ipds,
        );

        $data2 = $model->rekapRealisasi();
        $result2 = [
            $data2[0]->umum,
            $data2[0]->sosial,
            $data2[0]->nerwilis,
            $data2[0]->distribusi,
            $data2[0]->produksi,
            $data2[0]->ipds,
        ];
        return response()->json(['status'  => 'success', 
            'data1'=>$result1, 'data2'=> $result2]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PemegangBmnRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('sira/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\PemegangBmn::find($id);
        $user_barang = \App\UserModel::find($request->get('id_pemegang'));
        $model->id_pemegang=$user_barang->id;
        $model->nip_baru=$user_barang->nip_baru;
        $model->nama=$user_barang->name;
        $model->nama_barang=$request->get('nama_barang');
        $model->serial_number=$request->get('serial_number');
        $model->deskripsi_barang=$request->get('deskripsi_barang');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('sira');
    }

    public function syncAll(Request $request){

        $model = new \App\SiraAkun();
        $all = \App\SiraAkun::all();

        foreach($all as $value){
            $model->syncRealisasi($value->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\SiraAkun::find($id);

        \App\SiraRincian::where('kode_mak', $model->kode_mak)
                            ->where('kode_akun', $model->kode_akun)->delete();
        \App\SiraAkunRealisasi::where('kode_mak', $model->kode_mak)
                            ->where('kode_akun', $model->kode_akun)->delete();

        $model->delete();

        return redirect('sira')->with('success','Information has been  deleted');
    }

    public function destroy_rincian($id){
        $model = \App\SiraAkunRealisasi::find($id);

        $model_akun = \App\SiraAkun::where('kode_akun', $model->kode_akun)
                        ->where('kode_mak', $model->kode_mak)->first();

        $model->delete();
        $model_akun->syncRealisasi($model_akun->id);
        // return redirect('sira/'.$model_akun->id.'/show')->with('success','Information has been  deleted');
        return response()->json(['status'=>'success', 'data'=>'ok']);
    }
}
