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
        $cur_user = Auth::user();

        return view('skp.create', compact('skp_induk', 'list_pegawai', 
            'list_pangkat', 'cur_user'));
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
