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
        $datas=array();
        
        $skp_induk = \App\SkpInduk::where('user_id', '=', )->get();

        return view('skp.index', compact('skp_induk'));
    }

    public function dataSkp(Request $request, $id){
        $datas=array();
        
        $skp_induk = \App\SkpInduk::find($id);
        $skp_target = \App\SkpTarget::where('id_induk', '=', $skp_induk->id)->get();
        $skp_pengukuran = \App\SkpInduk::where('id_induk', '=', $skp_induk->id)->get();

        $datas = [
            'skp_induk'     => $skp_induk,
            'skp_target'    => $skp_target,
            'skp_pengukuran'=> $skp_pengukuran
        ];

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }
}
