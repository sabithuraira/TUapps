<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PokRevisiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PokImport;
use Illuminate\Support\Facades\Storage;
use Response;
use Illuminate\Support\Facades\File;

class PokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $tahun = date('Y');
        if(strlen($request->tahun)>0) $tahun = $request->tahun;

        $model = new \App\PokRincianAnggaran;
        $datas = $model->getDataAnggaran($tahun);
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))->where('kdkab', '=', Auth::user()->kdkab)->get();

        return view('pok.index', compact(
            'tahun', 'model', 'datas',
            'list_pegawai'
        ));
    }

    public function upload_pok(Request $request){
        $model = new \App\PokMataAnggaran();
        return view('pok.upload_pok',compact('model'));
    }

    public function import_pok(Request $request){
        // Excel::import(new Sp2020SlsPartialImport(), $request->file('excel_file'));
        Excel::import(new PokImport($request->tahun), $request->file('excel_file'));
        return redirect('pok/import_pok')->with('success', 'Information has been added');
    }

    public function save_pj(Request $request){
        if(strlen($request->get('rincian_id'))>0){
            $model =  \App\PokRincianAnggaran::find($request->get('rincian_id'));
            if($model!=null){
                $model->id_pj = $request->get('id_pegawai');
                $model_pegawai = \App\UserModel::find($request->get('id_pegawai'));
                
                if($model_pegawai!=null){
                    $model->nip_pj = $model_pegawai->nip_baru;
                    $model->nama_pj = $model_pegawai->name;
                }

                if($model->save()){
                    return response()->json(['status'=>'success', 
                        'datas' => $model,
                    ]);
                }
            }
        }

        return response()->json(['status'=>'error', 
            'datas' => null,
        ]);
    }

    public function save_transaksi(Request $request){
        $model_rincian = \App\PokRincianAnggaran::find($request->get('rincian_id'));

        if($model_rincian!=null){
            $model_transaksi = \App\PokTransaksi::find($request->get('transaksi_id'));
            if($model_transaksi==null){
                $model_transaksi = new \App\PokTransaksi;
                $model_transaksi->id_rincian = $model_rincian->id;
                $model_transaksi->created_by = Auth::id();
            }

            if($request->get('transaksi_jenis')==1){ //estimasi
                $model_transaksi->total_estimasi = $request->get('transaksi_biaya');
                $model_transaksi->waktu_estimasi = date('Y-m-d h:i:s');
                $model_transaksi->estimasi_by = Auth::id();
                $model_transaksi->ket_estimasi = $request->get('transaksi_ket');
            }
            else{ //realisasi
                $model_transaksi->total_realisasi = $request->get('transaksi_biaya');
                $model_transaksi->waktu_realisasi = date('Y-m-d h:i:s');
                $model_transaksi->realisasi_by = Auth::id();
                $model_transaksi->ket_realisasi = $request->get('transaksi_ket');
            }

            $model_transaksi->label = $request->get('transaksi_label');
            $model_transaksi->updated_by = Auth::id();
            if($model_transaksi->save()){
                $jumlah_rincian = \App\PokTransaksi::where('id_rincian', '=', $model_rincian->id)->count();
                if($request->get('transaksi_jenis')==1){
                    $total_biaya = \App\PokTransaksi::where('id_rincian', '=', $model_rincian->id)->sum('total_estimasi');
                    $model_rincian->jumlah_rincian_estimasi = $jumlah_rincian;
                    $model_rincian->total_estimasi = $total_biaya;
                }
                else{
                    $total_biaya = \App\PokTransaksi::where('id_rincian', '=', $model_rincian->id)->sum('total_realisasi');
                    $model_rincian->jumlah_rincian_realisasi = $jumlah_rincian;
                    $model_rincian->total_realisasi = $total_biaya;
                }
                $model_rincian->save();
            }
            
            return response()->json(['status'=>'success', 
                'datas' => null,
            ]);
        }
        else{
            return response()->json(['status'=>'error', 
                'datas' => null,
            ]);
        }

        if(strlen($request->get('rincian_id'))>0){
            $model =  \App\PokRincianAnggaran::find($request->get('rincian_id'));
            if($model!=null){
                $model->id_pj = $request->get('id_pegawai');
                $model_pegawai = \App\UserModel::find($request->get('id_pegawai'));
                
                if($model_pegawai!=null){
                    $model->nip_pj = $model_pegawai->nip_baru;
                    $model->nama_pj = $model_pegawai->name;
                }

                if($model->save()){
                    return response()->json(['status'=>'success', 
                        'datas' => $model,
                    ]);
                }
            }
        }

    }
    
    public function delete_transaksi(Request $request){
        $model_transaksi = \App\PokTransaksi::find($request->get('transaksi_id'));
        if($model_transaksi!=null){
            $model_transaksi->delete();     
            return response()->json(['status'=>'success', 
                'datas' => null,
            ]);
        }
        
        return response()->json(['status'=>'error', 
            'datas' => null,
        ]);
    }

    public function show_transaksi($id){
        $data = \App\PokTransaksi::where('id_rincian', '=', $id)->get(); 
        
        return response()->json(['status'=>'success', 
            'data' => $data,
        ]);
    }

    public function revisi(Request $request){
        $keyword = $request->get('search');
        $model = new \App\PokRevisi;

        $datas = \App\PokRevisi::where('judul', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('keterangan', 'LIKE', '%' . $keyword . '%')
                    ->orderBy('id', 'desc')
                    ->paginate();

        $datas->withPath('revisi');
        $datas->appends($request->all());

        return view('pok.revisi', compact(
            'datas', 'keyword', 'model'
        ));
    }

    public function create_revisi(){
        $model= new \App\PokRevisi;
        
        return view('pok.revisi_create', compact(
            'model'
        ));
    }

    public function store_revisi(PokRevisiRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('pok/create_revisi')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\PokRevisi;
        $model->judul=$request->get('judul');
        $model->keterangan=$request->get('keterangan');
        // $model->nama=$request->get('nama');
        
        if ($request->hasFile('kak')) {
            $file = $request->file('kak');
            $name = (strlen($model->kak)>3) ? $model->kak : time().str_replace(' ','',$file->getClientOriginalName());

            $file->move('upload/kak', $name);
            $model->kak = $name;
        }
        
        if ($request->hasFile('nota_dinas')) {
            $file = $request->file('nota_dinas');
            $name = (strlen($model->nota_dinas)>3) ? $model->nota_dinas : time().str_replace(' ','',$file->getClientOriginalName());

            $file->move('upload/nota_dinas', $name);
            $model->nota_dinas = $name;
        }
        
        if ($request->hasFile('matrik_anggaran')) {
            $file = $request->file('matrik_anggaran');
            $name = (strlen($model->matrik_anggaran)>3) ? $model->matrik_anggaran : time().str_replace(' ','',$file->getClientOriginalName());

            $file->move('upload/matrik_anggaran', $name);
            $model->matrik_anggaran = $name;
        }

        $model->status_revisi = 0;

        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('pok/revisi')->with('success', 'Information has been added');
    }
    
    public function destroy_revisi($id){
        $model = \App\PokRevisi::find($id);

        File::delete('upload/kak/'.$model->kak);
        File::delete('upload/nota_dinas/'.$model->nota_dinas);
        File::delete('upload/matrik_anggaran/'.$model->matrik_anggaran);

        $model->delete();
        return redirect('pok/revisi')->with('success','Information has been  deleted');
    }
    
    public function approve_revisi($id){
        $model = \App\PokRevisi::find($id);
        $model->status_revisi = 1;
        $model->approved_ppk_by = Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('pok/revisi')->with('success','Information has been  deleted');
    }
    
    public function download($jenis, $file_name){
        $file = public_path()."/upload/".$jenis."/". $file_name;
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file, $file_name, $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}