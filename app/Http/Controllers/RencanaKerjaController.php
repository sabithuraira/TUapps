<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LogBookRequest;
use Maatwebsite\Excel\Facades\Excel;

class RencanaKerjaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function dataRencanaKerja(Request $request){
        $datas=array();
        $all_dates = array();
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        
        $user = Auth::user();
        $user_id =  Auth::user()->email;

        if(strlen($request->get('start'))>0)
            $start =  date("Y-m-d", strtotime($request->get('start')));

        if(strlen($request->get('end'))>0)
            $end =  date("Y-m-d", strtotime($request->get('end')));

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');

        $model = new \App\LogBook;
        $datas = $model->RencanaKerjaRekap($start, $end, $user_id);

        return response()->json(['success'=>'Sukses', 
            'datas'=>$datas,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $datas=array();

        $start = date('m/d/Y');
        $end = date("m/d/Y", strtotime(date( "Y-m-d",strtotime(date("Y-m-d") ))."+1 week" ));
        
        $model = new \App\LogBook;
        $pemberi_tugas = Auth::user()->pimpinan->nmjab;
        $list_pegawai = \App\UserModel::where('id', '<>', 1)
                            ->where('kdkab', '=', Auth::user()->kdkab)->get();

        return view('rencana_kerja.index', compact('model', 
            'datas', 'start', 'end', 'pemberi_tugas', 'list_pegawai'));
    }

    public function rekap_pegawai(Request $request){
        if(strlen(Auth::user()->kdesl)>0 || Auth::user()->hasRole('superadmin')  || Auth::user()->hasRole('binagram')){
            $tanggal = date('Y-m-d');
            $unit_kerja = Auth::user()->kdkab;

            if(strlen($request->get('tanggal'))>0){
                $tanggal=date("Y-m-d", strtotime($request->get('tanggal')));
            }
            
            if(strlen($request->get('unit_kerja'))>0){
                $unit_kerja= $request->get('unit_kerja');
            }

            $model = new \App\LogBook;
            $datas = $model->RekapPerUnitKerjaPerHari($unit_kerja, $tanggal);

            return view('rencana_kerja.rekap_pegawai', compact('model', 'unit_kerja',
                'tanggal', 'datas'));
        }
        else{
            abort(403, 'Anda tidak berhak mengakses halaman ini');
        }
    }

    public function send_to_logbook(Request $request){
        if($request->form_id_data!=''){
            $model = \App\LogBook::find($request->form_id_data);
            $model->is_rencana = 0;
            $model->status_rencana = 1;
            $model->save();

            return response()->json(['result'=>'Data berhasil dikirim ke CKP']);
        }
        else{
            return response()->json(['result'=>'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function destroy_rencana_kerja($id){
        $model = \App\LogBook::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $model = \App\LogBook::find($request->get("id"));
        if($model==null){
            $model = new \App\LogBook;
            $model->user_id= Auth::user()->email;
            $model->created_by=Auth::id();
        }

        $model->tanggal=date("Y-m-d", strtotime($request->get('tanggal')));
        $model->waktu_mulai = date("H:i", strtotime($request->get('waktu_mulai')));
        $model->waktu_selesai = date("H:i", strtotime($request->get('waktu_selesai')));
        $model->isi = $request->get('isi');
        $model->hasil = $request->get('hasil');
        $model->volume = $request->get('volume');
        $model->satuan = $request->get('satuan');
        $model->pemberi_tugas_id = $request->get('pemberi_tugas');
        $data_user = \App\UserModel::find($request->get("pemberi_tugas"));
        $model->pemberi_tugas = $data_user->name;
        $model->pemberi_tugas_jabatan = $data_user->nmjab;
        $model->is_rencana = 1;
        $model->status_rencana = 0;
        $model->updated_by=Auth::id();
        $model->save();
        
        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $model = \App\LogBook::find($id);
        $item_waktu = \App\MasterTime::all();

        return view('rencana_kerja.edit',compact('model','id', 'item_waktu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LogBookRequest $request, $id){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('rencana_kerja/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= \App\LogBook::find($id);
        $model->tanggal= date("Y-m-d", strtotime($request->get('tanggal')));
        $model->isi = $request->get('isi');
        
        // if($request->get('flag_ckp')!=''){
            $model->flag_ckp =  $request->get('flag_ckp');
        // }
        
        $model->waktu=$request->get('waktu');
        $model->updated_by=Auth::id();
        $model->save();

        return redirect('/rencana_kerja')->with('success', 'Information has been updated');
    }

    public function show($id){
        $model = \App\LogBook::find($id);
        return view('rencana_kerja.show',compact('model','id'));
    }
    
    public function print($id){
        $model = \App\LogBook::find($id);
        return view('rencana_kerja.print',compact('model','id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\LogBook::find($id);
        $model->delete();
        return redirect('rencana_kerja')->with('success','Information has been  deleted');
    }
}
