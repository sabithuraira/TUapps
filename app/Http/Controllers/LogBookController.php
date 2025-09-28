<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LogBookRequest;
use Maatwebsite\Excel\Facades\Excel;

class LogBookController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function downloadExcel($tanggal, $unit_kerja){
        return Excel::download(new \App\Exports\LogBookExport($tanggal, $unit_kerja), 'log_book.xlsx');
    }
    
    public function downloadExcelWfh(Request $request){
        $user_id = 'admin@email.com';
        // $tanggal = date('Y-m-d');
        $tanggal = '2020-04-04';
        $jenis = 1; //1 harian, 2 bulanan

        if(strlen($request->get('user_id'))>0)
            $user_id =  $request->get('user_id');
            
        if(strlen($request->get('jenis'))>0)
            $jenis =  $request->get('jenis');

        if(strlen($request->get('tanggal'))>0)
            $tanggal =  date("Y-m-d", strtotime($request->get('tanggal')));

        if($jenis==1){
            $name_file = "LapKinWFH-".$user_id.".xlsx";
            return Excel::download(new \App\Exports\LaporanWfhExport($tanggal, $user_id), $name_file);
        }
        else{
            $name_file = "LapKinWFHBulanan-".$user_id.".xlsx";
            return Excel::download(new \App\Exports\LaporanWfhBulananExport(date('m', strtotime($tanggal)),date('Y', strtotime($tanggal)),$user_id), $name_file);
        }

        // $model = new \App\LogBook;
        // $datas = $model->LogBookRekap($tanggal, $tanggal, $user_id);
        
        // $user = \App\User::where('email', '=', $user_id)->first();
        
        // return view('exports.laporan_wfh',[
        //     'datas' => $datas,
        //     'user'  => $user,
        //     'tanggal'   => $tanggal,
        // ]);
    }

    public function laporan_wfh(Request $request){
        $idnya = Auth::id();
        $model = \App\User::find($idnya);
        $tanggal = date('Y-m-d');
        $list_user = \App\User::where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('kdorg', 'asc')
            ->get();

        return view('log_book.laporan_wfh',compact('idnya', 'model', 'tanggal', 'list_user'));
    }
    
    public function dataLogBook(Request $request){
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
        $datas = $model->LogBookRekap($start, $end, $user_id);

        return response()->json(['success'=>'Sukses', 
            'datas'=>$datas,
        ]);
    }

    public function dataKomentar(Request $request){
        $id = 0;

        if(strlen($request->get('id'))>0)
            $id = $request->get('id');

        $data = \App\LogBook::find($id);
        $result = "";

        if($data!=null) $result = $data->catatan_approve;

        return response()->json(['success'=>'Sukses', 'result'=>$result]);
    }

    public function saveKomentar(Request $request){
        // print_r($request->get('id'));die();
        $data = \App\LogBook::find($request->get('id'));
        if($data!=null){
            $data->catatan_approve=$request->get('catatan_approve');
            $data->pimpinan_by = Auth::user()->email;
            $data->save();
        }
        
        return response()->json(['success'=>'Sukses']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $datas=array();

        $start = date("m/d/Y", strtotime(date( "Y-m-d",strtotime(date("Y-m-d") ))."-1 month" ));
        $end = date('m/d/Y');

        $model = new \App\LogBook;
        $pemberi_tugas = Auth::user()->pimpinan->nmjab;
        $list_pegawai = \App\UserModel::where([
                                ['id', '<>', 1],
                                ['kdkab', '=', Auth::user()->kdkab]
                            ])
                            ->orWhere([
                                ['kdesl', '=', 2]
                            ])
                            ->orWhere([
                                ['kdorg', '=', 92100],
                            ])
                            ->orderBy('kdorg', 'ASC')->get();

        $list_iki = \App\IkiMaster::where('nip', Auth::user()->nip_baru)
                            ->where('tahun', [date('Y'), (date('Y')-1)])->get();

        return view('log_book.index', compact('model', 
            'datas', 'start', 'end', 'pemberi_tugas', 
            'list_pegawai', 'list_iki'));
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

            return view('log_book.rekap_pegawai', compact('model', 'unit_kerja',
                'tanggal', 'datas'));
        }
        else{
            abort(403, 'Anda tidak berhak mengakses halaman ini');
        }
    }

    public function rekap_uker_perbulan(Request $request){
        $month = date('n');
        $year = date('Y');
        $uker = '00';

        if(strlen($request->get('month'))>0) $month = $request->get('month');
        if(strlen($request->get('year'))>0) $year = $request->get('year');
        if(strlen($request->get('uker'))>0) $uker = $request->get('uker');

        $model = new \App\LogBook;
        $datas = $model->RekapUkerPerBulan($uker, $month, $year);

        return view('log_book.rekap_uker_perbulan', compact('model', 'uker',
            'month', 'year', 'datas'));
    }
    

    public function send_to_ckp(Request $request){
        if($request->form_id_data!=''){
            $model = \App\LogBook::find($request->form_id_data);

            $model_ckp = new \App\Ckp;
            $model_ckp->user_id = $model->user_id;
            $model_ckp->month   = date('n', strtotime($model->tanggal));
            $model_ckp->year    = date('Y', strtotime($model->tanggal));
            $model_ckp->type    =1;
            $model_ckp->jenis   =$request->jenis;
            $model_ckp->uraian  =$model->isi;
            
            $model_ckp->pemberi_tugas_id  =$model->pemberi_tugas_id;
            $model_ckp->pemberi_tugas_nama  =$model->pemberi_tugas;
            $model_ckp->pemberi_tugas_jabatan  =$model->pemberi_tugas_jabatan;

            if($model->satuan==null || strlen($model->satuan)==0)
                $model_ckp->satuan = '';
            else
                $model_ckp->satuan  =$model->satuan;
                
            if($model->volume==null || strlen($model->volume)==0){
                $model_ckp->target_kuantitas = 0;
                $model_ckp->realisasi_kuantitas = 0;
            }
            else{
                $model_ckp->target_kuantitas  =$model->volume;
                $model_ckp->realisasi_kuantitas  =$model->volume;
            }

            $model_ckp->kualitas=0;
            
            $model_ckp->created_by=Auth::id();
            $model_ckp->updated_by=Auth::id();
            
            if($model_ckp->save()){
                $model->ckp_id=$model_ckp->id;
                $model->save();
            }

            return response()->json(['result'=>'Data berhasil dikirim ke CKP']);
        }
        else{
            return response()->json(['result'=>'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function destroy_logbook($id){
        $model = \App\LogBook::find($id);
        $model->delete();
        return response()->json(['success'=>'Sukses']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model = new \App\LogBook;
        $model->tanggal = date('Y-m-d');
        $item_waktu = \App\MasterTime::all();

        return view('log_book.create', compact('model', 'item_waktu'));
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
        // $model->waktu_mulai = date("H:i", strtotime($request->get('waktu_mulai')));
        // $model->waktu_selesai = date("H:i", strtotime($request->get('waktu_selesai')));
        
        $model->waktu_mulai = date("H:i");
        $model->waktu_selesai = date("H:i");

        $model->isi = $request->get('isi');
        $model->hasil = $request->get('hasil');
        $model->volume = $request->get('volume');
        $model->satuan = $request->get('satuan');
        $model->pemberi_tugas_id = $request->get('pemberi_tugas');
        $data_user = \App\UserModel::where('email', '=', $request->get("pemberi_tugas"))->first();
        $model->pemberi_tugas = $data_user->name;
        $model->pemberi_tugas_jabatan = $data_user->nmjab;

        $model->id_iki = $request->get('id_iki');
        $model->jumlah_jam = $request->get('jumlah_jam');
        $model->link_bukti_dukung = $request->get('link_bukti_dukung');

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

        return view('log_book.edit',compact('model','id', 'item_waktu'));
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
            return redirect('log_book/edit',$id)
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

        return redirect('/log_book')->with('success', 'Information has been updated');
    }

    public function show($id){
        $model = \App\LogBook::find($id);
        return view('log_book.show',compact('model','id'));
    }
    
    public function print($id){
        $model = \App\LogBook::find($id);
        return view('log_book.print',compact('model','id'));
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
        return redirect('log_book')->with('success','Information has been  deleted');
    }
}
