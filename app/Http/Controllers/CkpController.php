<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CkpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function print($id){
    //     $model= \App\Sppk::find($id);

    //     $pdf = PDF::loadView('sppk.print', compact('model', 
    //         'id'))
    //         ->setPaper('a4');
    //         // ->setOrientation('portrait');
    //     return $pdf->download('pdfview.pdf');

    //     // return view('sppk.print',compact('model','id'));
    // }

    
    public function aeik($month, $year){
        
        $all_user = \App\UserModel::all();

        foreach($all_user as $value){
            $ckp_log = new \App\CkpLogBulanan();
            $ckp_log->triggerCkp($value->email, $value->id, $month, $year);
        }
    }
    
    public function dataCkp(Request $request){
        $datas=array();
        $user = Auth::user();
        $user_id =  Auth::user()->email;
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');

        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
        
        $model = new \App\Ckp;
        $datas = $model->CkpBulanan(1, $month, $year, $user_id);

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }

    public function dataProfile(Request $request){
        $datas=array();
        $user_id =  Auth::user()->email;

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');
            
        $model = \App\UserModel::where('email', '=', $user_id)->first();

        return response()->json(['success'=>'Sukses', 'model'=>$model]);
    }
    
    public function dataUnitKerja(Request $request){
        $datas=array();
        $unit_kerja = Auth::user()->kdkab;

        if(strlen($request->get('unit_kerja'))>0)
            $unit_kerja = $request->get('unit_kerja');
            
        $list_user = \App\UserModel::where('kdkab', '=', $unit_kerja)
                        ->orderBy('kdorg', 'asc')->get();

        return response()->json(['success'=>'Sukses', 'list_user'=>$list_user]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas=array();
        $month = date('m');
        $year = date('Y');
        $type = 1;

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
        
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        if(strlen($request->get('type'))>0)
            $type = $request->get('type');

        $model = new \App\Ckp;

        return view('ckp.index', compact('model', 'month', 
            'year', 'type'));
    }

    public function pemantau_ckp(Request $request)
    {
        $idnya = Auth::id();
        $model = \App\UserModel::find($idnya);
        $unit_kerja = Auth::user()->kdkab;

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('kdorg', 'asc')
            ->get();

        $ckp = new \App\Ckp;

        $lb_datas=array();

        $start = date("m/d/Y", strtotime(date( "Y-m-d",strtotime(date("Y-m-d") ))."-1 month" ));
        $end = date('m/d/Y');

        return view('ckp.pemantau_ckp',compact('model','idnya', 'ckp', 'month', 
            'year', 'start', 'end', 'list_user', 'unit_kerja'));
    }

    public function rekap_ckp(Request $request)
    {
        $unit_kerja = Auth::user()->kdkab;
        $month = date('m');
        $year = date('Y');

        return view('ckp.rekap_ckp',compact('month', 
            'year', 'unit_kerja'));
    }

    public function data_rekap_ckp(Request $request)
    {
        $unit_kerja = Auth::user()->kdkab;

        $datas=array();
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('unit_kerja'))>0)
            $unit_kerja = $request->get('unit_kerja');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');

        if(strlen($request->get('year'))>0)
            $year = $request->get('year');

        $ckp_log = new \App\CkpLogBulanan;
        $datas = $ckp_log->RekapPerUnitKerjaPerBulan($unit_kerja, $month, $year);

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $month = date('m');
        $year = date('Y');

        $model = new \App\Ckp;
        $list_iki = \App\Iki::where('user_id', '=', Auth::user()->email)->get();
        
        return view('ckp.create', compact('month', 
            'year', 'model', 'list_iki'));
    }

    public function print(Request $request)
    {
        $user = Auth::user();
        $user_id =  Auth::user()->email;

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $type = 1;

        if(strlen($request->get('p_month'))>0)
            $month = $request->get('p_month');

        if(strlen($request->get('p_year'))>0)
            $year = $request->get('p_year');
            
        // if(strlen($request->get('p_type'))>0)
        $type = $_POST['action'];
            
        if(strlen($request->get('p_user'))>0){
            $user_id = $request->get('p_user');
            $user = \App\User::where('email', '=', $user_id)->first();
        }

        $model = new \App\Ckp;
        $datas = $model->CkpBulanan(1, $month, $year, $user_id);

        $monthLabel = config('app.months')[$month];
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $last_day_month  = date('t', mktime(0, 0, 0, $month, 10)); //date("t");
        $first_working_day = date('d F Y', strtotime("+0 weekday $monthName $year"));
        $last_working_day = date('d F Y', strtotime('last weekday '.date("F Y", strtotime('next month '.$monthName.' '.$year))));

        $pdf = PDF::loadView('ckp.print', compact('month', 
            'year', 'type', 'model', 'datas', 'user', 
            'monthName', 'monthLabel', 'last_day_month',
            'first_working_day', 'last_working_day'))
            ->setPaper('a4', 'landscape');
        
        $nama_file = 'CKP_';
        if($type==1)
            $nama_file .= 'T_';
        else
            $nama_file .= 'R_';

        $nama_file .= $month . '.pdf';

        return $pdf->download($nama_file);

        // return view('ckp.print', compact('month', 
        // 'year', 'type', 'model', 'datas', 'user', 
        // 'monthName', 'monthLabel', 'last_day_month',
        // 'first_working_day', 'last_working_day'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id =  Auth::user()->email;

        $datas=array();
        $month = date('m');
        $year = date('Y');
        $type = 1;
        $total_utama = 0;
        $total_tambahan = 0;

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
        
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        if(strlen($request->get('total_utama'))>0)
            $total_utama = $request->get('total_utama');
                        
        if(strlen($request->get('total_tambahan'))>0)
            $total_tambahan = $request->get('total_tambahan');
            
        $model = new \App\Ckp;
        $datas = $model->CkpBulanan($type, $month, $year, $user_id);

        foreach($datas['utama'] as $data){
            if(strlen($request->get('u_uraian'.$data->id))>0 && strlen($request->get('u_satuan'.$data->id))>0 && strlen($request->get('u_target_kuantitas'.$data->id))>0){
                
                $model_utama = \App\Ckp::find($data->id);
                $model_utama->uraian = $request->get('u_uraian'.$data->id);
                $model_utama->satuan = $request->get('u_satuan'.$data->id);
                $model_utama->target_kuantitas = $request->get('u_target_kuantitas'.$data->id);

                $model_utama->realisasi_kuantitas = $request->get('u_realisasi_kuantitas'.$data->id);
                // $model_utama->kualitas = $request->get('u_kualitas'.$data->id);

                $model_utama->kode_butir = $request->get('u_kode_butir'.$data->id);
                $model_utama->angka_kredit = $request->get('u_angka_kredit'.$data->id);
                $model_utama->keterangan = $request->get('u_keterangan'.$data->id);
                
                // $model_utama->kecepatan = $request->get('u_kecepatan'.$data->id);
                // $model_utama->ketepatan = $request->get('u_ketepatan'.$data->id);
                // $model_utama->ketuntasan = $request->get('u_ketuntasan'.$data->id);
                // $model_utama->penilaian_pimpinan = $request->get('u_penilaian_pimpinan'.$data->id);
                // $model_utama->catatan_koreksi = $request->get('u_catatan_koreksi'.$data->id);
                $model_utama->iki = $request->get('u_iki'.$data->id);

                $model_utama->save();
            }
        }
        
        foreach($datas['tambahan'] as $data){
            if(strlen($request->get('t_uraian'.$data->id))>0 && strlen($request->get('t_satuan'.$data->id))>0 && strlen($request->get('t_target_kuantitas'.$data->id))>0){
                
                $model_tambahan = \App\Ckp::find($data->id);
                $model_tambahan->uraian = $request->get('t_uraian'.$data->id);
                $model_tambahan->satuan = $request->get('t_satuan'.$data->id);
                $model_tambahan->target_kuantitas = $request->get('t_target_kuantitas'.$data->id);
                $model_tambahan->realisasi_kuantitas = $request->get('t_realisasi_kuantitas'.$data->id);
                // $model_tambahan->kualitas = $request->get('t_kualitas'.$data->id);
                $model_tambahan->kode_butir = $request->get('t_kode_butir'.$data->id);
                $model_tambahan->angka_kredit = $request->get('t_angka_kredit'.$data->id);
                $model_tambahan->keterangan = $request->get('t_keterangan'.$data->id);

                // $model_tambahan->kecepatan = $request->get('t_kecepatan'.$data->id);
                // $model_tambahan->ketepatan = $request->get('t_ketepatan'.$data->id);
                // $model_tambahan->ketuntasan = $request->get('t_ketuntasan'.$data->id);
                // $model_tambahan->penilaian_pimpinan = $request->get('t_penilaian_pimpinan'.$data->id);
                // $model_tambahan->catatan_koreksi = $request->get('t_catatan_koreksi'.$data->id);
                $model_tambahan->iki = $request->get('t_iki'.$data->id);

                $model_tambahan->save();
            }
        }

        for($i=1;$i<=$total_utama;++$i){
            if(strlen($request->get('u_uraianau'.$i))>0 && strlen($request->get('u_satuanau'.$i))>0 && strlen($request->get('u_target_kuantitasau'.$i))>0){
                $is_valid_by_type = true;
                
                if($is_valid_by_type){
                    $model_utama = new \App\Ckp;
                    
                    $model_utama->user_id =  Auth::user()->email;
                    $model_utama->month = $request->get('month');
                    $model_utama->year = $request->get('year');
                    $model_utama->type = 1;
                    $model_utama->jenis = 1;

                    $model_utama->uraian = $request->get('u_uraianau'.$i);
                    $model_utama->satuan = $request->get('u_satuanau'.$i);
                    $model_utama->target_kuantitas = $request->get('u_target_kuantitasau'.$i);

                    $model_utama->realisasi_kuantitas = $request->get('u_realisasi_kuantitasau'.$i);
                    // $model_utama->kualitas = $request->get('u_kualitasau'.$i);

                    $model_utama->kode_butir = $request->get('u_kode_butirau'.$i);
                    $model_utama->angka_kredit = $request->get('u_angka_kreditau'.$i);
                    $model_utama->keterangan = $request->get('u_keteranganau'.$i);

                    // $model_utama->kecepatan = $request->get('u_kecepatanau'.$i);
                    // $model_utama->ketepatan = $request->get('u_ketepatanau'.$i);
                    // $model_utama->ketuntasan = $request->get('u_ketuntasanau'.$i);
                    // $model_utama->penilaian_pimpinan = $request->get('u_penilaian_pimpinanau'.$i);
                    // $model_utama->catatan_koreksi = $request->get('u_catatan_koreksiau'.$i);
                    $model_utama->iki = $request->get('u_ikiau'.$i);

                    $model_utama->created_by=Auth::id();
                    $model_utama->updated_by=Auth::id();
                    $model_utama->save();
                }
            }
        }

        
        for($i=1;$i<=$total_tambahan;++$i){
            if(strlen($request->get('t_uraianat'.$i))>0 && strlen($request->get('t_satuanat'.$i))>0 && strlen($request->get('t_target_kuantitasat'.$i))>0){
                $is_valid_by_type = true;
                
                if($is_valid_by_type){
                    $model_tambahan = new \App\Ckp;
                    
                    $model_tambahan->user_id = Auth::user()->email;
                    $model_tambahan->month = $request->get('month');
                    $model_tambahan->year = $request->get('year');
                    $model_tambahan->type = 1;
                    $model_tambahan->jenis = 2;

                    $model_tambahan->uraian = $request->get('t_uraianat'.$i);
                    $model_tambahan->satuan = $request->get('t_satuanat'.$i);
                    $model_tambahan->target_kuantitas = $request->get('t_target_kuantitasat'.$i);
                    $model_tambahan->realisasi_kuantitas = $request->get('t_realisasi_kuantitasat'.$i);
                    // $model_tambahan->kualitas = $request->get('t_kualitasat'.$i);
                    
                    $model_tambahan->kode_butir = $request->get('t_kode_butirat'.$i);
                    $model_tambahan->angka_kredit = $request->get('t_angka_kreditat'.$i);
                    $model_tambahan->keterangan = $request->get('t_keteranganat'.$i);

                    // $model_tambahan->kecepatan = $request->get('t_kecepatanat'.$i);
                    // $model_tambahan->ketepatan = $request->get('t_ketepatanat'.$i);
                    // $model_tambahan->ketuntasan = $request->get('t_ketuntasanat'.$i);
                    // $model_tambahan->penilaian_pimpinan = $request->get('t_penilaian_pimpinanat'.$i);
                    // $model_tambahan->catatan_koreksi = $request->get('t_catatan_koreksiat'.$i);
                    $model_tambahan->iki = $request->get('t_ikiat'.$i);

                    $model_tambahan->created_by=Auth::id();
                    $model_tambahan->updated_by=Auth::id();
                    $model_tambahan->save();
                }
            }
        }

        
        $ckp_log = new \App\CkpLogBulanan();
        $ckp_log->triggerCkp(Auth::user()->email, Auth::id(), $request->get('month'), $request->get('year'));
        
        return redirect('/ckp')->with('success', 'Information has been added');
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\Ckp::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }
}
