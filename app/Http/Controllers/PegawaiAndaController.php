<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiAndaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = '';

        $user = Auth::user();
        $user_id =  Auth::user()->email;
        $model = \App\User::where('email', '=', $user_id)->first();

        $datas = $model->getPegawaiAnda();
        // print_r($datas);die();
        // if(count($datas)>0){
            $datas->withPath('pegawai_anda');
            $datas->appends($request->all());
        // }
        
        if ($request->ajax()) {
            return \Response::json(\View::make('pegawai_anda.list', array('datas' => $datas))->render());
        }

        return view('pegawai_anda.index',compact('datas', 'keyword'));
    }

    public function store(Request $request, $id){
        $user = \App\User::find($id);
        $user_id =  Auth::user()->email;

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $type = 1;

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
        
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        $model = new \App\Ckp;
        $datas = $model->CkpBulanan($type, $month, $year, $user_id);

        foreach($datas['utama'] as $data){
            // if(strlen($request->get('u_uraian'.$data->id))>0 && strlen($request->get('u_satuan'.$data->id))>0 && strlen($request->get('u_target_kuantitas'.$data->id))>0){
                
                $model_utama = \App\Ckp::find($data->id);
                $model_utama->kualitas = $request->get('u_kualitas'.$data->id);
                $model_utama->kecepatan = $request->get('u_kecepatan'.$data->id);
                $model_utama->ketepatan = $request->get('u_ketepatan'.$data->id);
                $model_utama->ketuntasan = $request->get('u_ketuntasan'.$data->id);
                $model_utama->penilaian_pimpinan = $request->get('u_penilaian_pimpinan'.$data->id);
                $model_utama->catatan_koreksi = $request->get('u_catatan_koreksi'.$data->id);
                $model_utama->save();
            // }
        }
        
        foreach($datas['tambahan'] as $data){
            // if(strlen($request->get('t_uraian'.$data->id))>0 && strlen($request->get('t_satuan'.$data->id))>0 && strlen($request->get('t_target_kuantitas'.$data->id))>0){
                $model_tambahan = \App\Ckp::find($data->id);
                $model_tambahan->kualitas = $request->get('t_kualitas'.$data->id);
                $model_tambahan->kecepatan = $request->get('t_kecepatan'.$data->id);
                $model_tambahan->ketepatan = $request->get('t_ketepatan'.$data->id);
                $model_tambahan->ketuntasan = $request->get('t_ketuntasan'.$data->id);
                $model_tambahan->penilaian_pimpinan = $request->get('t_penilaian_pimpinan'.$data->id);
                $model_tambahan->catatan_koreksi = $request->get('t_catatan_koreksi'.$data->id);
                $model_tambahan->save();
            // }
        }
        
        return redirect('/pegawai_anda/'.$id.'/profile')->with('success', 'Information has been added');
    }

    public function profile($id)
    {
        $model = \App\User::find($id);

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $type = 1;

        $ckp = new \App\Ckp;

        $lb_datas=array();

        $start = date('m/d/Y');
        $end = date('m/d/Y');

        return view('pegawai_anda.profile',compact('model','id', 'ckp', 'month', 
            'year', 'type',
            'start', 'end'));
    }
}
