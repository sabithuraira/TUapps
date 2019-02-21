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
    
    public function dataCkp(Request $request){
        $datas=array();
        $user = Auth::user();
        $user_id =  Auth::user()->email;
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
        $datas = $model->CkpBulanan($type, $month, $year, $user_id);

        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
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

        return view('ckp.create', compact('month', 
            'year', 'model'));
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
            
        if(strlen($request->get('p_type'))>0)
            $type = $request->get('p_type');
            
        if(strlen($request->get('p_user'))>0){
            $user_id = $request->get('p_user');
            $user = \App\User::where('email', '=', $user_id)->first();
        }
        

        $model = new \App\Ckp;
        $datas = $model->CkpBulanan($type, $month, $year, $user_id);

        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $last_day_month  = date('t', mktime(0, 0, 0, $month, 10)); //date("t");
        $first_working_day = date('d F Y', strtotime("+0 weekday $monthName $year"));
        $last_working_day = date('d F Y', strtotime('last weekday '.date("F Y", strtotime('next month '.$monthName.' '.$year))));

        $pdf = PDF::loadView('ckp.print', compact('month', 
            'year', 'type', 'model', 'datas', 'user', 
            'monthName', 'last_day_month',
            'first_working_day', 'last_working_day'))
            ->setPaper('a4', 'landscape');
        

        return $pdf->download('print.pdf');

        // print_r($datas);die();

        // return view('ckp.print', compact('month', 
        //     'year', 'type', 'model', 'datas', 'user', 
        //     'monthName', 'last_day_month',
        //     'first_working_day', 'last_working_day'));
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
            
        if(strlen($request->get('type'))>0)
            $type = $request->get('type');
            
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
                $model_utama->kualitas = $request->get('u_kualitas'.$data->id);

                $model_utama->kode_butir = $request->get('u_kode_butir'.$data->id);
                $model_utama->angka_kredit = $request->get('u_angka_kredit'.$data->id);
                $model_utama->keterangan = $request->get('u_kredit'.$data->id);
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
                $model_tambahan->kualitas = $request->get('t_kualitas'.$data->id);
                $model_tambahan->kode_butir = $request->get('t_kode_butir'.$data->id);
                $model_tambahan->angka_kredit = $request->get('t_angka_kredit'.$data->id);
                $model_tambahan->keterangan = $request->get('t_kredit'.$data->id);
                $model_tambahan->save();
            }
        }

        for($i=1;$i<=$total_utama;++$i){
            if(strlen($request->get('u_uraianau'.$i))>0 && strlen($request->get('u_satuanau'.$i))>0 && strlen($request->get('u_target_kuantitasau'.$i))>0){
                $is_valid_by_type = true;

                if($request->get('type')==2){
                    if(strlen($request->get('u_realisasi_kuantitasau'.$i))==0 || strlen($request->get('u_kualitasau'.$i))==0){
                        $is_valid_by_type = false;        
                    }
                } 
                
                if($is_valid_by_type){
                    $model_utama = new \App\Ckp;
                    
                    $model_utama->user_id =  Auth::user()->email;
                    $model_utama->month = $request->get('month');
                    $model_utama->year = $request->get('year');
                    $model_utama->type = $request->get('type');
                    $model_utama->jenis = 1;

                    $model_utama->uraian = $request->get('u_uraianau'.$i);
                    $model_utama->satuan = $request->get('u_satuanau'.$i);
                    $model_utama->target_kuantitas = $request->get('u_target_kuantitasau'.$i);

                    if($request->get('type')==2){
                        $model_utama->realisasi_kuantitas = $request->get('u_realisasi_kuantitasau'.$i);
                        $model_utama->kualitas = $request->get('u_kualitasau'.$i);
                    }

                    $model_utama->kode_butir = $request->get('u_kode_butirau'.$i);
                    $model_utama->angka_kredit = $request->get('u_angka_kreditau'.$i);
                    $model_utama->keterangan = $request->get('u_kreditau'.$i);

                    $model_utama->created_by=Auth::id();
                    $model_utama->updated_by=Auth::id();
                    $model_utama->save();
                }
            }
        }

        
        for($i=1;$i<=$total_tambahan;++$i){
            if(strlen($request->get('t_uraianat'.$i))>0 && strlen($request->get('t_satuanat'.$i))>0 && strlen($request->get('t_target_kuantitasat'.$i))>0){
                $is_valid_by_type = true;

                if($request->get('type')==2){
                    if(strlen($request->get('t_realisasi_kuantitasat'.$i))==0 || strlen($request->get('t_kualitasat'.$i))==0){
                        $is_valid_by_type = false;        
                    }
                } 
                
                if($is_valid_by_type){
                    $model_tambahan = new \App\Ckp;
                    
                    $model_tambahan->user_id = Auth::user()->email;
                    $model_tambahan->month = $request->get('month');
                    $model_tambahan->year = $request->get('year');
                    $model_tambahan->type = $request->get('type');
                    $model_tambahan->jenis = 2;

                    $model_tambahan->uraian = $request->get('t_uraianat'.$i);
                    $model_tambahan->satuan = $request->get('t_satuanat'.$i);
                    $model_tambahan->target_kuantitas = $request->get('t_target_kuantitasat'.$i);
                    
                    if($request->get('type')==2){
                        $model_tambahan->realisasi_kuantitas = $request->get('t_realisasi_kuantitasat'.$i);
                        $model_tambahan->kualitas = $request->get('t_kualitasat'.$i);
                    }
                        
                    $model_tambahan->kode_butir = $request->get('t_kode_butirat'.$i);
                    $model_tambahan->angka_kredit = $request->get('t_angka_kreditat'.$i);
                    $model_tambahan->keterangan = $request->get('t_kreditat'.$i);

                    $model_tambahan->created_by=Auth::id();
                    $model_tambahan->updated_by=Auth::id();
                    $model_tambahan->save();
                }
            }
        }
        
        // $rekanans = \App\RekananSampah::where('is_active', '=', '1')->get();

        // for($d=1; $d<=31; $d++)
        // {
        //     $time=mktime(12, 0, 0, $month, $d, $year);          
        //     if (date('m', $time)==$month)
        //     {
        //         // $datas[]=array('label'=> date('D, d-M', $time), 'd'=>$d);
        //         foreach($rekanans as $rekanan){
        //             $j_name =  'jumlah'.$rekanan->id;
        //             $r_name =  'rate'.$rekanan->id;

        //             if($request->has($j_name.'-'.$d) && $request->has($r_name.'-'.$d)){
        //                 if(strlen($request->get($j_name.'-'.$d))>0 && strlen($request->get($r_name.'-'.$d))>0)
        //                 {
        //                     $tanggal = $year.'-'.$month.'-'.$d;
        //                     $model = \App\PengangkutanSampah::where([
        //                         ['rekanan_id', '=', $rekanan->id],
        //                         ['tanggal', '=', DB::raw("'$tanggal'")],
        //                     ])
        //                     ->first();
            
        //                     if($model === null){
        //                         $model= new \App\PengangkutanSampah;
        //                         $model->rekanan_id=$rekanan->id;
        //                         $model->tanggal=$tanggal;
        //                         $model->created_by=Auth::id();
        //                         $model->company_id=Auth::user()->company_id;
        //                     }
        //                     $model->jumlah = $request->get($j_name.'-'.$d);
        //                     $model->rate = $request->get($r_name.'-'.$d);
        //                     $model->updated_by=Auth::id();
        //                     $model->save();
        //                 }
        //             }
        //             // $month = $request->get('month');
        //         }
        //     }
        // }
        
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
