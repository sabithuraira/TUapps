<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $year = '';
        $unit_kerja = Auth::user()->kdkab;

        if(Auth::user()->kdkab=='00'){
            if(strlen($request->get('unit_kerja'))>0){
                $unit_kerja = $request->get('unit_kerja');
            }
        }
        
        $arr_where = [];
        $arr_where[] = ['kode_kab', '=', $unit_kerja];

        
        if(strlen($request->get('year'))>0){
            $year = $request->get('year');
            $arr_where[] = ['tahun', '=', $year];
        }

        $datas = \App\TimMaster::where($arr_where)
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('tim');
        $datas->appends($request->all());

        return view('tim.index', compact(
                'datas',
                'year',
                'unit_kerja',
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
        $model = new \App\TimMaster;
        $id = '';
        return view('tim.create', compact(
            'list_pegawai', 'model', 'id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $model = new \App\TimMaster;
        
        if($request->id!=0){
            $temp_model = \App\TimMaster::find($request->id);
            if($temp_model!=null)
                $model = $temp_model;
            else
                $model->created_by = Auth::id();
        }
        else{
            $model->created_by = Auth::id();
        }

        $model->nama_tim = $request->nama_tim;
        $model->tahun = $request->tahun;
        $model->nama_ketua_tim = "";
        $model->nik_ketua_tim = "";
        $model->jumlah_anggota = 0;
        $model->kode_prov = Auth::user()->kdprop;
        $model->kode_kab = Auth::user()->kdkab;
        $model->updated_by = Auth::id();

        if($model->save()){
            $participant = [];

            if($request->has('participant')){
                $participant = $request->participant;

                foreach($participant as $key=>$value){
                    if($value['nik_anggota']!=''){
                        $model_participant = new \App\TimAnggota;
            
                        if($value['id']!=0){
                            $temp_model_participant = \App\TimAnggota::find($value['id']);
                            if($temp_model_participant!=null)
                                $model_participant = $temp_model_participant;
                            else
                                $model_participant->created_by = Auth::id();
                        }
                        else{
                            $model_participant->created_by = Auth::id();
                        }
        
                        $model_participant->id_tim = $model->id;
                        $model_participant->nama_anggota = $value['nama_anggota'];
                        $model_participant->nik_anggota = $value['nik_anggota'];
                        $model_participant->is_active = 1;
                        $model_participant->status_keanggotaan = $value['status_keanggotaan'];
                        $model_participant->updated_by = Auth::id();
                        $model_participant->save();

                        if($value['status_keanggotaan']=="1"){
                            $model->nama_ketua_tim = $value['nama_anggota'];
                            $model->nik_ketua_tim = $value['nik_anggota'];
                            $model->save();
                        }
                    }
                }

                $model->jumlah_anggota = count($participant);
                $model->save();
            }
            
            return response()->json(['result'=>'success']);
        }
        else{
            return response()->json(['result'=>'error']);
        }
    }

    public function anda(Request $request){
        $list_tim = \App\TimParticipant::where('user_id', '=', Auth::id())->paginate();
        
        return view('tim.anda', compact(
            'list_tim'
        ));
    }

    public function storeLapor(Request $request){
        if($request->id!=0){
            $model = \App\TimParticipant::find($request->id);
            if($model!=null){
                $model->jumlah_lapor = $request->jumlah_lapor;
                $model->tanggal_last_lapor = $request->tanggal_last_lapor;
                if($model->save()){
                    return response()->json(['result'=>'success']);
                }
            }
        }
        
        return response()->json(['result'=>'error']);
    }

    public function rekap(Request $request){
        $idnya = Auth::id();
        $model = \App\UserModel::find($idnya);
        $list_user = \App\UserModel::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('kdorg', 'asc')
            ->get();
        $list_fungsi = \App\UnitKerja4::where('is_kabupaten', '=', 1)->get();
            
        $unit_kerja = Auth::user()->kdkab;
        $month = date('m');
        $year = date('Y');

        return view('tim.rekap', compact(
            'list_user', 'unit_kerja', 'month', 'year', 'model', 'list_fungsi'
        ));
    }

    public function dataRekap(Request $request){
        $datas=array();
        $user = Auth::user();
        $user_id =  Auth::user()->id;
        $month = '';
        $year = '';

        if(strlen($request->get('user_id'))>0)
            $user_id = $request->get('user_id');
            
        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
            
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        $model = new \App\Tim;
        $datas = $model->Rekap($month, $year, $user_id);
        
        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id){
        $real_id = Crypt::decrypt($id);
        $model = \App\TimMaster::find($real_id);
        $participant = \App\TimAnggota::where('id_tim', '=', $real_id)->get();
        
        return response()->json(['form'=>$model, 'participant'=> $participant]);
    }

    public function show($id){
        $real_id = Crypt::decrypt($id);
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = \App\Tim::find($real_id);
        $list_fungsi = \App\UnitKerja4::where('is_kabupaten', '=', 1)->get();
        return view('tim.show', compact(   
            'list_pegawai', 'model', 'id', 'list_fungsi'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $real_id = Crypt::decrypt($id);
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = \App\TimMaster::find($real_id);
        return view('tim.create', compact(   
            'list_pegawai', 'model', 'id'
        ));
    }

    public function progres($id){
        $real_id = Crypt::decrypt($id);
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = \App\Tim::find($real_id);
        return view('tim.progres', compact(   
            'list_pegawai', 'model', 'id'
        ));
    }

    public function store_progres(Request $request, $id){
        $real_id = Crypt::decrypt($id);
        $model = \App\Tim::find($real_id);
        
        $participant = [];
        if($request->has('participant')){
            $participant = $request->participant;

            $is_complete = 1;
            foreach($participant as $key=>$value){
                if($value['id']!=0 || $value['id']!=''){
                    $model_participant = \App\TimParticipant::find($value['id']);
                    if($model_participant!=null){
                        $model_participant->jumlah_selesai =  $value['jumlah_selesai'];
                        if(strlen($value['tanggal_last_progress'])>0)
                            $model_participant->tanggal_last_progress =  date('Y-m-d', strtotime($value['tanggal_last_progress']));
                        $model_participant->save();
                    }
                }
                
                if($model_participant->jumlah_target>$model_participant->jumlah_selesai) $is_complete = 0;
            }

            if($is_complete==1){
                $model->status = 1;
                $model->save();
            }
        }
        
        return response()->json(['result'=>'success']);
    }

    public function user_role(Request $request){
        $keyword = $request->get('search');
        $datas = \App\User::where('name', 'LIKE', '%' . $keyword . '%')
            ->where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)
            ->paginate();

        $datas->withPath('user_role');
        $datas->appends($request->all());
        return view('tim.user_role',compact('datas', 'keyword'));
    }

    public function user_role_edit($id){
        
        $model = \App\User::find($id);
        $all_roles = Role::where('name', '=', 'pemberi_tugas')->get();
        return view('tim.user_role_edit',compact('model','id',
            'all_roles'));
    }

    public function user_role_update(Request $request, $id)
    {
        $model = \App\User::find($id);
        // $model->syncRoles($request['optrole']);
        if(isset($request['optrole'])){
            $model->assignRole("pemberi_tugas");
        }
        else{
            $model->removeRole("pemberi_tugas");
        }
        return redirect('tim/user_role');
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

    public function destroy_participant($id)
    {
        $model = \App\TimAnggota::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }
}
