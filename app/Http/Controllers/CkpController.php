<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dataCkp(Request $request){
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
        $datas = $model->CkpBulanan($type, $month, $year);

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
        $datas = $model->CkpBulanan($type, $month, $year);

        return view('ckp.index', compact('model', 'month', 
            'year', 'type', 'datas'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas=array();
        $month = date('m');
        $year = date('Y');
        $type = 1;
        $total_utama = 1;
        $total_tambahan = 1;

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
        $datas = $model->CkpBulanan($type, $month, $year);

        foreach($datas['utama'] as $data){

        }
        
        foreach($datas['tambahan'] as $data){
            
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
        
        // return redirect('pengangkutan_sampah')->with('success', 'Information has been added');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
