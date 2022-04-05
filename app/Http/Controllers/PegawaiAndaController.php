<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PegawaiAndaController extends Controller
{
    public function index(Request $request){
        $keyword = $request->get('search');

        $user = Auth::user();
        $user_id =  Auth::user()->email;
        $model = \App\User::where('email', '=', $user_id)->first();

        $datas = $model->getPegawaiAnda($keyword);
        $datas->withPath('pegawai_anda');
        $datas->appends($request->all());
        
        if ($request->ajax()) {
            return \Response::json(\View::make('pegawai_anda.list', array('datas' => $datas))->render());
        }

        return view('pegawai_anda.index',compact('datas', 'keyword'));
    }

    public function penilaian_anda(Request $request){
        $month = date("m");
        $year = date("Y");

        $user = Auth::user();
        $user_id =  Auth::user()->email;
        $empty_ckp = new \App\Ckp;
        
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('kdorg', 'asc')
            ->get();

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');
            
        return view('pegawai_anda.penilaian_anda',compact('month', 
            'year', 'empty_ckp', 'user_id', 'list_user'));
    }

    public function dataCkpTim(Request $request){
        $datas=array();
        $month = date('m');
        $year = date('Y');
        $user_id =  Auth::user()->email;

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');

        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
        
        $model = new \App\Ckp;
        $datas = $model->CkpBulananTim(1, $month, $year, $user_id);

        $model_logbook = new \App\LogBook;
        $datas_logbooks = $model_logbook->LogBookRekapTim($month, $year, $user_id);

        return response()->json([
            'success'=>'Sukses', 
            'datas'=>$datas,
            'datas_logbooks'=>$datas_logbooks,
        ]);
    }


    public function store(Request $request, $id){
        // $user = \App\User::find($id);
        $real_id = Crypt::decrypt($id);
        $user = \App\User::find($real_id);
        
        $user_id =  $user->email;

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $start = date('Y-m-d');
        $end = date('Y-m-d');    

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
        
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');

        if(strlen($request->get('start'))>0)
            $start = date("Y-m-d", strtotime($request->get('start')));
        
        if(strlen($request->get('end'))>0)
            $end = date("Y-m-d", strtotime($request->get('end')));

        $penilaian_pimpinan = 0 ;
        if(strlen($request->penilaian_pimpinan)>0){
            $penilaian_pimpinan = $request->penilaian_pimpinan;
        }
            
        $model = new \App\Ckp;
        $datas = $model->CkpBulanan(1, $month, $year, $user->email);
        
        $model_log_book = new \App\LogBook;
        $log_books = $model_log_book->LogBookRekap($start, $end, $user_id);

        foreach($datas['utama'] as $data){
            // if(strlen($request->get('u_uraian'.$data->id))>0 && strlen($request->get('u_satuan'.$data->id))>0 && strlen($request->get('u_target_kuantitas'.$data->id))>0){
                
                $model_utama = \App\Ckp::find($data->id);
                // $model_utama->kualitas = $request->get('u_kualitas'.$data->id);
                $model_utama->kecepatan = $request->get('u_kecepatan'.$data->id);
                $model_utama->ketepatan = $request->get('u_ketepatan'.$data->id);
                $model_utama->ketuntasan = $request->get('u_ketuntasan'.$data->id);
                $model_utama->penilaian_pimpinan = $penilaian_pimpinan;
                if($penilaian_pimpinan>0){
                    $total_nilai_tim = ((int)$model_utama->kecepatan + (int)$model_utama->ketepatan + (int)$model_utama->ketuntasan)/3;
                    $model_utama->kualitas = ((int)$total_nilai_tim + (int)$penilaian_pimpinan)/2;
                }
                else{
                    $model_utama->kualitas = ((int)$model_utama->kecepatan + (int)$model_utama->ketepatan + (int)$model_utama->ketuntasan)/3;
                }
                $model_utama->catatan_koreksi = $request->get('u_catatan_koreksi'.$data->id);
                $model_utama->save();
            // }
        }
        
        foreach($datas['tambahan'] as $data){
            // if(strlen($request->get('t_uraian'.$data->id))>0 && strlen($request->get('t_satuan'.$data->id))>0 && strlen($request->get('t_target_kuantitas'.$data->id))>0){
                $model_tambahan = \App\Ckp::find($data->id);
                // $model_tambahan->kualitas = $request->get('t_kualitas'.$data->id);
                $model_tambahan->kecepatan = $request->get('t_kecepatan'.$data->id);
                $model_tambahan->ketepatan = $request->get('t_ketepatan'.$data->id);
                $model_tambahan->ketuntasan = $request->get('t_ketuntasan'.$data->id);
                $model_tambahan->penilaian_pimpinan = $penilaian_pimpinan;

                if($penilaian_pimpinan>0){
                    $total_nilai_tim = ((int)$model_tambahan->kecepatan + (int)$model_tambahan->ketepatan + (int)$model_tambahan->ketuntasan)/3;
                    $model_tambahan->kualitas = ((int)$total_nilai_tim + (int)$penilaian_pimpinan)/2;
                }
                else{
                    $model_tambahan->kualitas = ((int)$model_tambahan->kecepatan + (int)$model_tambahan->ketepatan + (int)$model_tambahan->ketuntasan)/3;
                }
                $model_tambahan->catatan_koreksi = $request->get('t_catatan_koreksi'.$data->id);
                $model_tambahan->save();
            // }
        }

        foreach($log_books as $data){
            if(strlen($request->get('u_status_penyelesaian'.$data['id']))>0){
                $model_lb = \App\LogBook::find($data['id']);
                $model_lb->status_penyelesaian = $request->get('u_status_penyelesaian'.$data['id']);
                $model_lb->save();
            }
        }

        $ckp_log = new \App\CkpLogBulanan();
        $ckp_log->triggerCkp($user_id, $user->id, $month, $year);
        
        return redirect('/pegawai_anda/'.$id.'/profile')->with('success', 'Information has been added');
    }

    public function profile($id){
        $real_id = Crypt::decrypt($id);
        // $model = \App\User::find($id);
        $model = \App\User::find($real_id);

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $penilaian_pimpinan = 0;

        $ckp = new \App\Ckp;
        $ckp_log = \App\CkpLogBulanan::where([
                ['user_id', '=', $model->email],
                ['month', '=', $month],
                ['year', '=', $year],
            ])->first();

        if($ckp_log!=null) $penilaian_pimpinan = $ckp_log->penilaian_pimpinan;

        $lb_datas=array();

        $start = date("m/d/Y", strtotime(date( "Y-m-d",strtotime(date("Y-m-d") ))."-1 month" ));
        $end = date('m/d/Y');
        
        $start_rencana = date('m/d/Y');
        $end_rencana = date("m/d/Y", strtotime(date( "Y-m-d",strtotime(date("Y-m-d") ))."+1 week" ));
        

        return view('pegawai_anda.profile',compact('model','id', 'real_id', 'ckp', 'month', 
            'year', 'start', 'end', 'start_rencana', 'end_rencana', 'penilaian_pimpinan'));
    }

    public function store_tim(Request $request){
        $data_ckp = (array)$request->ckps;
        $data_logbook = (array)$request->logbooks;
        $user_list = [];
        $month = $request->month;
        $year = $request->year;

        // print_r($data_ckp);die();

        foreach($data_ckp as $data){
            $model = \App\Ckp::find($data['id']);
            if($model!=null){
                $model->kecepatan = (int)$data['kecepatan'];
                $model->ketepatan = (int)$data['ketepatan'];
                $model->ketuntasan = (int)$data['ketuntasan'];
                if($model->penilaian_pimpinan!='' && $model->penilaian_pimpinan!=null && $model->penilaian_pimpinan!=0){
                    $total_tim = ((int)$data['kecepatan']+(int)$data['ketepatan']+(int)$data['ketuntasan'])/3;
                    $model->kualitas = ((int)$total_tim+(int)$model->penilaian_pimpinan)/2;
                }
                else{
                    $model->kualitas = ((int)$data['kecepatan']+(int)$data['ketepatan']+(int)$data['ketuntasan'])/3;
                }

                $model->save();

                if(!in_array($model->user_id, $user_list)){
                    $user_list[] = $model->user_id;
                }
            }

        }

        foreach($data_logbook as $data){
            $model = \App\LogBook::find($data['id']);
            if($model!=null){
                $model->status_penyelesaian = $data["status_penyelesaian"];
                $model->save();
            }
        }

        foreach($user_list as $data){
            $ckp_log = new \App\CkpLogBulanan();
            $ckp_log->triggerCkp($data, Auth::id(), $month, $year);
        }

        return response()->json([
            'success'=>'Sukses', 
        ]);
    }
}
