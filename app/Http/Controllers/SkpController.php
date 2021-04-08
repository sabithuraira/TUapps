<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class SkpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $skp_induk = \App\SkpInduk::where('user_id', '=', Auth::user()->email)->get();

        return view('skp.index', compact('skp_induk'));
    }

    public function create(){
        $skp_induk = \App\SkpInduk::where('user_id', '=', Auth::user()->email)->get();
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab','=',Auth::user()->kdkab)->get();
        $list_pangkat = (new \App\UserModel())->listPangkat;
        $cur_user_id = Auth::user()->email;

        // print_r($skp_induk);die();

        return view('skp.create', compact('skp_induk', 'list_pegawai', 
            'list_pangkat', 'cur_user_id'));
    }

    public function store_target(Request $request){
        $user = Auth::user();
        $user_id =  Auth::user()->email;

        $skp_id = $request->get('skp_id');
        $skp_induk = $request->get('skp_induk');
        $skp_target = $request->get('skp_target');

        // print_r($skp_induk);

        $model_induk =  new \App\SkpInduk;
        if($skp_id!='' && $skp_id!=0){
            $model_induk = \App\SkpInduk::find($skp_id);
        }
        $model_induk->tanggal_mulai = date('Y-m-d', strtotime($skp_induk['tanggal_mulai'])) ;
        $model_induk->tanggal_selesai = date('Y-m-d', strtotime($skp_induk['tanggal_selesai'])) ;
        $model_induk->user_id = $user_id;
        $model_induk->user_pangkat = $skp_induk['user_pangkat'];
        $model_induk->user_gol = $skp_induk['user_gol'];
        $model_induk->user_jabatan = $skp_induk['user_jabatan'];
        $model_induk->user_unit_kerja = $skp_induk['user_unit_kerja'];
        $model_induk->pimpinan_id = $skp_induk['pimpinan_id'];
        $model_induk->pimpinan_pangkat = $skp_induk['pimpinan_pangkat'];
        $model_induk->pimpinan_gol = $skp_induk['pimpinan_gol'];
        $model_induk->pimpinan_jabatan = $skp_induk['pimpinan_jabatan'];
        $model_induk->pimpinan_unit_kerja = $skp_induk['pimpinan_unit_kerja'];
        $model_induk->versi = 1;
        if($model_induk->save()){
            foreach($skp_target as $key=>$value){
                $model_target = new \App\SkpTarget;
                if($value['id']!=''){
                    $temp_data = \App\SkpTarget::find($value['id']);
                    if($temp_data!=null) $model_target = $temp_data;
                }
                else{
                    $model_target->created_by = Auth::id();
                }

                $model_target->id_induk = $model_induk->id;
                $model_target->user_id = $user_id;
                $model_target->uraian = $value['uraian'];
                $model_target->satuan = $value['satuan'];
                $model_target->target_kuantitas = $value['target_kuantitas'];
                $model_target->target_kualitas = $value['target_kualitas'];
                $model_target->waktu = $value['waktu'];
                $model_target->satuan_waktu = $value['satuan_waktu'];
                $model_target->biaya = $value['biaya'];
                $model_target->jenis = 1;
                $model_target->updated_by = Auth::id();
                $model_target->save();
            }
        }

        return response()->json(['success'=>1]);


        // foreach($datas['utama'] as $data){
        //     if(strlen($request->get('u_uraian'.$data->id))>0 && strlen($request->get('u_satuan'.$data->id))>0 && strlen($request->get('u_target_kuantitas'.$data->id))>0){
                
        //         $model_utama = \App\Ckp::find($data->id);
        //         $model_utama->uraian = $request->get('u_uraian'.$data->id);
        //         $model_utama->satuan = $request->get('u_satuan'.$data->id);
        //         $model_utama->target_kuantitas = $request->get('u_target_kuantitas'.$data->id);

        //         $model_utama->realisasi_kuantitas = $request->get('u_realisasi_kuantitas'.$data->id);
        //         // $model_utama->kualitas = $request->get('u_kualitas'.$data->id);

        //         $model_utama->kode_butir = $request->get('u_kode_butir'.$data->id);
        //         $model_utama->angka_kredit = $request->get('u_angka_kredit'.$data->id);
        //         $model_utama->keterangan = $request->get('u_keterangan'.$data->id);
                
        //         // $model_utama->kecepatan = $request->get('u_kecepatan'.$data->id);
        //         // $model_utama->ketepatan = $request->get('u_ketepatan'.$data->id);
        //         // $model_utama->ketuntasan = $request->get('u_ketuntasan'.$data->id);
        //         // $model_utama->penilaian_pimpinan = $request->get('u_penilaian_pimpinan'.$data->id);
        //         // $model_utama->catatan_koreksi = $request->get('u_catatan_koreksi'.$data->id);
        //         $model_utama->iki = $request->get('u_iki'.$data->id);

        //         $model_utama->save();
        //     }
        // }
        

        
        // $ckp_log = new \App\CkpLogBulanan();
        // $ckp_log->triggerCkp(Auth::user()->email, Auth::id(), $request->get('month'), $request->get('year'));
        
        // return redirect('/ckp')->with('success', 'Information has been added');
    }

    public function dataSkp(Request $request, $id){
        $datas=array();
        
        $skp_induk = \App\SkpInduk::find($id);
        if($skp_induk!==null){
            $skp_target = \App\SkpTarget::where('id_induk', '=', $skp_induk->id)->get();
            $skp_pengukuran = \App\SkpInduk::where('id_induk', '=', $skp_induk->id)->get();
        }
        else{
            $skp_target = [];
            $skp_pengukuran = [];
        }

        $datas = [
            'skp_induk'     => $skp_induk,
            'skp_target'    => $skp_target,
            'skp_pengukuran'=> $skp_pengukuran
        ];

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }
}
