<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MeetingRequest;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\Meeting::where('judul', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('meeting');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('meeting.list', array('datas' => $datas))->render());
        }

        return view('meeting.index',compact('datas', 'keyword'));
    }
    
    public function kalender(Request $request)
    {
        $keyword = $request->get('search');
        $cur_date = date('Y-m-d');
        $datas = \App\Meeting::whereYear('waktu_mulai','=',date('Y'))
            ->whereYear('waktu_selesai', '=', date('Y'), 'or')
            ->orderBy('waktu_mulai')
            ->get();

        return view('meeting.kalender',compact('datas', 'keyword',
            'cur_date'));
    }

    public function loadPegawai(Request $request){
        $keyword = '';
        $kd_kab = Auth::user()->kdkab;

        if(strlen($request->get('keyword'))>0)
            $keyword = $request->get('keyword');
            
        if(strlen($request->get('kd_kab'))>0)
            $kd_kab = $request->get('kd_kab');

        $model = \App\UserModel::where('kdkab', '=', $kd_kab)->get();

        if(strlen($keyword)>0){
            $model = \App\UserModel::where('kdkab', '=', $kd_kab)
                ->where('name', 'LIKE', '%' . $keyword . '%')->get();
        }
        
        return response()->json(['success'=>'1', 'datas'=>$model]);
    }

    public function data_peserta(Request $request){
        $idnya = '';
        if(strlen($request->get('idnya'))>0) $idnya = $request->get('idnya');
        $datas = \App\MeetingPeserta::where('meeting_id', '=', $idnya)->get();

        return response()->json(['datas'=>$datas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\Meeting;
        $model->waktu_mulai = date('d-m-Y h:i');
        $model->waktu_selesai = date('d-m-Y h:i');
        $kd_kab = Auth::user()->kdkab;
        $model->is_secret = 0;
        
        $list_peserta = \App\UserModel::all();

        // $list_peserta = \App\User::select('name','email', 'nip_baru', 'nmjab', 'kdkab')
        //     ->where('kdkab', '=', '00')->get();

        return view('meeting.create',compact('model', 'kd_kab', 'list_peserta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('meeting/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $total_peserta = $request->get('total_peserta');

        $model= new \App\Meeting;
        
        $model->kdprop =Auth::user()->kdprop;
        $model->kdkab =Auth::user()->kdkab;
        $model->judul =$request->get('judul');
        $model->deskripsi =$request->get('deskripsi');
        $model->notulen =$request->get('notulen');
        $model->keterangan =$request->get('keterangan');
        $model->is_secret =$request->get('is_secret');
        $model->waktu_mulai = date('Y-m-d H:i:s', strtotime($request->get('waktu_mulai').':00'));
        $model->waktu_selesai = date('Y-m-d H:i:s', strtotime($request->get('waktu_selesai').':00'));

        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();

        if($model->save()){
            for($i=1;$i<=$total_peserta;++$i){
                if(strlen($request->get('p_emailau'.$i))>0 && strlen($request->get('p_nip_baruau'.$i))>0){
                    $model_peserta = new \App\MeetingPeserta;
                    $model_peserta->meeting_id =  $model->id;
                    $model_peserta->pegawai_id =  $request->get('p_emailau'.$i);
                    $model_peserta->keterangan =  '';
                    $model_peserta->kehadiran =  1;
                    $model_peserta->created_by =  Auth::id();
                    $model_peserta->updated_by =  Auth::id();
                    $model_peserta->nip_baru =  $request->get('p_nip_baruau'.$i);
                    $model_peserta->name =  $request->get('p_nameau'.$i);
                    $model_peserta->nmjab =  $request->get('p_nmjabau'.$i);
                    $model_peserta->save();
                }
            }
        }
        
        return redirect('meeting')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {     
        $model = \App\Meeting::find($id);
        if($model->is_secret==1 && !$model->isPeserta){
            abort(403, 'Anda tidak berhak mengakses halaman ini');
        }
        else{
            $kd_kab = Auth::user()->kdkab;
            $rincian_peserta = \App\MeetingPeserta::where('meeting_id', '=', $id)->get();
            return view('meeting.detail',compact('model','id', 'kd_kab', 'rincian_peserta'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = \App\Meeting::find($id);
        if($model->created_by==Auth::id()){
            $kd_kab = Auth::user()->kdkab;
            return view('meeting.edit',compact('model','id', 'kd_kab'));
        }
        else{
            abort(403, 'Anda tidak berhak mengakses halaman ini');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('meeting/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $total_peserta = $request->get('total_peserta');
        
        $model= \App\Meeting::find($id);
        $model->judul =$request->get('judul');
        $model->deskripsi =$request->get('deskripsi');
        $model->notulen =$request->get('notulen');
        $model->keterangan =$request->get('keterangan');
        $model->waktu_mulai = date('Y-m-d H:i:s', strtotime($request->get('waktu_mulai').':00'));
        $model->waktu_selesai = date('Y-m-d H:i:s', strtotime($request->get('waktu_selesai').':00'));
        $model->updated_by=Auth::id();

        if($model->save()){
            $datas = \App\MeetingPeserta::where('meeting_id', '=', $model->id)->get();
            foreach($datas as $data){
                if(strlen($request->get('p_keterangan'.$data->id))>0 && strlen($request->get('p_kehadiran'.$data->id))>0){
                    $model_peserta = \App\MeetingPeserta::find($data->id);
                    $model_peserta->keterangan =  '';
                    $model_peserta->kehadiran =  1;
                    $model_peserta->save();
                }
            }

            for($i=1;$i<=$total_peserta;++$i){
                if(strlen($request->get('p_emailau'.$i))>0 && strlen($request->get('p_nip_baruau'.$i))>0){
                    $model_peserta = new \App\MeetingPeserta;
                    $model_peserta->meeting_id =  $model->id;
                    $model_peserta->pegawai_id =  $request->get('p_emailau'.$i);
                    $model_peserta->keterangan =  '';
                    $model_peserta->kehadiran =  1;
                    $model_peserta->created_by =  Auth::id();
                    $model_peserta->updated_by =  Auth::id();
                    $model_peserta->nip_baru =  $request->get('p_nip_baruau'.$i);
                    $model_peserta->name =  $request->get('p_nameau'.$i);
                    $model_peserta->nmjab =  $request->get('p_nmjabau'.$i);
                    $model_peserta->save();
                }
            }
        }

        return redirect('meeting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\Meeting::find($id);
        if($model->created_by==Auth::id()){
            $rincian_peserta = \App\MeetingPeserta::where('meeting_id', '=', $id)->delete();
            $model = \App\Meeting::find($id);
            $model->delete();
            return redirect('meeting')->with('success','Information has been  deleted');
        }
        else{
            abort(403, 'Anda tidak berhak mengakses halaman ini');
        }
    }
    
    public function destroy_peserta($id)
    {
        $model = \App\MeetingPeserta::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }
}