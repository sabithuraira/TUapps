<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PenugasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');
        $month = '';
        $year = '';
        $unit_kerja = Auth::user()->kdprop.Auth::user()->kdkab;

        if(Auth::user()->kdkab=='00'){
            if(strlen($request->get('unit_kerja'))>0){
                $unit_kerja = Auth::user()->kdprop.$request->get('unit_kerja');
            }
        }
        
        $arr_where = [];
        $arr_where[] = ['unit_kerja', '=', $unit_kerja];

        if(strlen($request->get('month'))>0){
            $month = $request->get('month');
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $month];
        }
        
        if(strlen($request->get('year'))>0){
            $year = $request->get('year');
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $year];
        }

        $datas = \App\Penugasan::where($arr_where)
            ->where(
                (function ($query) use ($keyword) {
                    $query->where('isi', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('keterangan', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('satuan', 'LIKE', '%' . $keyword . '%');
                })
            )
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('penugasan');
        $datas->appends($request->all());

        return view('penugasan.index', compact(
                'datas',
                'keyword',
                'month',
                'year',
                'unit_kerja'
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = new \App\Penugasan;
        return view('penugasan.create', compact(
            'list_pegawai', 'model'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new \App\Penugasan;
        
        if($request->id!=0){
            $temp_model = \App\Penugasan::find($request->id);
            if($temp_model!=null){
                $model = $temp_model;
            }
            else{
                $model->created_by = Auth::id();
            }
        }
        else{
            $model->created_by = Auth::id();
        }

        $model->isi = $request->isi;
        $model->keterangan = $request->keterangan;
        $model->tanggal_mulai =  date('Y-m-d', strtotime($request->tanggal_mulai));
        $model->tanggal_selesai =  date('Y-m-d', strtotime($request->tanggal_selesai));
        $model->satuan = $request->satuan;
        $model->jenis_periode = $request->jenis_periode;
        $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
        $model->updated_by = Auth::id();

        if($model->save()){
            $participant = [];

            if($request->has('participant')){
                $participant = $request->participant;

                foreach($participant as $key=>$value){
                    if($value['jumlah_target']!='' && $value['user_id']!=''){
                        $model_participant = new \App\PenugasanParticipant;
            
                        if($value['id']!=0){
                            $temp_model_participant = \App\PenugasanParticipant::find($value['id']);
                            if($temp_model_participant!=null)
                                $model_participant = $temp_model_participant;
                            else
                                $model_participant->created_by = Auth::id();
                        }
                        else{
                            $model_participant->created_by = Auth::id();
                        }
        
                        $model_participant->penugasan_id = $model->id;
                        $model_participant->user_id = $value['user_id'];
                        $model_participant->user_nip_lama = $value['user_nip_lama'];
                        $model_participant->user_nip_baru = $value['user_nip_baru'];
                        $model_participant->user_nama = $value['user_nama'];
                        $model_participant->user_jabatan = $value['user_jabatan'];
                        $model_participant->jumlah_target = $value['jumlah_target'];
                        $model_participant->jumlah_selesai = 0;
                        $model_participant->nilai_waktu = 0;
                        $model_participant->nilai_penyelesaian = 0;
                        $model_participant->unit_kerja = $model->unit_kerja;
                        $model_participant->updated_by = Auth::id();
                        $model_participant->save();
                    }
                }
            }
            
            return response()->json(['result'=>'success']);
        }
        else{
            return response()->json(['result'=>'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('penugasan.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('penugasan.edit');
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
