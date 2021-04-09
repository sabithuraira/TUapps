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
    }

    public function store_pengukuran(Request $request){
        $user = Auth::user();
        $user_id =  Auth::user()->email;

        $skp_id = $request->get('skp_id');
        $skp_induk = $request->get('skp_induk');
        $skp_pengukuran = $request->get('skp_pengukuran');

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
            foreach($skp_pengukuran as $key=>$value){
                $model_pengukuran = new \App\SkpPengukuran;
                if($value['id']!=''){
                    $temp_data = \App\SkpPengukuran::find($value['id']);
                    if($temp_data!=null) $model_pengukuran = $temp_data;
                }
                else{
                    $model_pengukuran->created_by = Auth::id();
                }

                $model_pengukuran->id_induk = $model_induk->id;
                $model_pengukuran->user_id = $user_id;
                $model_pengukuran->uraian = $value['uraian'];
                $model_pengukuran->kode_point_kredit = $value['kode_point_kredit'];
                $model_pengukuran->target_satuan = $value['target_satuan'];
                $model_pengukuran->target_kuantitas = $value['target_kuantitas'];
                $model_pengukuran->target_kualitas = $value['target_kualitas'];
                $model_pengukuran->target_waktu = $value['target_waktu'];
                $model_pengukuran->target_satuan_waktu = $value['target_satuan_waktu'];
                $model_pengukuran->target_biaya = $value['target_biaya'];
                $model_pengukuran->target_angka_kredit = $value['target_angka_kredit'];
                
                $model_pengukuran->realisasi_satuan = $value['realisasi_satuan'];
                $model_pengukuran->realisasi_kuantitas = $value['realisasi_kuantitas'];
                $model_pengukuran->realisasi_kualitas = $value['realisasi_kualitas'];
                $model_pengukuran->realisasi_waktu = $value['realisasi_waktu'];
                $model_pengukuran->realisasi_satuan_waktu = $value['realisasi_satuan_waktu'];
                $model_pengukuran->realisasi_biaya = $value['realisasi_biaya'];
                $model_pengukuran->realisasi_angka_kredit = $value['realisasi_angka_kredit'];

                $model_pengukuran->penghitungan = $value['penghitungan'];
                $model_pengukuran->nilai_capaian_ckp = $value['nilai_capaian_ckp'];
                $model_pengukuran->jenis = 1;
                $model_pengukuran->updated_by = Auth::id();
                $model_pengukuran->save();
            }
        }

        return response()->json(['success'=>1]);
    }

    public function dataSkp(Request $request, $id){
        $datas=array();
        
        $skp_induk = \App\SkpInduk::find($id);
        if($skp_induk!==null){
            $skp_target = \App\SkpTarget::where('id_induk', '=', $skp_induk->id)->get();
            $skp_pengukuran = \App\SkpPengukuran::where('id_induk', '=', $skp_induk->id)->get();
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
