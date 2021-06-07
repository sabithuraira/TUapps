<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratKmRequest;
use Illuminate\Support\Facades\DB;

class SuratKmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');
        $jenis = $request->get('jenis');

        $where_condition = [
            ['kdprop', '=', Auth::user()->kdprop],
            ['kdkab', '=', Auth::user()->kdkab],
        ];

        if($jenis!='') $where_condition[] = ['jenis_surat', '=', $jenis];

        $list_surat = \App\SuratKm::where($where_condition)->orderBy('created_at', 'desc')->paginate();
        
        if(strlen($keyword)>0){
            $list_surat = \App\SuratKm::where($where_condition)
                ->where(
                    (function ($query) use ($keyword) {
                        $query-> where('nomor_urut', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('perihal', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->orderBy('created_at', 'desc')->paginate();
        }

        $list_surat->withPath('surat_km');
        $list_surat->appends($request->all());


        return view('surat_km.index',compact('list_surat', 'keyword', 'jenis'));
    }

    public function getNomorUrut(Request $request){
        $jenis_surat = 1;
        // $nomor_petunjuk = 0;
        $tanggal = date('Y-m-d');
        $total=1;

        if(strlen($request->get('jenis_surat'))>0)
            $jenis_surat = $request->get('jenis_surat');

        // if(strlen($request->get('nomor_petunjuk'))>0)
        //     $nomor_petunjuk = $request->get('nomor_petunjuk');

        if(strlen($request->get('tanggal'))>0){
            $tanggal = date('Y-m-d', strtotime($request->get('tanggal')));
        }

        $total_after = \App\SuratKm::where([
                ['tanggal', '>', $tanggal],
                ['jenis_surat', '=', $jenis_surat],
                ['kdprop', '=', Auth::user()->kdprop],
                ['kdkab', '=', Auth::user()->kdkab],
            ])->count();
        
        if ($total_after == 0) {
            $last_data = \App\SuratKm::where([
                    [DB::raw('YEAR(tanggal)'), '=', date('Y', strtotime($tanggal))],
                    ['jenis_surat', '=', $jenis_surat],
                    ['kdprop', '=', Auth::user()->kdprop],
                    ['kdkab', '=', Auth::user()->kdkab],
                    ['nomor_urut', 'regexp', '^[0-9]+$'],
                ])
                ->orderBy(DB::raw('CAST(nomor_urut as unsigned)'), 'desc')
                ->first();

            // $nomor_terakhir = $last_data->nomor_urut;

            // if(!is_numeric($nomor_terakhir)){
            //     $exp = explode(".", $nomor_terakhir);
            //     $nomor_terakhir = $exp[0];
            // }

            // if($last_data!=null) $total = $nomor_terakhir + 1;
            // else $total = 1;
            
            if($last_data!=null) $total =  $last_data->nomor_urut + 1;
            else $total = 1;
        }
        else{
            $first_after = \App\SuratKm::where([
                    ['tanggal', '>', $tanggal],
                    ['jenis_surat', '=', $jenis_surat],
                    ['kdprop', '=', Auth::user()->kdprop],
                    ['kdkab', '=', Auth::user()->kdkab],
                    // ['nomor_urut', 'regexp', '^[0-9]+$'],
                ])
                ->orderBy('nomor_urut', 'asc')
                ->first();

            $first_number_after = $first_after->nomor_urut;

            // if the number not numeric, ex: 306.A, 90.C,
            // we will explode by "." char and take the numeric only
            if(!is_numeric($first_number_after)){
                $exp = explode(".", $first_number_after);
                $first_number_after = $exp[0];
            }

            $current_number = $first_number_after - 1;

            $total_current_number = \App\SuratKm::where([
                ['nomor_urut', 'LIKE', $current_number.'%'],
                ['jenis_surat', '=', $jenis_surat],
                ['kdprop', '=', Auth::user()->kdprop],
                ['kdkab', '=', Auth::user()->kdkab],
            ])
            ->count();

            $alphabet = range('A', 'Z');
            
            if($current_number==0 || $total_current_number<=0)
                $total = 0;
            else
                $total = $current_number.'.'.$alphabet[$total_current_number-1];
        }

        return response()->json(['success'=>'Sukses', 'total'=>$total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\SuratKm;
        $model->tanggal = date('Y-m-d');
        $model->jenis_surat = 1;
        return view('surat_km.create',compact('model'));
    }

    function getNomorUrutDirect($date_surat, $jenis_surat){
        $total=1;
        $tanggal =  date('Y-m-d', strtotime($date_surat));

        $total_after = \App\SuratKm::where([
                ['tanggal', '>', $tanggal],
                ['jenis_surat', '=', $jenis_surat],
                ['kdprop', '=', Auth::user()->kdprop],
                ['kdkab', '=', Auth::user()->kdkab],
            ])->count();
        
        if ($total_after == 0) {
            $last_data = \App\SuratKm::where([
                    [DB::raw('YEAR(tanggal)'), '=', date('Y', strtotime($tanggal))],
                    ['jenis_surat', '=', $jenis_surat],
                    ['kdprop', '=', Auth::user()->kdprop],
                    ['kdkab', '=', Auth::user()->kdkab],
                    ['nomor_urut', 'regexp', '^[0-9]+$'],
                ])
                ->orderBy(DB::raw('CAST(nomor_urut as unsigned)'), 'desc')
                ->first();
            
            if($last_data!=null) $total =  $last_data->nomor_urut + 1;
            else $total = 1;
        }
        else{
            $first_after = \App\SuratKm::where([
                    ['tanggal', '>', $tanggal],
                    ['jenis_surat', '=', $jenis_surat],
                    ['kdprop', '=', Auth::user()->kdprop],
                    ['kdkab', '=', Auth::user()->kdkab],
                    // ['nomor_urut', 'regexp', '^[0-9]+$'],
                ])
                ->orderBy('nomor_urut', 'asc')
                ->first();

            $first_number_after = $first_after->nomor_urut;

            // if the number not numeric, ex: 306.A, 90.C,
            // we will explode by "." char and take the numeric only
            if(!is_numeric($first_number_after)){
                $exp = explode(".", $first_number_after);
                $first_number_after = $exp[0];
            }

            $current_number = $first_number_after - 1;

            $total_current_number = \App\SuratKm::where([
                ['nomor_urut', 'LIKE', $current_number.'%'],
                ['jenis_surat', '=', $jenis_surat],
                ['kdprop', '=', Auth::user()->kdprop],
                ['kdkab', '=', Auth::user()->kdkab],
            ])
            ->count();

            $alphabet = range('A', 'Z');
            
            if($current_number==0 || $total_current_number<=0)
                $total = 0;
            else
                $total = $current_number.'.'.$alphabet[$total_current_number-1];
        }

        return $total;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratKmRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_km/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\SuratKm;
        $model->jenis_surat = $request->jenis_surat;
        $model->kdprop =Auth::user()->kdprop;
        $model->kdkab =Auth::user()->kdkab;
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();

        $tanggal_format = date('Y-m-d');
        if($request->has('tanggal')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal')));
    
        $bulan = date('m', strtotime($request->get('tanggal')));
        $tahun = date('Y', strtotime($request->get('tanggal')));

        if($model->jenis_surat==1){
            $model->tanggal= date('Y-m-d', strtotime($request->get('tanggal')));
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->alamat= $request->get('alamat');
            $model->nomor= $request->get('nomor');
            $model->perihal= $request->get('perihal');
            $model->nomor_petunjuk= $request->get('nomor_petunjuk');
            $model->penerima= $request->get('penerima');
            $model->save();
        }
        else if($model->jenis_surat==2){
            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan;
            $model->kode_unit_kerja = $request->kode_unit_kerja;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut."/".$request->kode_unit_kerja."/".$request->klasifikasi_arsip."/".$bulan."/".$tahun;
            $model->perihal= $request->get('perihal');
            $model->ditetapkan_oleh = $request->ditetapkan_oleh;
            $model->ditetapkan_nama = $request->ditetapkan_nama;
            if($model->save()){
                if(strlen($request->isi)>0 && strlen($request->lampiran)>0 && 
                    strlen($request->kepada)>0 && 
                    strlen($request->kepada_di)>0 && strlen($request->dibuat_di)>0){

                    $model_rincian = new \App\SuratKmRincianSuratLuar;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->isi = $request->isi;
                    $model_rincian->lampiran = $request->lampiran;
                    $model_rincian->kepada = $request->kepada;
                    $model_rincian->kepada_di = $request->kepada_di;
                    $model_rincian->dibuat_di = $request->dibuat_di;
                    $model_rincian->save();

                }
            }
        }
        else if($model->jenis_surat==3){
            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->perihal= $request->get('perihal');
            $model->kode_unit_kerja = $request->kode_unit_kerja;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip;
            // @{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ kode_klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} 
            $model->nomor= $request->nomor_urut."/".$request->kode_unit_kerja."/".$request->klasifikasi_arsip."/".$bulan."/".$tahun;
            $model->ditetapkan_oleh = $request->ditetapkan_oleh;
            $model->ditetapkan_nama = $request->ditetapkan_nama;
            if($model->save()){
                if(strlen($request->dari)>0 && strlen($request->isi)>0 && 
                    strlen($request->kepada)>0 && strlen($request->tembusan)>0){
                    $model_rincian = new \App\SuratKmRincianMemorandum;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->dari = $request->dari;
                    $model_rincian->isi = $request->isi;
                    $model_rincian->kepada = $request->kepada;
                    $model_rincian->tembusan = $request->tembusan;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==4){
            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan;
            $model->kode_unit_kerja = $request->kode_unit_kerja;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut."/".$request->kode_unit_kerja."/".$request->klasifikasi_arsip."/".$bulan."/".$tahun;
            $model->ditetapkan_oleh = $request->ditetapkan_oleh;
            $model->ditetapkan_nama = $request->ditetapkan_nama;
            $model->ditetapkan_nip = $request->ditetapkan_nip;
            if($model->save()){
                if(strlen($request->isi)>0 && strlen($request->kepada)>0 && 
                    strlen($request->kepada_di)>0 && strlen($request->dibuat_di)>0
                    && strlen($request->diterima_tanggal)>0 && strlen($request->diterima_jabatan)>0 
                    && strlen($request->diterima_nama)>0){
                    $model_rincian = new \App\SuratKmRincianSuratPengantar;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->isi = $request->isi;
                    $model_rincian->kepada = $request->kepada;
                    $model_rincian->kepada_di = $request->kepada_di;
                    $model_rincian->diterima_tanggal = $request->diterima_tanggal;
                    $model_rincian->diterima_jabatan = $request->diterima_jabatan;
                    $model_rincian->diterima_nama = $request->diterima_nama;
                    $model_rincian->diterima_nip = $request->diterima_nip;
                    $model_rincian->diterima_no_hp = $request->diterima_no_hp;
                    $model_rincian->dibuat_di = $request->dibuat_di;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==5){
            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan;
            $model->nomor= $request->nomor;
            if($model->save()){
                if(strlen($request->isi)>0 && strlen($request->nomor_agenda)>0 && 
                    strlen($request->tanggal_penerimaan)>0 && strlen($request->tanggal_penyelesaian)>0
                    && strlen($request->dari)>0 && strlen($request->isi)>0){
                    $model_rincian = new \App\SuratKmRincianDisposisi;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->nomor_agenda = $request->nomor_agenda;
                    $model_rincian->tanggal_penerimaan = date('Y-m-d', strtotime($request->tanggal_penerimaan));
                    $model_rincian->tanggal_penyelesaian = date('Y-m-d', strtotime($request->tanggal_penyelesaian));
                    $model_rincian->dari = $request->dari;
                    $model_rincian->lampiran = $request->lampiran;
                    $model_rincian->isi = $request->isi;
                    $model_rincian->isi_disposisi = $request->isi_disposisi;
                    $model_rincian->diteruskan_kepada = $request->diteruskan_kepada;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==6){
            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->nomor= $request->nomor;
            $model->ditetapkan_di= $request->ditetapkan_di;
            $model->ditetapkan_tanggal= date('Y-m-d', strtotime($request->ditetapkan_tanggal));
            $model->ditetapkan_oleh= $request->ditetapkan_oleh;
            $model->ditetapkan_nama= $request->ditetapkan_nama;
            if($model->save()){
                if(strlen($request->tentang)>0 && strlen($request->menimbang)>0 && 
                    strlen($request->mengingat)>0 && strlen($request->menetapkan)>0
                    && strlen($request->tembusan)>0 && strlen($request->jumlah_keputusan)>0){
                    $model_rincian = new \App\SuratKmRincianSuratKeputusan;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->tentang = $request->tentang;
                    $model_rincian->menimbang = $request->menimbang;
                    $model_rincian->mengingat = $request->mengingat;
                    $model_rincian->menetapkan = $request->menetapkan;
                    $model_rincian->tembusan = $request->tembusan;
                    $model_rincian->save();
    
                    $jumlah_keputusan = $request->jumlah_keputusan;
                    for($i=0;$i<$jumlah_keputusan;$i++){
                        $model_keputusan = new \App\SuratKmRincianListKeputusan;
                        $model_keputusan->induk_id = $model->id;
                        $model_keputusan->isi = $request->get("keputusana".$i);
                        $model_keputusan->save();
                    } 
                }

            }
        }
        else if($model->jenis_surat==7){
            $model->nomor_urut= $this->getNomorUrutDirect( $tanggal_format, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan;
            $model->kode_unit_kerja = $request->kode_unit_kerja;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut."/".$request->kode_unit_kerja."/".$request->klasifikasi_arsip."/".$bulan."/".$tahun;
            $model->ditetapkan_di = $request->ditetapkan_di;
            $model->ditetapkan_tanggal = date('Y-m-d', strtotime($request->ditetapkan_tanggal));
            $model->ditetapkan_oleh = $request->ditetapkan_oleh;
            $model->ditetapkan_nama = $request->ditetapkan_nama;
            if($model->save()){
                if(strlen($request->isi)>0){
                    $model_rincian = new \App\SuratKmRincianSuratKeterangan;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->isi = $request->isi;
                    $model_rincian->save();
                }
            }
        }
       
        return redirect('surat_km')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = \App\SuratKm::find($id);
        return view('surat_km.show', compact('model', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = \App\SuratKm::find($id);
        return view('surat_km.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuratKmRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_km/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\SuratKm::find($id);
        $model->nomor_urut=$request->get('nomor_urut');
        $model->alamat=$request->get('alamat');
        $model->tanggal= date('Y-m-d', strtotime($request->get('tanggal')));
        $model->nomor=$request->get('nomor');
        $model->perihal=$request->get('perihal');
        $model->penerima=$request->get('penerima');
        $model->nomor_petunjuk=$request->get('nomor_petunjuk');
        $model->jenis_surat=$request->get('jenis_surat');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('surat_km');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\SuratKm::find($id);
        $model->delete();
        return redirect('surat_km')->with('success','Information has been  deleted');
    }
}
