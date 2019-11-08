<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MasterBarangRequest;

class OpnamePersediaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = date('m');
        $year = date('Y');
        $master_barang = \App\MasterBarang::all();
        $unit_kerja = \App\UnitKerja::all();


        return view('opname_persediaan.index',compact('master_barang','unit_kerja', 
                'year', 'month'));
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

        return response()->json(['success'=>'1', 'datas'=>$datas]);
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

        return view('opname_persediaan.form',compact('datas', 'year', 'month'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
                    $model->created_by=Auth::id();
                }

                $model->id_barang = $data->id;
                $model->nama_barang = $data->nama_barang;
                $model->bulan = $month;
                $model->tahun = $year;

                $model->saldo_awal = (int)$data->$label_op_awal;
                $model->harga_awal = (int)$data->$label_op_awal*(int)$data->harga_satuan;
                
                $model->saldo_tambah = (int)$request->get('tambah_'.$data->id);
                $model->harga_tambah = (int)$request->get('tambah_'.$data->id)*(int)$data->harga_satuan;
                
                $model->updated_by=Auth::id();
                $model->save();
            }
        }
        
        return redirect('opname_persediaan')->with('success', 'Data berhasil ditambahkan');
    }

    public function storeBarangKeluar(Request $request){
        $model = new \App\OpnamePengurangan;
        if($request->form_id_data!=0)
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

        $model->unit_kerja = $request->form_unit_kerja;
        $model->tanggal = date('Y-m-d', strtotime($request->form_year."-".$request->form_month."-".$request->form_tanggal));
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();

        return response()->json(['success'=>'Data berhasil ditambah']);
    }
}
