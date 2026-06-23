<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratKmRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

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
        $model = new \App\SuratKm;

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


        return view('surat_km.index',compact('list_surat', 'keyword', 'jenis', 'model'));
    }

    public function getNomorUrut(Request $request){
        $jenis_surat = 1;
        $tanggal = date('Y-m-d');

        if(strlen($request->get('jenis_surat'))>0)
            $jenis_surat = $request->get('jenis_surat');

        if(strlen($request->get('tanggal'))>0){
            $tanggal = date('Y-m-d', strtotime($request->get('tanggal')));
        }

        try {
            $total = $this->resolveNomorUrut($tanggal, $jenis_surat);
            return response()->json(['success'=>'Sukses', 'total'=>$total]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => 'Error',
                'message' => $e->getMessage(),
                'total' => 0,
            ], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model= new \App\SuratKm;
        $model->tanggal = date('Y-m-d');
        $model->jenis_surat = 1;
        $id = '';
        $model_rincian = null;
        $list_keputusan = [];
        return view('surat_km.create',compact('model', 'id', 'model_rincian', 'list_keputusan'));
    }

    function getNomorUrutDirect($date_surat, $jenis_surat, $excludeId = null){
        return $this->resolveNomorUrut($date_surat, $jenis_surat, $excludeId);
    }

    protected function resolveNomorUrut($date_surat, $jenis_surat, $excludeId = null){
        $tanggal = date('Y-m-d', strtotime($date_surat));
        $year = date('Y', strtotime($tanggal));
        $baseQuery = $this->suratKmBaseQuery($jenis_surat, $year, $excludeId);

        $hasLaterDate = (clone $baseQuery)->where('tanggal', '>', $tanggal)->exists();

        if (!$hasLaterDate) {
            return $this->getMaxNomorUrutBase(clone $baseQuery) + 1;
        }

        $firstAfter = (clone $baseQuery)
            ->where('tanggal', '>', $tanggal)
            ->orderBy('tanggal', 'asc')
            ->orderBy('nomor_urut', 'asc')
            ->first();

        if ($firstAfter === null) {
            return $this->getMaxNomorUrutBase(clone $baseQuery) + 1;
        }

        $slotNumber = $this->extractNomorUrutBase($firstAfter->nomor_urut) - 1;

        if ($slotNumber <= 0) {
            throw new \RuntimeException('Tidak dapat menghasilkan nomor urut untuk tanggal ini.');
        }

        $usedCount = $this->countNomorUrutSlots(clone $baseQuery, $slotNumber);

        return $this->buildBackwardNomorUrut($slotNumber, $usedCount);
    }

    protected function suratKmBaseQuery($jenis_surat, $year, $excludeId = null){
        $query = \App\SuratKm::where([
            ['jenis_surat', '=', $jenis_surat],
            ['kdprop', '=', Auth::user()->kdprop],
            ['kdkab', '=', Auth::user()->kdkab],
            [DB::raw('YEAR(tanggal)'), '=', $year],
        ]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query;
    }

    protected function extractNomorUrutBase($nomor_urut){
        $nomor_urut = trim((string) $nomor_urut);
        if ($nomor_urut === '') {
            return 0;
        }

        if (is_numeric($nomor_urut)) {
            return (int) $nomor_urut;
        }

        $parts = explode('.', $nomor_urut, 2);

        return (int) $parts[0];
    }

    protected function getMaxNomorUrutBase($query){
        $max = 0;

        foreach ($query->pluck('nomor_urut') as $nomor_urut) {
            $base = $this->extractNomorUrutBase($nomor_urut);
            if ($base > $max) {
                $max = $base;
            }
        }

        return $max;
    }

    protected function countNomorUrutSlots($query, $slotNumber){
        return $query->where(function ($sub) use ($slotNumber) {
            $sub->where('nomor_urut', '=', (string) $slotNumber)
                ->orWhere('nomor_urut', 'LIKE', $slotNumber.'.%');
        })->count();
    }

    protected function buildBackwardNomorUrut($slotNumber, $usedCount){
        $alphabet = range('A', 'Z');

        if (!isset($alphabet[$usedCount])) {
            throw new \RuntimeException('Nomor urut suffix melebihi batas (Z).');
        }

        return $slotNumber.'.'.$alphabet[$usedCount];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratKmRequest $request){
        if ($request->validator && $request->validator->fails()) {
            return redirect('surat_km/create')
                        ->withErrors($request->validator)
                        ->withInput();
        }

        try {
            return $this->persistSuratKm($request, new \App\SuratKm);
        } catch (\Throwable $e) {
            report($e);

            return redirect('surat_km/create')
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    protected function persistSuratKm(SuratKmRequest $request, \App\SuratKm $model, $is_update = false){
        $model->jenis_surat = $request->jenis_surat;
        if (!$is_update) {
            $model->kdprop = Auth::user()->kdprop;
            $model->kdkab = Auth::user()->kdkab;
            $model->created_by = Auth::id();
        }
        $model->updated_by = Auth::id();

        $tanggal_format = date('Y-m-d');

        if($model->jenis_surat==1){    
            if($request->has('tanggal1')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal1')));
        
            $bulan = date('m', strtotime($request->get('tanggal1')));
            $tahun = date('Y', strtotime($request->get('tanggal1')));

            $model->tanggal= date('Y-m-d', strtotime($request->get('tanggal1')));
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->alamat= $request->get('alamat1');
            $model->nomor= $request->get('nomor1');
            $model->perihal= $request->get('perihal1');
            // $model->nomor_petunjuk= $request->get('nomor_petunjuk');
            $model->penerima= $request->get('penerima1');
            $model->save();
        }
        else if($model->jenis_surat==2){
            if($request->has('tanggal2')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal2')));
        
            $bulan = date('m', strtotime($request->get('tanggal2')));
            $tahun = date('Y', strtotime($request->get('tanggal2')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan2;
            $model->kode_unit_kerja = $request->kode_unit_kerja2;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip2;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut2."/".$request->kode_unit_kerja2."/".$request->klasifikasi_arsip2."/".$tahun;
            $model->perihal= $request->get('perihal2');
            $model->ditetapkan_oleh = $request->ditetapkan_oleh2;
            $model->ditetapkan_nama = $request->ditetapkan_nama2;
            if($model->save()){
                if(strlen($request->isi2)>0 && strlen($request->lampiran2)>0 && 
                    strlen($request->kepada2)>0 && 
                    strlen($request->kepada_di2)>0 && strlen($request->dibuat_di2)>0){

                    $model_rincian = new \App\SuratKmRincianSuratLuar;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->isi = $request->isi2;
                    $model_rincian->lampiran = $request->lampiran2;
                    $model_rincian->kepada = $request->kepada2;
                    $model_rincian->kepada_di = $request->kepada_di2;
                    $model_rincian->dibuat_di = $request->dibuat_di2;
                    $model_rincian->save();

                }
            }
        }
        else if($model->jenis_surat==3){
            if($request->has('tanggal3')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal3')));
        
            $bulan = date('m', strtotime($request->get('tanggal3')));
            $tahun = date('Y', strtotime($request->get('tanggal3')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->perihal= $request->get('perihal3');
            $model->kode_unit_kerja = $request->kode_unit_kerja3;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip3;
            // @{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ kode_klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} 
            $model->nomor= $request->nomor_urut3."/".$request->kode_unit_kerja3."/".$request->klasifikasi_arsip3."/".$tahun;
            $model->ditetapkan_oleh = $request->ditetapkan_oleh3;
            $model->ditetapkan_nama = $request->ditetapkan_nama3;
            if($model->save()){
                if(strlen($request->dari3)>0 && strlen($request->isi3)>0 && 
                    strlen($request->kepada3)>0 && strlen($request->tembusan3)>0){
                    $model_rincian = new \App\SuratKmRincianMemorandum;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->dari = $request->dari3;
                    $model_rincian->isi = $request->isi3;
                    $model_rincian->kepada = $request->kepada3;
                    $model_rincian->tembusan = $request->tembusan3;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==4){
            if($request->has('tanggal4')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal4')));
        
            $bulan = date('m', strtotime($request->get('tanggal4')));
            $tahun = date('Y', strtotime($request->get('tanggal4')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan4;
            $model->kode_unit_kerja = $request->kode_unit_kerja4;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip4;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut4."/".$request->kode_unit_kerja4."/".$request->klasifikasi_arsip4."/".$tahun;
            $model->ditetapkan_oleh = $request->ditetapkan_oleh4;
            $model->ditetapkan_nama = $request->ditetapkan_nama4;
            $model->ditetapkan_nip = $request->ditetapkan_nip4;
            if($model->save()){
                if(strlen($request->isi4)>0 && strlen($request->kepada4)>0 && 
                    strlen($request->kepada_di4)>0 && strlen($request->dibuat_di4)>0){
                    $model_rincian = new \App\SuratKmRincianSuratPengantar;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->isi = $request->isi4;
                    $model_rincian->kepada = $request->kepada4;
                    $model_rincian->kepada_di = $request->kepada_di4;
                    $model_rincian->diterima_tanggal = $request->diterima_tanggal4;
                    $model_rincian->diterima_jabatan = $request->diterima_jabatan4;
                    $model_rincian->diterima_nama = $request->diterima_nama4;
                    $model_rincian->diterima_nip = $request->diterima_nip4;
                    $model_rincian->diterima_no_hp = $request->diterima_no_hp4;
                    $model_rincian->dibuat_di = $request->dibuat_di4;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==5){
            if($request->has('tanggal5')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal5')));
        
            $bulan = date('m', strtotime($request->get('tanggal5')));
            $tahun = date('Y', strtotime($request->get('tanggal5')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan5;
            $model->nomor= $request->nomor5;
            if($model->save()){
                if(strlen($request->isi5)>0 && strlen($request->nomor_agenda5)>0 && 
                    strlen($request->tanggal_penerimaan5)>0 && strlen($request->tanggal_penyelesaian5)>0
                    && strlen($request->dari5)>0 && strlen($request->isi5)>0){
                    $model_rincian = new \App\SuratKmRincianDisposisi;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->nomor_agenda = $request->nomor_agenda5;
                    $model_rincian->tanggal_penerimaan = date('Y-m-d', strtotime($request->tanggal_penerimaan5));
                    $model_rincian->tanggal_penyelesaian = date('Y-m-d', strtotime($request->tanggal_penyelesaian5));
                    $model_rincian->dari = $request->dari5;
                    $model_rincian->lampiran = $request->lampiran5;
                    $model_rincian->isi = $request->isi5;
                    $model_rincian->isi_disposisi = $request->isi_disposisi5;
                    $model_rincian->diteruskan_kepada = $request->diteruskan_kepada5;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==6){
            if($request->has('tanggal6')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal6')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $is_update
                ? $request->nomor_urut6
                : $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->nomor= $request->nomor6;
            $model->ditetapkan_di= $request->ditetapkan_di6;
            $model->ditetapkan_tanggal= $request->ditetapkan_tanggal6
                ? date('Y-m-d', strtotime($request->ditetapkan_tanggal6))
                : null;
            $model->ditetapkan_oleh= $request->ditetapkan_oleh6;
            $model->ditetapkan_nama= $request->ditetapkan_nama6;
            if($model->save()){
                if(strlen((string) $request->tentang6) > 0 && strlen((string) $request->menimbang6) > 0 &&
                    strlen((string) $request->mengingat6) > 0 && strlen((string) $request->menetapkan6) > 0
                    && strlen((string) $request->tembusan6) > 0 && strlen((string) $request->jumlah_keputusan) > 0){
                    $model_rincian = $is_update
                        ? \App\SuratKmRincianSuratKeputusan::where('induk_id', '=', $model->id)->first()
                        : new \App\SuratKmRincianSuratKeputusan;

                    if ($model_rincian === null) {
                        $model_rincian = new \App\SuratKmRincianSuratKeputusan;
                        $model_rincian->induk_id = $model->id;
                    }

                    $model_rincian->tentang = $request->tentang6;
                    $model_rincian->menimbang = $request->menimbang6;
                    $model_rincian->mengingat = $request->mengingat6;
                    $model_rincian->menetapkan = $request->menetapkan6;
                    $model_rincian->tembusan = $request->tembusan6;
                    $model_rincian->save();

                    $jumlah_keputusan = (int) $request->jumlah_keputusan;
                    for($i = 0; $i < $jumlah_keputusan; $i++){
                        $current_id = $request->get('keputusan_'.$i);
                        $isi = $request->get('keputusan_isi'.$current_id);

                        if($isi === null || $isi === ''){
                            continue;
                        }

                        if($is_update && is_numeric($current_id)){
                            $model_keputusan = \App\SuratKmRincianListKeputusan::where('id', '=', $current_id)->first();
                            if($model_keputusan != null){
                                $model_keputusan->isi = $isi;
                                $model_keputusan->save();
                                continue;
                            }
                        }

                        $model_keputusan = new \App\SuratKmRincianListKeputusan;
                        $model_keputusan->induk_id = $model->id;
                        $model_keputusan->isi = $isi;
                        $model_keputusan->save();
                    }
                }
            }
        }
        else if($model->jenis_surat==7){
            if($request->has('tanggal7')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal7')));
        
            $bulan = date('m', strtotime($request->get('tanggal7')));
            $tahun = date('Y', strtotime($request->get('tanggal7')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect( $tanggal_format, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan7;
            $model->kode_unit_kerja = $request->kode_unit_kerja7;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip7;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut7."/".$request->kode_unit_kerja7."/".$request->klasifikasi_arsip7."/".$tahun;
            $model->ditetapkan_di = $request->ditetapkan_di7;
            $model->ditetapkan_tanggal = date('Y-m-d', strtotime($request->ditetapkan_tanggal7));
            $model->ditetapkan_oleh = $request->ditetapkan_oleh7;
            $model->ditetapkan_nama = $request->ditetapkan_nama7;
            if($model->save()){
                if(strlen($request->isi)>0){
                    $model_rincian = new \App\SuratKmRincianSuratKeterangan;
                    $model_rincian->induk_id = $model->id;
                    $model_rincian->isi = $request->isi7;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==8 || $model->jenis_surat==9){
            if($request->has('tanggal8')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal8')));
        
            $bulan = date('m', strtotime($request->get('tanggal8')));
            $tahun = date('Y', strtotime($request->get('tanggal8')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $this->getNomorUrutDirect($model->tanggal, $model->jenis_surat);
            $model->tingkat_keamanan = $request->tingkat_keamanan8;
            $model->kode_unit_kerja = $request->kode_unit_kerja8;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip8;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut8."/".$request->kode_unit_kerja8."/".$request->klasifikasi_arsip8."/".$tahun;
            $model->perihal= $request->get('perihal8');
            $model->save();
        }
       
        return redirect('surat_km')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $real_id = Crypt::decrypt($id);
        $model = \App\SuratKm::find($real_id);
        $model_rincian = null;
        switch ($model->jenis_surat) {
            case 2:
                $model_rincian = \App\SuratKmRincianSuratLuar::where('induk_id', '=', $real_id)->first();
                break;
            case 3:
                $model_rincian = \App\SuratKmRincianMemorandum::where('induk_id', '=', $real_id)->first();
                break;
            case 4:
                $model_rincian = \App\SuratKmRincianSuratPengantar::where('induk_id', '=', $real_id)->first();
                break;
            case 5:
                $model_rincian = \App\SuratKmRincianDisposisi::where('induk_id', '=', $real_id)->first();
                break;
            case 6:
                $model_rincian = \App\SuratKmRincianSuratKeputusan::where('induk_id', '=', $real_id)->first();
                break;
            case 7:
                $model_rincian = \App\SuratKmRincianSuratKeterangan::where('induk_id', '=', $real_id)->first();
                break;
            default:
        } 
        return view('surat_km.show', compact('model', 'id', 'model_rincian'));
    }

    public function print($id){
        $real_id = Crypt::decrypt($id);
        $model = \App\SuratKm::find($real_id);
        $model_rincian = null;
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model->kdprop.$model->kdkab)->first();
        $pdf = null;

        switch ($model->jenis_surat) {
            case 2:
                $model_rincian = \App\SuratKmRincianSuratLuar::where('induk_id', '=', $real_id)->first();
                $pdf = PDF::loadView('surat_km.print_surat_keluar', compact(
                            'real_id', 'model_rincian', 'model','unit_kerja'
                        ))->setPaper('a4');
                break;
            case 3:
                $model_rincian = \App\SuratKmRincianMemorandum::where('induk_id', '=', $real_id)->first();
                $pdf = PDF::loadView('surat_km.print_memorandum', compact(
                            'real_id', 'model_rincian', 'model','unit_kerja'
                        ))->setPaper('a4');
                break;
            case 4:
                $model_rincian = \App\SuratKmRincianSuratPengantar::where('induk_id', '=', $real_id)->first();
                $pdf = PDF::loadView('surat_km.print_surat_pengantar', compact(
                            'real_id', 'model_rincian', 'model','unit_kerja'
                        ))->setPaper('a4');
                break;
            case 5:
                $model_rincian = \App\SuratKmRincianDisposisi::where('induk_id', '=', $real_id)->first();
                $pdf = PDF::loadView('surat_km.print_disposisi', compact(
                            'real_id', 'model_rincian', 'model','unit_kerja'
                        ))->setPaper('a4');
                break;
            case 6:
                $model_rincian = \App\SuratKmRincianSuratKeputusan::where('induk_id', '=', $real_id)->first();
                $list_keputusan = \App\SuratKmRincianListKeputusan::where('induk_id', '=', $real_id)->get();
                $pdf = PDF::loadView('surat_km.print_surat_keputusan', compact(
                            'real_id', 'model_rincian', 'model','unit_kerja', 'list_keputusan'
                        ))->setPaper('a4');
                break;
            case 7:
                $model_rincian = \App\SuratKmRincianSuratKeterangan::where('induk_id', '=', $real_id)->first();
                $pdf = PDF::loadView('surat_km.print_surat_keterangan', compact(
                            'real_id', 'model_rincian', 'model','unit_kerja'
                        ))->setPaper('a4');
                break;
            default:
        }
        
        $nama_file = 'surat_'.$model->nomor.'.pdf';
        return $pdf->download($nama_file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $real_id = Crypt::decrypt($id);
        $model = \App\SuratKm::find($real_id);
        $model_rincian = null;
        $list_keputusan = [];
        switch ($model->jenis_surat) {
            case 2:
                $model_rincian = \App\SuratKmRincianSuratLuar::where('induk_id', '=', $real_id)->first();
                break;
            case 3:
                $model_rincian = \App\SuratKmRincianMemorandum::where('induk_id', '=', $real_id)->first();
                break;
            case 4:
                $model_rincian = \App\SuratKmRincianSuratPengantar::where('induk_id', '=', $real_id)->first();
                break;
            case 5:
                $model_rincian = \App\SuratKmRincianDisposisi::where('induk_id', '=', $real_id)->first();
                break;
            case 6:
                $model_rincian = \App\SuratKmRincianSuratKeputusan::where('induk_id', '=', $real_id)->first();
                $list_keputusan = \App\SuratKmRincianListKeputusan::where('induk_id', '=', $real_id)->get();
                break;
            case 7:
                $model_rincian = \App\SuratKmRincianSuratKeterangan::where('induk_id', '=', $real_id)->first();
                break;
            default:
        } 
        return view('surat_km.edit',compact('model','id', 'model_rincian', 'list_keputusan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuratKmRequest $request, $id){
        $real_id = Crypt::decrypt($id);

        if ($request->validator && $request->validator->fails()) {
            return redirect('surat_km/'.$id.'/edit')
                        ->withErrors($request->validator)
                        ->withInput();
        }

        try {
            $model = \App\SuratKm::find($real_id);
            if ($model === null) {
                return redirect('surat_km')->with('error', 'Data surat tidak ditemukan.');
            }

            $model->updated_by = Auth::id();
            $tanggal_format = date('Y-m-d');

            if($model->jenis_surat==1){
            if($request->has('tanggal1')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal1')));
            $bulan = date('m', strtotime($request->get('tanggal1')));
            $tahun = date('Y', strtotime($request->get('tanggal1')));

            $model->tanggal= date('Y-m-d', strtotime($request->get('tanggal1')));
            $model->alamat= $request->get('alamat1');
            $model->nomor= $request->get('nomor1');
            $model->perihal= $request->get('perihal1');
            // $model->nomor_petunjuk= $request->get('nomor_petunjuk');
            $model->penerima= $request->get('penerima1');
            $model->save();
        }
        else if($model->jenis_surat==2){
            if($request->has('tanggal2')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal2')));
        
            $bulan = date('m', strtotime($request->get('tanggal2')));
            $tahun = date('Y', strtotime($request->get('tanggal2')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut2;
            $model->tingkat_keamanan = $request->tingkat_keamanan2;
            $model->kode_unit_kerja = $request->kode_unit_kerja2;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip2;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut2."/".$request->kode_unit_kerja2."/".$request->klasifikasi_arsip2."/".$tahun;
            $model->perihal= $request->get('perihal2');
            $model->ditetapkan_oleh = $request->ditetapkan_oleh2;
            $model->ditetapkan_nama = $request->ditetapkan_nama2;
            if($model->save()){
                if(strlen($request->isi2)>0 && strlen($request->lampiran2)>0 && 
                    strlen($request->kepada2)>0 && 
                    strlen($request->kepada_di2)>0 && strlen($request->dibuat_di2)>0){

                    $model_rincian = \App\SuratKmRincianSuratLuar::where('induk_id', '=', $model->id)->first();
                    if($model_rincian==null){
                        $model_rincian = new \App\SuratKmRincianSuratLuar;
                        $model_rincian->induk_id = $model->id;
                    }

                    $model_rincian->isi = $request->isi2;
                    $model_rincian->lampiran = $request->lampiran2;
                    $model_rincian->kepada = $request->kepada2;
                    $model_rincian->kepada_di = $request->kepada_di2;
                    $model_rincian->dibuat_di = $request->dibuat_di2;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==3){
            if($request->has('tanggal3')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal3')));
        
            $bulan = date('m', strtotime($request->get('tanggal3')));
            $tahun = date('Y', strtotime($request->get('tanggal3')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut3;
            $model->perihal= $request->get('perihal3');
            $model->kode_unit_kerja = $request->kode_unit_kerja3;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip3;
            // @{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ kode_klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} 
            $model->nomor= $request->nomor_urut3."/".$request->kode_unit_kerja3."/".$request->klasifikasi_arsip3."/".$tahun;
            $model->ditetapkan_oleh = $request->ditetapkan_oleh3;
            $model->ditetapkan_nama = $request->ditetapkan_nama3;
            if($model->save()){
                if(strlen($request->dari3)>0 && strlen($request->isi3)>0 && 
                    strlen($request->kepada3)>0 && strlen($request->tembusan3)>0){
                    $model_rincian =\App\SuratKmRincianMemorandum::where('induk_id', '=', $model->id)->first();
                    if($model_rincian==null){
                        $model_rincian = new \App\SuratKmRincianMemorandum;
                        $model_rincian->induk_id = $model->id;
                    }
                    $model_rincian->dari = $request->dari3;
                    $model_rincian->isi = $request->isi3;
                    $model_rincian->kepada = $request->kepada3;
                    $model_rincian->tembusan = $request->tembusan3;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==4){
            if($request->has('tanggal4')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal4')));
        
            $bulan = date('m', strtotime($request->get('tanggal4')));
            $tahun = date('Y', strtotime($request->get('tanggal4')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut4;
            $model->tingkat_keamanan = $request->tingkat_keamanan4;
            $model->kode_unit_kerja = $request->kode_unit_kerja4;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip4;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut4."/".$request->kode_unit_kerja4."/".$request->klasifikasi_arsip4."/".$tahun;
            $model->ditetapkan_oleh = $request->ditetapkan_oleh4;
            $model->ditetapkan_nama = $request->ditetapkan_nama4;
            $model->ditetapkan_nip = $request->ditetapkan_nip4;
            if($model->save()){
                if(strlen($request->isi4)>0 && strlen($request->kepada4)>0 && 
                    strlen($request->kepada_di4)>0 && strlen($request->dibuat_di4)>0){
                    $model_rincian = \App\SuratKmRincianSuratPengantar::where('induk_id', '=', $model->id)->first();
                    if($model_rincian==null){
                        $model_rincian = new \App\SuratKmRincianSuratPengantar;
                        $model_rincian->induk_id = $model->id;
                    }
                    $model_rincian->isi = $request->isi4;
                    $model_rincian->kepada = $request->kepada4;
                    $model_rincian->kepada_di = $request->kepada_di4;
                    $model_rincian->diterima_tanggal = $request->diterima_tanggal4;
                    $model_rincian->diterima_jabatan = $request->diterima_jabatan4;
                    $model_rincian->diterima_nama = $request->diterima_nama4;
                    $model_rincian->diterima_nip = $request->diterima_nip4;
                    $model_rincian->diterima_no_hp = $request->diterima_no_hp4;
                    $model_rincian->dibuat_di = $request->dibuat_di4;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==5){
            if($request->has('tanggal5')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal5')));
        
            $bulan = date('m', strtotime($request->get('tanggal5')));
            $tahun = date('Y', strtotime($request->get('tanggal5')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut5;
            $model->tingkat_keamanan = $request->tingkat_keamanan5;
            $model->nomor= $request->nomor5;
            if($model->save()){
                if(strlen($request->isi5)>0 && strlen($request->nomor_agenda5)>0 && 
                    strlen($request->tanggal_penerimaan5)>0 && strlen($request->tanggal_penyelesaian5)>0
                    && strlen($request->dari5)>0 && strlen($request->isi5)>0){
                    $model_rincian = \App\SuratKmRincianDisposisi::where('induk_id', '=', $model->id)->first();
                    if($model_rincian==null){
                        $model_rincian = new \App\SuratKmRincianDisposisi;
                        $model_rincian->induk_id = $model->id;
                    }
                    $model_rincian->nomor_agenda = $request->nomor_agenda5;
                    $model_rincian->tanggal_penerimaan = date('Y-m-d', strtotime($request->tanggal_penerimaan5));
                    $model_rincian->tanggal_penyelesaian = date('Y-m-d', strtotime($request->tanggal_penyelesaian5));
                    $model_rincian->dari = $request->dari5;
                    $model_rincian->lampiran = $request->lampiran5;
                    $model_rincian->isi = $request->isi5;
                    $model_rincian->isi_disposisi = $request->isi_disposisi5;
                    $model_rincian->diteruskan_kepada = $request->diteruskan_kepada5;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==6){
            if($request->has('tanggal6')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal6')));
        
            $bulan = date('m', strtotime($request->get('tanggal6')));
            $tahun = date('Y', strtotime($request->get('tanggal6')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut6;
            $model->nomor= $request->nomor6;
            $model->ditetapkan_di= $request->ditetapkan_di6;
            $model->ditetapkan_tanggal= date('Y-m-d', strtotime($request->ditetapkan_tanggal6));
            $model->ditetapkan_oleh= $request->ditetapkan_oleh6;
            $model->ditetapkan_nama= $request->ditetapkan_nama6;
            if($model->save()){
                if(strlen((string) $request->tentang6)>0 && strlen((string) $request->menimbang6)>0 && 
                    strlen((string) $request->mengingat6)>0 && strlen((string) $request->menetapkan6)>0
                    && strlen((string) $request->tembusan6)>0 && strlen((string) $request->jumlah_keputusan)>0){
                    $model_rincian = \App\SuratKmRincianSuratKeputusan::where('induk_id', '=', $model->id)->first();
                    if($model_rincian==null){
                        $model_rincian = new \App\SuratKmRincianSuratKeputusan;
                        $model_rincian->induk_id = $model->id;
                    }
                    $model_rincian->tentang = $request->tentang6;
                    $model_rincian->menimbang = $request->menimbang6;
                    $model_rincian->mengingat = $request->mengingat6;
                    $model_rincian->menetapkan = $request->menetapkan6;
                    $model_rincian->tembusan = $request->tembusan6;
                    $model_rincian->save();
    
                    $jumlah_keputusan = $request->jumlah_keputusan;
                    for($i=0;$i<$jumlah_keputusan;$i++){
                        $current_id = $request->get("keputusan_".$i);
                        if($request->get("keputusan_isi".$current_id)!=''){
                            if(is_numeric($current_id)){
                                $model_keputusan = \App\SuratKmRincianListKeputusan::where('id', '=', $current_id)->first();
                                if($model_keputusan!=null){
                                    $model_keputusan->isi = $request->get("keputusan_isi".$current_id);
                                    $model_keputusan->save();
                                }
                            }
                            else{
                                $model_keputusan = new \App\SuratKmRincianListKeputusan;
                                $model_keputusan->induk_id = $model->id;
                                $model_keputusan->isi = $request->get("keputusan_isi".$current_id);
                                $model_keputusan->save();
                            }
                        }
                    } 
                }

            }
        }
        else if($model->jenis_surat==7){
            if($request->has('tanggal7')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal7')));
        
            $bulan = date('m', strtotime($request->get('tanggal7')));
            $tahun = date('Y', strtotime($request->get('tanggal7')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut7;
            $model->tingkat_keamanan = $request->tingkat_keamanan7;
            $model->kode_unit_kerja = $request->kode_unit_kerja7;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip7;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut7."/".$request->kode_unit_kerja7."/".$request->klasifikasi_arsip7."/".$tahun;
            $model->ditetapkan_di = $request->ditetapkan_di7;
            $model->ditetapkan_tanggal = date('Y-m-d', strtotime($request->ditetapkan_tanggal7));
            $model->ditetapkan_oleh = $request->ditetapkan_oleh7;
            $model->ditetapkan_nama = $request->ditetapkan_nama7;
            if($model->save()){
                if(strlen($request->isi)>0){
                    $model_rincian = \App\SuratKmRincianSuratKeterangan::where('induk_id', '=', $model->id)->first();
                    if($model_rincian==null){
                        $model_rincian = new \App\SuratKmRincianMemorandum;
                        $model_rincian->induk_id = $model->id;
                    }
                    $model_rincian->isi = $request->isi7;
                    $model_rincian->save();
                }
            }
        }
        else if($model->jenis_surat==8){
            if($request->has('tanggal8')) $tanggal_format = date('Y-m-d', strtotime($request->get('tanggal8')));
        
            $bulan = date('m', strtotime($request->get('tanggal8')));
            $tahun = date('Y', strtotime($request->get('tanggal8')));

            $model->tanggal= $tanggal_format;
            $model->nomor_urut= $request->nomor_urut8;
            $model->tingkat_keamanan = $request->tingkat_keamanan8;
            $model->kode_unit_kerja = $request->kode_unit_kerja8;
            $model->klasifikasi_arsip = $request->klasifikasi_arsip8;
            $model->nomor= $model->tingkat_keamanan."-".$request->nomor_urut8."/".$request->kode_unit_kerja8."/".$request->klasifikasi_arsip8."/".$tahun;
            $model->perihal= $request->get('perihal8');
            $model->ditetapkan_oleh = $request->ditetapkan_oleh8;
            $model->ditetapkan_nama = $request->ditetapkan_nama8;
            $model->save();
        }
            return redirect('surat_km')->with('success', 'Information has been updated');
        } catch (\Throwable $e) {
            report($e);

            return redirect('surat_km/'.$id.'/edit')
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\SuratKm::find($id);
        $model->delete();
        return redirect('surat_km')->with('success','Information has been  deleted');
    }
}