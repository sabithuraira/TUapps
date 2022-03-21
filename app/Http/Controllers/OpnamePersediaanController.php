<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MasterBarangRequest;
use PDF;

class OpnamePersediaanController extends Controller
{
    public function aeik(){
        // $keluars = \App\OpnamePen::all();

        // foreach($keluars as $value){
        //     $detail_barang = \App\MasterBarang::find($value->id_barang);
        //     $value->harga_tambah = ($value->jumlah_tambah*$detail_barang->harga_satuan);
        //     $value->save();
        // }
        
        $model = new \App\Opnamepersediaan();
        $all_barang = \App\MasterBarang::all();

        foreach($all_barang as $value){
            $model->triggerAllMonth($value->id, 11, 2019, $value->nama_barang);
            // $detail_barang = \App\MasterBarang::find($value->id_barang);
            // $value->harga_tambah = ($value->jumlah_tambah*$detail_barang->harga_satuan);
            // $value->save();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $month = date('m');
        $year = date('Y');
        $master_barang = \App\MasterBarang::all();

        $unit_kerja = \App\UnitKerja4::where('is_kabupaten','=',1)
            ->where('is_persediaan', '=', 1)->get();

        if(Auth::user()->kdkab=='00'){
            $unit_kerja = \App\UnitKerja4::where('is_kabupaten','=',0)
                ->where('is_persediaan', '=', 1)->get();
        }

        return view('opname_persediaan.index',compact('master_barang','unit_kerja', 
                'year', 'month'));
    }

    public function print_persediaan(Request $request){
        $datas=array();
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('p_month'))>0)
            $month = $request->get('p_month');

        if(strlen($request->get('p_year'))>0)
            $year = $request->get('p_year');

        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $last_day_month  = date('t', mktime(0, 0, 0, $month, 10));

        $prevMonthName = date("F", mktime(0, 0, 0, ($month-1), 10));
        $last_day_prev_month  = date('t', mktime(0, 0, 0, ($month-1), 10));
        
        $model = new \App\Opnamepersediaan();
        $datas = $model->OpnameRekap($month, $year);

        $pdf = PDF::loadView('opname_persediaan.print_persediaan', compact('month', 
            'year', 'datas', 'monthName', 'last_day_month',
            'prevMonthName', 'last_day_prev_month'))
            ->setPaper('a4', 'landscape');
        
        $nama_file = 'opname_persediaan_';
        $nama_file .= $month .'_'.$year.'_'. '.pdf';

        return $pdf->download($nama_file);

        // return view('opname_persediaan.print_persediaan', compact('month', 
        //      'year', 'datas', 'monthName', 'last_day_month',
        //      'prevMonthName', 'last_day_prev_month'));
    }

    public function loadData(Request $request){
        $datas=array();
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
            
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');

        $model = new \App\Opnamepersediaan();
        $datas = $model->OpnameRekap($month, $year);
        // foreach($datas as $key=>$value){
        //     $datas[$key]->list_keluar = \App\OpnamePengurangan::where('id_barang', '=' ,$value->id)
        //                                     ->where('bulan', '=', $month)
        //                                     ->where('tahun', '=', $year)   
        //                                     ->with('unitKerja')                                         
        //                                     ->get();
        // }
        
        return response()->json(['success'=>'1', 'datas'=>$datas]);
    }

    public function loadRincian(Request $request){
        $datas=array();
        $month = date('m');
        $year = date('Y');
        $id_barang = 0;
        $jenis = 1; //1penambahan, 2pengurangan

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
            
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        if(strlen($request->get('id_barang'))>0)
            $id_barang = $request->get('id_barang');
            
        if(strlen($request->get('jenis'))>0)
            $jenis = $request->get('jenis');

        if($jenis==1){
            $datas = \App\OpnamePenambahan::where('id_barang', '=' ,$id_barang)
                ->where('bulan', '=', $month)
                ->where('tahun', '=', $year)                                
                ->get();
        }
        else{
            $datas = \App\OpnamePengurangan::where('id_barang', '=' ,$id_barang)
                ->where('bulan', '=', $month)
                ->where('tahun', '=', $year)   
                ->with('unitKerja')                                         
                ->get();
        }
        
        return response()->json(['success'=>'1', 'datas'=>$datas]);
    }

    public function kartu_kendali(Request $request){
        $barang = \App\MasterBarang::first()->id;
        $month = date('m');
        $year = date('Y');
        
        $list_barang = \App\MasterBarang::all();

        return view('opname_persediaan.kartu_kendali',compact('barang','month', 
                'year', 'list_barang'));
    }

    public function loadKartukendali(Request $request){
        $datas=array();
        $barang = \App\MasterBarang::first()->id;
        $month = date('m');
        $year = date('Y');

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
            
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        if(strlen($request->get('barang'))>0)
            $barang = $request->get('barang');

        $model = new \App\Opnamepersediaan();
        
        $persediaan = \App\OpnamePersediaan::where('id_barang', '=' ,$barang)
                ->where('bulan', '=', $month)
                ->where('tahun', '=', $year)   
                ->first();

        $detail_barang = \App\MasterBarang::find($barang);

        if($persediaan!=null){
            $datas = $model->KartuKendali($barang, $month, $year);

            $saldo_jumlah = $persediaan->saldo_awal;
            $saldo_harga = $persediaan->harga_awal;
    
            $total_jumlah = 0;
            $total_harga = 0;
    
            foreach($datas as $key=>$value){
                if($value->jenis==2){
                    $datas[$key]->saldo_jumlah = $saldo_jumlah - $value->jumlah;
                    $datas[$key]->saldo_harga = $saldo_harga - $value->harga;    
                }
                else{
                    $datas[$key]->saldo_jumlah = $saldo_jumlah + $value->jumlah;
                    $datas[$key]->saldo_harga = $saldo_harga + $value->harga;    
                }
    
                $saldo_jumlah = $datas[$key]->saldo_jumlah;
                $saldo_harga = $datas[$key]->saldo_harga;
            }
        }
        else{
            $persediaan = (object) array();
        }
            
        return response()->json(['success'=>'1', 'datas'=>$datas, 
            'persediaan'=>$persediaan, 'detail_barang'=>$detail_barang]);
    }

    public function print_kartukendali(Request $request){
        $datas=array();
        $month = date('m');
        $year = date('Y');
        $barang = \App\MasterBarang::first()->id;

        if(strlen($request->get('p_month'))>0)
            $month = $request->get('p_month');

        if(strlen($request->get('p_year'))>0)
            $year = $request->get('p_year');
            
        if(strlen($request->get('p_barang'))>0)
            $barang = $request->get('p_barang');

        $model = new \App\Opnamepersediaan();
        
        $persediaan = \App\OpnamePersediaan::where('id_barang', '=' ,$barang)
                ->where('bulan', '=', $month)
                ->where('tahun', '=', $year)   
                ->first();

        $detail_barang = \App\MasterBarang::find($barang);

        if($persediaan!=null){
            $datas = $model->KartuKendali($barang, $month, $year);

            $saldo_jumlah = $persediaan->saldo_awal;
            $saldo_harga = $persediaan->harga_awal;

            $total_jumlah = 0;
            $total_harga = 0;

            foreach($datas as $key=>$value){
                if($value->jenis==2){
                    $datas[$key]->saldo_jumlah = $saldo_jumlah - $value->jumlah;
                    $datas[$key]->saldo_harga = $saldo_harga - $value->harga;    
                }
                else{
                    $datas[$key]->saldo_jumlah = $saldo_jumlah + $value->jumlah;
                    $datas[$key]->saldo_harga = $saldo_harga + $value->harga;    
                }

                $saldo_jumlah = $datas[$key]->saldo_jumlah;
                $saldo_harga = $datas[$key]->saldo_harga;
            }
        }
        else{
            $persediaan = (object) array();
        }
        
        $monthName = date("F", mktime(0, 0, 0, $month, 10));

        $pdf = PDF::loadView('opname_persediaan.print_kartukendali', compact('month', 
            'year', 'barang', 'datas', 'detail_barang', 'persediaan',
            'monthName'))
            ->setPaper('a4', 'landscape');
        
        $nama_file = 'kartukendali_'.$detail_barang->nama_barang.'_';
        $nama_file .= $month .'_'.$year.'.pdf';

        return $pdf->download($nama_file);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $month = date('m');
        $year = date('Y');

        return view('opname_persediaan.form',compact('datas', 'year', 'month'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $month = date('m');
        $year = date('Y');
        
        if(strlen($request->get('month'))>0)
            $month = $request->get('month');
        
        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
        
        $model = new \App\Opnamepersediaan();
        $datas = $model->OpnameRekap($month, $year);

        $label_op_awal =  "op_awal_".$month;
        $label_op_tambah =  "op_tambah_".$month;

        foreach($datas as $data){
            if(strlen($request->get('tambah_'.$data->id))>0){
                
                $model = \App\Opnamepersediaan::where('id_barang', '=' ,$data->id)
                            ->where('bulan', '=', $month)
                            ->where('tahun', '=', $year)
                            ->first();

                if($model==null) {
                    $model= new \App\Opnamepersediaan;
                    $model->id_barang = $data->id;
                    $model->bulan = $month;
                    $model->tahun = $year;
                    $model->created_by=Auth::id();
                }

                $model->nama_barang = $data->nama_barang;

                $model->saldo_awal = (int)$data->$label_op_awal;
                $model->harga_awal = (int)$data->$label_op_awal*(int)$data->harga_satuan;
                
                $model->saldo_tambah = (int)$request->get('tambah_'.$data->id);
                $model->harga_tambah = (int)$request->get('tambah_'.$data->id)*(int)$data->harga_satuan;
                
                $model->updated_by=Auth::id();
                if($model->save()){
                    $jumlah_saldo = (int)$data->$label_op_awal+(int)$request->get('tambah_'.$data->id)- (int)$data->pengeluaran;
                    $model->triggerNextMonth($month, $year, $data->id, $jumlah_saldo, (int)$data->harga_satuan, $data->nama_barang);
                }
            }
        }
        
        return redirect('opname_persediaan')->with('success', 'Data berhasil ditambahkan');
    }

    public function storeBarangKeluar(Request $request){
        $model = new \App\OpnamePengurangan;
        if($request->form_id_data!=0 && $request->form_id_data!='')
            $model = \App\OpnamePengurangan::find($request->form_id_data);

        $model->bulan = $request->form_month;
        $model->tahun = $request->form_year;
        $model->id_barang = $request->form_id_barang;
        $model->jumlah_kurang = $request->form_jumlah;

        $model_barang = \App\MasterBarang::find($request->form_id_barang);
        if($model_barang!=null)
            $model->harga_kurang = (int)$model_barang->harga_satuan*(int)$request->form_jumlah;
        else
            $model->harga_kurang = 0;

        $model_unit_kerja = \App\UnitKerja::where('kode', '=' ,config('app.kode_prov').Auth::user()->kdkab)
                            ->first();
        $model->unit_kerja = $model_unit_kerja->id;

        if($request->form_is_usang==1) $model->keterangan_usang = $request->form_keterangan_usang;
        else $model->unit_kerja4 = $request->form_unit_kerja;

        $model->tanggal = date('Y-m-d', strtotime($request->form_year."-".$request->form_month."-".$request->form_tanggal));
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        if($model->save()){
            $model_o = new \App\Opnamepersediaan();
            $model_o->triggerPersediaan($request->form_id_barang, $request->form_month, 
                    $request->form_year, $model_barang->nama_barang);
        }

        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    public function storeBarangMasuk(Request $request){
        $model = new \App\OpnamePenambahan;
        if($request->form_id_data!=0 && $request->form_id_data!='')
            $model = \App\OpnamePenambahan::find($request->form_id_data);

        $model->bulan = $request->form_month;
        $model->tahun = $request->form_year;
        $model->id_barang = $request->form_id_barang;
        $model->jumlah_tambah = $request->form_jumlah;

        $model_barang = \App\MasterBarang::find($request->form_id_barang);
        if($model_barang!=null)
            $model->harga_tambah = (int)$model_barang->harga_satuan*(int)$request->form_jumlah;
        else
            $model->harga_tambah = 0;
        // $model->harga_tambah = $request->form_total_harga;
        
        $model_unit_kerja = \App\UnitKerja::where('kode', '=' ,config('app.kode_prov').Auth::user()->kdkab)
                            ->first();
        $model->unit_kerja = $model_unit_kerja->id;

        $model->nama_penyedia = $request->form_nama_penyedia;
        $model->tanggal = date('Y-m-d', strtotime($request->form_year."-".$request->form_month."-".$request->form_tanggal));
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        if($model->save())
        {
            $model_o = new \App\Opnamepersediaan();
            $model_o->triggerPersediaan($request->form_id_barang, $request->form_month, 
                    $request->form_year, $model_barang->nama_barang);
        }

        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    public function deleteBarangKeluar(Request $request){
        $msg = "";
        if($request->form_id_data!=0 && $request->form_id_data!='')
        {
            $model = \App\OpnamePengurangan::find($request->form_id_data);
            if($model!=null){
                $id_barang = $model->id_barang;
                $bulan = $model->bulan;
                $tahun = $model->tahun;

                if($model->delete()){
                    $model_barang = \App\MasterBarang::find($id_barang);
                    $model_o = new \App\Opnamepersediaan();
                    $model_o->triggerPersediaan($id_barang, $bulan, 
                            $tahun, $model_barang->nama_barang);
                }
            }
        }
        
        return response()->json(['success'=>'Data berhasil ditambah']);
    }

    public function deleteBarangMasuk(Request $request){
        $msg = "";
        if($request->form_id_data!=0 && $request->form_id_data!='')
        {
            $model = \App\OpnamePenambahan::find($request->form_id_data);
            if($model!=null){
                $id_barang = $model->id_barang;
                $bulan = $model->bulan;
                $tahun = $model->tahun;

                if($model->delete())
                {
                    $model_barang = \App\MasterBarang::find($id_barang);
                    $model_o = new \App\Opnamepersediaan();
                    $model_o->triggerPersediaan($id_barang, $bulan, 
                            $tahun, $model_barang->nama_barang);
                }
            }
        }
        
        return response()->json(['success'=>'Data berhasil ditambah']);
    }
}
