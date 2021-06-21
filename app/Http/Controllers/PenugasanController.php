<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PenugasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $month = '';
        $year = '';
        $ditugaskan_oleh = '';
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
        
        if(strlen($request->get('ditugaskan_oleh'))>0){
            $ditugaskan_oleh = $request->get('ditugaskan_oleh');
            $arr_where[] = ['ditugaskan_oleh_fungsi', '=', $ditugaskan_oleh];
        }

        $datas = \App\Penugasan::where($arr_where)
            ->orderBy('id', 'desc')
            ->paginate();

        $datas->withPath('penugasan');
        $datas->appends($request->all());
        
        $list_fungsi = \App\UnitKerja4::where('is_kabupaten', '=', 1)->get();

        return view('penugasan.index', compact(
                'datas',
                'ditugaskan_oleh',
                'month',
                'year',
                'unit_kerja',
                'list_fungsi'
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
        $list_fungsi = \App\UnitKerja4::where('is_kabupaten', '=', 1)->get();
        $model = new \App\Penugasan;
        $id = '';
        return view('penugasan.create', compact(
            'list_pegawai', 'model', 'id', 'list_fungsi'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $model = new \App\Penugasan;
        
        if($request->id!=0){
            $temp_model = \App\Penugasan::find($request->id);
            if($temp_model!=null)
                $model = $temp_model;
            else
                $model->created_by = Auth::id();
        }
        else{
            $model->created_by = Auth::id();
        }

        $model->isi = $request->isi;
        $model->ditugaskan_oleh_fungsi = $request->ditugaskan_oleh_fungsi;
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
                        $model_participant->keterangan = $value['keterangan'];
                        $model_participant->jumlah_target = $value['jumlah_target'];
                        $model_participant->jumlah_selesai =  0;
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

    public function anda(Request $request){
        $list_penugasan = \App\PenugasanParticipant::where('user_id', '=', Auth::id())->paginate();
        
        return view('penugasan.anda', compact(
            'list_penugasan'
        ));
    }

    public function storeLapor(Request $request){
        if($request->id!=0){
            $model = \App\PenugasanParticipant::find($request->id);
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

        return view('penugasan.rekap', compact(
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
            
        $model = new \App\Penugasan;
        $datas = $model->Rekap($month, $year, $user_id);
        
        return response()->json(['success'=>'Sukses', 'datas'=>$datas]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $real_id = Crypt::decrypt($id);
        $model = \App\Penugasan::find($real_id);
        $participant = \App\PenugasanParticipant::where('penugasan_id', '=', $real_id)->get();
        
        return response()->json(['form'=>$model, 'participant'=> $participant]);
    }

    public function show($id){
        $real_id = Crypt::decrypt($id);
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = \App\Penugasan::find($real_id);
        $list_fungsi = \App\UnitKerja4::where('is_kabupaten', '=', 1)->get();
        return view('penugasan.show', compact(   
            'list_pegawai', 'model', 'id', 'list_fungsi'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $real_id = Crypt::decrypt($id);
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = \App\Penugasan::find($real_id);
        $list_fungsi = \App\UnitKerja4::where('is_kabupaten', '=', 1)->get();
        return view('penugasan.create', compact(   
            'list_pegawai', 'model', 'id', 'list_fungsi'
        ));
    }

    public function progres($id){
        $real_id = Crypt::decrypt($id);
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $model = \App\Penugasan::find($real_id);
        return view('penugasan.progres', compact(   
            'list_pegawai', 'model', 'id'
        ));
    }

    public function store_progres(Request $request, $id){
        $real_id = Crypt::decrypt($id);
        $model = \App\Penugasan::find($real_id);
        
        $participant = [];
        if($request->has('participant')){
            $participant = $request->participant;

            $is_complete = 1;
            foreach($participant as $key=>$value){
                if($value['id']!=0 || $value['id']!=''){
                    $model_participant = \App\PenugasanParticipant::find($value['id']);
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
        return view('penugasan.user_role',compact('datas', 'keyword'));
    }

    public function user_role_edit($id){
        
        $model = \App\User::find($id);
        $all_roles = Role::where('name', '=', 'pemberi_tugas')->get();
        return view('penugasan.user_role_edit',compact('model','id',
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
        return redirect('penugasan/user_role');
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
        $model = \App\PenugasanParticipant::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }
}
