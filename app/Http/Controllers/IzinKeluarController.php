<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IzinKeluarRequest;
use Maatwebsite\Excel\Facades\Excel;

class IzinKeluarController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');
    // }
    
    public function dataIzinKeluar(Request $request){
        $datas=array();
        $month = date('n');
        $year = date("Y");

        $user_id = "";
        
        if(Auth::user()){
            $user = Auth::user();
            $user_id =  Auth::user()->nip_baru;
        }

        if(strlen($request->get('month'))>0) $month =  $request->get('start');
        if(strlen($request->get('year'))>0) $year =  $request->get('year');
        if(strlen($request->get('user_id'))>0){
            if($request->get('user_id')=="-") $user_id = "";
            else $user_id = $request->get('user_id');
        }

        $model = new \App\IzinKeluar;
        $datas = $model->IzinKeluarRekap($month, $year, $user_id);

        return response()->json(['success'=>'Sukses', 
            'datas'=>$datas,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $month = date('n');
        $year = date("Y");

        $model = new \App\IzinKeluar;
        return view('izin_keluar.index', compact('model', 
            'month', 'year'));
    }

    public function rekap(Request $request){
        $month = date('n');
        $year = date("Y");
        $unit_kerja = Auth::user()->kdkab;

        $model = new \App\IzinKeluar;
        return view('izin_keluar.rekap', compact( 
            'month', 'year', 'unit_kerja'));
    }

    public function data_rekap(Request $request){
        $unit_kerja = Auth::user()->kdkab;

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $jenis_keperluan = 0;

        if(strlen($request->get('unit_kerja'))>0) $unit_kerja = $request->get('unit_kerja');
        if(strlen($request->get('month'))>0) $month = $request->get('month');
        if(strlen($request->get('year'))>0) $year = $request->get('year');
        if(strlen($request->get('jenis_keperluan'))>0) $jenis_keperluan = $request->get('jenis_keperluan');


        $izin_keluar = new \App\IzinKeluar;
        $datas = $izin_keluar->ReportBulanan($month, $year, $unit_kerja, $jenis_keperluan);

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }

    public function rekap_today(Request $request){
        $today = date('Y-m-d');
        $unit_kerja = Auth::user()->kdkab;

        $model = new \App\IzinKeluar;
        return view('izin_keluar.rekap_today', compact('unit_kerja'));
    }

    public function data_rekap_today(Request $request){
        $today =  date('Y-m-d');
        $unit_kerja = Auth::user()->kdkab;
        $jenis_keperluan = 0;

        if(strlen($request->get('jenis_keperluan'))>0) $jenis_keperluan = $request->get('jenis_keperluan');

        $izin_keluar = new \App\IzinKeluar;
        $datas = $izin_keluar->IzinKeluarDay($today, $unit_kerja, $jenis_keperluan);

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }

    public function index_eks(Request $request){
        $month = date('n');
        $year = date("Y");
        $form_user = '-';

        $list_pegawai = \App\UserModel::where('kdkab', '=', '00')
                        ->where('is_active', 1)
                        ->orderBy('kdorg', 'asc')->get();

        $model = new \App\IzinKeluar;
        return view('izin_keluar.index_eks', compact('model', 
            'month', 'year', 'list_pegawai', 'form_user'));
    }

    public function destroy_izinkeluar($id){
        $model = \App\IzinKeluar::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $model = \App\IzinKeluar::find($request->get("id"));
        if($model==null){
            $model = new \App\IzinKeluar;
            $model->pegawai_nip = Auth::user()->nip_baru;
            $model->kode_prov = Auth::user()->kdprop;
            $model->kode_kab = Auth::user()->kdkab;
            $model->created_by=Auth::id();
        }

        $model->tanggal=date("Y-m-d", strtotime($request->get('tanggal')));
        $model->start = date("H:i", strtotime($request->get('start')));
        
        if($request->get('end')==''){
            $model->total_minutes = 0;
        }
        else{
            $model->end = date("H:i", strtotime($request->get('end')));
            $model->total_minutes = abs(strtotime($model->end) - strtotime($model->start)) / 60;
        }

        $model->keterangan = $request->get('keterangan');
        $model->jenis_keperluan = $request->get('jenis_keperluan');
        $model->updated_by= Auth::id();
        $model->save();
        
        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    public function store_eks(Request $request){
        $model = \App\IzinKeluar::find($request->get("id"));
        if($model==null){
            $model = new \App\IzinKeluar;
            $model->created_by=0;
        }

        $model->pegawai_nip = $request->get('pegawai_nip');

        $cur_user = \App\User::where('nip_baru', $request->get('pegawai_nip'))->first();

        if($cur_user){
            $model->kode_prov = $cur_user->kdprop;
            $model->kode_kab = $cur_user->kdkab;
        }

        $model->tanggal=date("Y-m-d", strtotime($request->get('tanggal')));
        $model->start = date("H:i", strtotime($request->get('start')));
        
        if($request->get('end')==''){
            $model->total_minutes = 0;
        }
        else{
            $model->end = date("H:i", strtotime($request->get('end')));
            $model->total_minutes = abs(strtotime($model->end) - strtotime($model->start)) / 60;
        }

        $model->keterangan = $request->get('keterangan');
        $model->jenis_keperluan = $request->get('jenis_keperluan');
        $model->updated_by= 0;
        $model->save();
        
        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){   
        $model = \App\IzinKeluar::find($id);
        $model->delete();
        return redirect('log_book')->with('success','Information has been  deleted');
    }
}
