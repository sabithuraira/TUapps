<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratTugasRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use iio\libmergepdf\Merger;



class SuratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $keyword = $request->get('search');
        $month = '';
        $year = '';
        $unit_kerja = Auth::user()->kdprop.Auth::user()->kdkab;
        $type = 1;
        
        if(strlen($request->get('action'))>0) $type = $request->get('action');

        if(Auth::user()->kdkab=='00'){
            if(strlen($request->get('unit_kerja'))>0){
                $unit_kerja = Auth::user()->kdprop.$request->get('unit_kerja');
            }
        }
        
        $arr_where = [];

        if(strlen($request->get('month'))>0){
            $month = $request->get('month');
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $month];
        }
        
        if(strlen($request->get('year'))>0){
            $year = $request->get('year');
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $year];
        }

        if ($type == 2) {
            return Excel::download(new \App\Exports\SuratTugasExport($unit_kerja, $month, $year, $keyword), 'surat_tugas.xlsx');
        } else {
            $datas = \App\SuratTugasRincian::where($arr_where)
                ->where(
                    (function ($query) use ($unit_kerja) {
                        $query->where('unit_kerja', '=', $unit_kerja)
                            ->orWhere('unit_kerja_ttd', '=', $unit_kerja)
                            ->orWhere('unit_kerja_spd', '=', $unit_kerja);
                    })
                )
                ->where(
                    (function ($query) use ($keyword) {
                        $query->where('nama', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('tujuan_tugas', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('nomor_st', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->with('SuratIndukRel')
                ->orderBy('id', 'desc')
                ->paginate();

            $datas->withPath('surat_tugas');
            $datas->appends($request->all());
            $model = new \App\SuratTugasRincian;

            if(Auth::user()->kdkab=='00'){            
                $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                            ->where('kdkab','=',Auth::user()->kdkab)
                            ->where(
                                (function ($query) {
                                    $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                                }))->get();
            }
            else{
                $list_pejabat = \App\UserModel::where(
                            (function ($query) {
                                $query->where('kdprop', '=', config('app.kode_prov'))
                                    ->where('kdkab', '=', Auth::user()->kdkab)
                                    ->where(
                                        (function ($query) {
                                            $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                                        }));
                        }))
                        ->orWhere(
                            (function ($query) {
                                $query->where('kdprop', '=', config('app.kode_prov'))
                                    ->where('kdkab', '=', '00')
                                    ->where(
                                        (function ($query) {
                                            $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                                        }));}))->get();
            }
            // dd($datas);
            return view('surat_tugas.index', compact(
                'datas',
                'keyword',
                'model',
                'month',
                'year',
                'unit_kerja',
                'list_pejabat'
            ));
        }
    }

    public function daftar(Request $request){
        $keyword = $request->get('search');
        $datas = \App\SuratTugasRincian::where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
            ->where(
                (function ($query) use ($keyword) {
                    $query->where('nama', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tujuan_tugas', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('nomor_st', 'LIKE', '%' . $keyword . '%');
                })
            )
            ->orderBy('created_at', 'desc')
            ->paginate();

        $datas->withPath('surat_tugas/daftar');
        $datas->appends($request->all());

        return view('surat_tugas.daftar',compact('datas', 'keyword'));
    }

    public function calendar(Request $request){
        $unit_kerja = \App\UnitKerja::all();
        $cur_unit_kerja =  \App\UnitKerja::where('kode','=',config('app.kode_prov').Auth::user()->kdkab)->first()->id;
        return view('surat_tugas.calendar', compact(
            'unit_kerja', 'cur_unit_kerja'
        ));
    }

	public function listPegawai(Request $request){
        $kode_unit_kerja = config('app.kode_prov').'00';

        if(strlen($request->get('unit_kerja'))>0){
            $model_uk = \App\UnitKerja::find($request->get('unit_kerja'));
            if($model_uk!=null)
                $kode_unit_kerja = $model_uk->kode;
        }

        $datas = \App\UserModel::where('kdprop', '=', substr($kode_unit_kerja,0,2))
                    ->where('kdkab','=',substr($kode_unit_kerja,2))
                    ->get();

        return response()->json(['success'=>'1', 'datas'=>$datas]);
    }
    
	public function listkegiatan(Request $request){
        $month=1;
        if(strlen($request->get('month'))>0){
            $month = $request->get('month');
        }

        $model = new \App\SuratTugas();
        $data = $model->listKegiatanByMonth($month);

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $model= new \App\SuratTugas;
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab','=',Auth::user()->kdkab)->get();

        if(Auth::user()->kdkab=='00'){            
            $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                        ->where('kdkab','=',Auth::user()->kdkab)
                        ->where('is_active', '=', 1)
                        ->where(
                            (function ($query) {
                                $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                            }))->get();
        }
        else{
            $list_pejabat = \App\UserModel::where(
                        (function ($query) {
                            $query->where('kdprop', '=', config('app.kode_prov'))
                                ->where('kdkab', '=', Auth::user()->kdkab)
                                ->where('is_active', '=', 1)
                                ->where(
                                    (function ($query) {
                                        $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                                    }));
                    }))
                    ->orWhere(
                        (function ($query) {
                            $query->where('kdprop', '=', config('app.kode_prov'))
                                ->where('kdkab', '=', '00')
                                ->where('is_active', '=', 1)
                                ->where(
                                    (function ($query) {
                                        $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                                    }));}))->get();
        }
                    
        $tahun = date('Y');
        $list_anggaran = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop.Auth::user()->kdkab)->get();
        $list_anggaran_prov = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop.'00')->get();

        $model_rincian = new \App\SuratTugasRincian;

        return view('surat_tugas.create', 
            compact('list_pegawai', 'model', 'list_pejabat', 'model_rincian', 
                'list_anggaran', 'list_anggaran_prov'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratTugasRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_tugas/create')
                ->withErrors($validator)
                ->withInput();
        }
        $total_utama = $request->get('total_utama');

        $model = new \App\SuratTugas;
        $model->jenis_st = $request->get('jenis_st');
        $model->sumber_anggaran = $request->get('sumber_anggaran');
        $model->mak = $request->get('mak');
        $model->tugas = $request->get('tugas');

        $menimbang = "";
        if($request->get('menimbang')!=null && str_contains($request->get('menimbang'), '<p')){
            $menimbang = str_replace("<p", "<li", $request->get('menimbang'));
            $menimbang = str_replace("/p>", "/li>", $menimbang);
        }
        else{
            $menimbang = "<li>".$request->get('menimbang')."</li>";
        }
        $model->menimbang = $menimbang;

        $mengingat = "";
        if($request->get('mengingat')!=null && str_contains($request->get('mengingat'), '<p')){
            $mengingat = str_replace("<p", "<li", $request->get('mengingat'));
            $mengingat = str_replace("/p>", "/li>", $mengingat);
        }
        else{
            $mengingat = "<li>".$request->get('mengingat')."</li>";
        }
        $model->mengingat = $mengingat;

        $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
        $model->kategori = 1;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();

        if ($model->save()) {
            for ($i = 1; $i <= $total_utama; ++$i) {
                if (
                    strlen($request->get('u_namaau' . $i)) > 0 
                    && strlen($request->get('u_tanggal_mulaiau' . $i)) > 0 && strlen($request->get('u_tanggal_selesaiau' . $i)) > 0
                    && strlen($request->get('u_pejabat_ttd_nipau' . $i)) > 0 && strlen($request->get('u_pejabat_ttd_namaau' . $i)) > 0
                    && strlen($request->get('u_tingkat_biayaau' . $i)) > 0 && strlen($request->get('u_kendaraanau' . $i)) > 0
                    && strlen($request->get('u_jenis_petugasau' . $i)) > 0
                ) {

                    $model_r = new \App\SuratTugasRincian;
                    $model_r->id_surtug =  $model->id;
                    $model_r->nama   = $request->get('u_namaau' . $i);
                    $model_r->jenis_petugas = $request->get('u_jenis_petugasau' . $i);
                    if ($request->get('u_jenis_petugasau' . $i) == 1) {
                        $model_r->nip  = $request->get('u_nipau' . $i);
                        $model_r->jabatan = $request->get('u_jabatanau' . $i);
                    }
                    $model_r->tujuan_tugas  = $request->get('u_tujuan_tugasau' . $i);
                    $model_r->tanggal_mulai       = date('Y-m-d', strtotime($request->get('u_tanggal_mulaiau' . $i)));
                    $model_r->tanggal_selesai       = date('Y-m-d', strtotime($request->get('u_tanggal_selesaiau' . $i)));
                    $model_r->tingkat_biaya  = $request->get('u_tingkat_biayaau' . $i);
                    $model_r->kendaraan  = $request->get('u_kendaraanau' . $i);
                    $model_r->pejabat_ttd_nip  = $request->get('u_pejabat_ttd_nipau' . $i);
                    $model_r->pejabat_ttd_nama  = $request->get('u_pejabat_ttd_namaau' . $i);
                    $model_r->pejabat_ttd_jabatan  = $request->get('u_pejabat_ttd_jabatanau' . $i);

                    $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . Auth::user()->kdkab)->first();
                    if (Auth::user()->kdkab != '00' && $model->sumber_anggaran == 2) {
                        $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . '00')->first();
                    }

                    $model_r->ppk_nip  = $unit_kerja->ppk_nip;
                    $model_r->ppk_nama  = $unit_kerja->ppk_nama;
                    $model_r->bendahara_nip  = $unit_kerja->bendahara_nip;
                    $model_r->bendahara_nama  = $unit_kerja->bendahara_nama;
                    $model_r->ppspm_nip  = $unit_kerja->ppspm_nip;
                    $model_r->ppspm_nama  = $unit_kerja->ppspm_nama;
                    $model_r->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                    $model_r->unit_kerja_ttd  = $request->get('u_unit_kerja_ttdau' . $i);
                    $model_r->unit_kerja_spd = $unit_kerja->kode;
                    $model_r->kode_klasifikasi = $request->get('kode_klasifikasi');
                    ////////////////
                    $nomor_st = 1;
                    $nomor_spd = 1;

                    $datas = \App\SuratTugasRincian::where([
                            ['unit_kerja_ttd', '=', $model_r->unit_kerja_ttd],
                            // [DB::raw('YEAR(tanggal_mulai)'), '=', date('Y', strtotime($model_r->tanggal_mulai))],
                            [DB::raw('YEAR(created_at)'), '=', date('Y', strtotime($model->created_at))],
                        ])->orderBy('id', 'desc')->first();

                    if ($datas != null) {
                        // $exp_nomor_st = explode("/", $datas->nomor_st)[0];
                        $exp_nomor_st1 = explode("/", $datas->nomor_st)[0];
                        $exp_nomor_st = $exp_nomor_st1;
                        if(count(explode("-",$exp_nomor_st1))>1){
                            $exp_nomor_st = explode("-", $exp_nomor_st1)[1];
                        }

                        $prev_nomor_st = (int)$exp_nomor_st;
                        $nomor_st = $prev_nomor_st + 1;
                    }

                    // while (strlen($nomor_st) < 4)
                    //     $nomor_st = '0' . $nomor_st;

                    $model_r->nomor_st = 'B-' . $nomor_st . '/BPS' . $model_r->unit_kerja_ttd . '/' . $model_r->kode_klasifikasi .'/' . date('Y');

                    if ($model_r->jenis_petugas == 1 && $model->jenis_st != 3 && $model->jenis_st != 4) {
                        $datas_spd = \App\SuratTugasRincian::where([
                                ['nomor_spd', '<>', ''],
                                ['unit_kerja_spd', '=', $unit_kerja->kode],
                                // [DB::raw('YEAR(tanggal_mulai)'), '=', date('Y', strtotime($model_r->tanggal_mulai))],
                                [DB::raw('YEAR(created_at)'), '=', date('Y', strtotime($model->created_at))],
                            ])->orderBy('id', 'desc')->first();

                        if ($datas_spd != null) {
                            $exp_nomor_spd = explode("/", $datas_spd->nomor_spd)[0];
                            $exp_nomor_spd = explode(".", $exp_nomor_spd)[0];
                            $prev_nomor_spd = (int)$exp_nomor_spd;
                            $nomor_spd = $prev_nomor_spd + 1;
                        }

                        // while (strlen($nomor_spd) < 4)
                        //     $nomor_spd = '0' . $nomor_spd;
                    }
                   
                    //////////
                    if ($model_r->jenis_petugas == 1 && $model->jenis_st != 3 && $model->jenis_st != 4 && $model->sumber_anggaran != 3) {
                        $model_r->status_aktif = 1;
                        if (Auth::user()->kdkab != '00') {
                            if ($unit_kerja->kode == Auth::user()->kdprop . '00') {
                                $model_r->nomor_spd = $nomor_spd . '/' . Auth::user()->kdprop . '00/' . Auth::user()->kdprop . Auth::user()->kdkab . '/SPD/'  . $model_r->kode_klasifikasi .'/'. date('Y');
                            } else {
                                $model_r->nomor_spd = $nomor_spd . '/' . $unit_kerja->kode . '/SPD/' . $model_r->kode_klasifikasi .'/' . date('Y');
                            }
                        } else {
                            $model_r->nomor_spd = $nomor_spd . '/' . $unit_kerja->kode . '/SPD/' . $model_r->kode_klasifikasi .'/' . date('Y');
                        }
                    } else {
                        $model_r->status_aktif = 7;
                    }

                    $model_r->created_by = Auth::id();
                    $model_r->updated_by = Auth::id();
                    $model_r->save();
                }
            }
        }
        return redirect('surat_tugas')->with('success', 'Information has been added');
    }

    public function create_tim(){
        $model = new \App\SuratTugas;
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
            ->where('kdkab', '=', Auth::user()->kdkab)->get();

        if (Auth::user()->kdkab == '00') {
            $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                ->where('kdkab', '=', Auth::user()->kdkab)
                ->where(
                    (function ($query) {
                        $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                    })
                )->get();
        } else {
            $list_pejabat = \App\UserModel::where(
                (function ($query) {
                    $query->where('kdprop', '=', config('app.kode_prov'))
                        ->where('kdkab', '=', Auth::user()->kdkab)
                        ->where(
                            (function ($query) {
                                $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                            })
                        );
                })
            )
                ->orWhere(
                    (function ($query) {
                        $query->where('kdprop', '=', config('app.kode_prov'))
                            ->where('kdkab', '=', '00')
                            ->where(
                                (function ($query) {
                                    $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                                })
                            );
                    })
                )->get();
        }

        $tahun = date('Y');
        $list_anggaran = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop . Auth::user()->kdkab)->get();
        $list_anggaran_prov = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop . '00')->get();

        $model_rincian = new \App\SuratTugasRincian;

        return view(
            'surat_tugas.create_tim',
            compact(
                'list_pegawai',
                'model',
                'list_pejabat',
                'model_rincian',
                'list_anggaran',
                'list_anggaran_prov'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_tim(SuratTugasRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_tugas/create')
                ->withErrors($validator)
                ->withInput();
        }
        $total_utama = $request->get('total_utama');

        $model = new \App\SuratTugas;
        $model->jenis_st = $request->get('jenis_st');
        $model->sumber_anggaran = $request->get('sumber_anggaran');
        $model->mak = $request->get('mak');
        $model->tugas = $request->get('tugas');
        $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
        $model->kategori = 2;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();

        //////////PENOMORAN
        ////////////////
        $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . Auth::user()->kdkab)->first();
        if (Auth::user()->kdkab != '00' && $model->sumber_anggaran == 2) {
            $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . '00')->first();
        }

        $nomor_st = 1;
        $datas = \App\SuratTugasRincian::where([
                ['unit_kerja_ttd', '=', $request->get('unit_kerja_ttd')],
                [DB::raw('YEAR(created_at)'), '=', date('Y')],
                // [DB::raw('YEAR(tanggal_mulai)'), '=', date('Y', strtotime($request->get('tanggal_mulai')))],
            ])
            ->orderBy('id', 'desc')->first();

        if ($datas != null) {
            $exp_nomor_st1 = explode("/", $datas->nomor_st)[0];
            $exp_nomor_st = $exp_nomor_st1;
            if(count(explode("-",$exp_nomor_st1))>1){
                $exp_nomor_st = explode("-", $exp_nomor_st1)[1];
            }
            
            $prev_nomor_st = (int)$exp_nomor_st;
            $nomor_st = $prev_nomor_st + 1;
        }

        // while (strlen($nomor_st) < 4)
        //     $nomor_st = '0' . $nomor_st;
        ////////
        $nomor_spd = 1;
        $datas_spd = \App\SuratTugasRincian::where('nomor_spd', '<>', '')
            ->where([
                ['unit_kerja_spd', '=', $unit_kerja->kode],
                [DB::raw('YEAR(created_at)'), '=', date('Y')],
                // [DB::raw('YEAR(tanggal_mulai)'), '=', date('Y', strtotime($request->get('tanggal_mulai')))],
            ])->orderBy('id', 'desc')->first();

        if ($datas_spd != null) {
            $exp_nomor_spd = explode("/", $datas_spd->nomor_spd)[0];
            $exp_nomor_spd = explode(".", $exp_nomor_spd)[0];
            $prev_nomor_spd = (int)$exp_nomor_spd;
            $nomor_spd = $prev_nomor_spd + 1;
        }

        // while (strlen($nomor_spd) < 4)
        //     $nomor_spd = '0' . $nomor_spd;
        ////////////

        if ($model->save()) {
            $nomor_ujung_spd = 1;
            for ($i = 1; $i <= $total_utama; ++$i) {
                if (
                    strlen($request->get('u_namaau' . $i)) > 0 && strlen($request->get('u_tingkat_biayaau' . $i)) > 0
                    && strlen($request->get('u_kendaraanau' . $i)) > 0 && strlen($request->get('u_jenis_petugasau' . $i)) > 0
                ) {

                    $model_r = new \App\SuratTugasRincian;
                    $model_r->id_surtug =  $model->id;
                    $model_r->nama   = $request->get('u_namaau' . $i);
                    $model_r->jenis_petugas = $request->get('u_jenis_petugasau' . $i);
                    if ($request->get('u_jenis_petugasau' . $i) == 1) {
                        $model_r->nip  = $request->get('u_nipau' . $i);
                        $model_r->jabatan = $request->get('u_jabatanau' . $i);
                    }
                    $model_r->tujuan_tugas  = $request->get('tujuan_tugas');
                    $model_r->tanggal_mulai       = date('Y-m-d', strtotime($request->get('tanggal_mulai')));
                    $model_r->tanggal_selesai       = date('Y-m-d', strtotime($request->get('tanggal_selesai')));
                    $model_r->tingkat_biaya  = $request->get('u_tingkat_biayaau' . $i);
                    $model_r->kendaraan  = $request->get('u_kendaraanau' . $i);
                    $model_r->pejabat_ttd_nip  = $request->get('pejabat_ttd_nip');
                    $model_r->pejabat_ttd_nama  = $request->get('pejabat_ttd_nama');
                    $model_r->pejabat_ttd_jabatan  = $request->get('pejabat_ttd_jabatan');
                    $model_r->ppk_nip  = $unit_kerja->ppk_nip;
                    $model_r->ppk_nama  = $unit_kerja->ppk_nama;
                    $model_r->bendahara_nip  = $unit_kerja->bendahara_nip;
                    $model_r->bendahara_nama  = $unit_kerja->bendahara_nama;
                    $model_r->ppspm_nip  = $unit_kerja->ppspm_nip;
                    $model_r->ppspm_nama  = $unit_kerja->ppspm_nama;
                    $model_r->kode_klasifikasi = $request->get('kode_klasifikasi');

                    if ($i == 1) $model_r->kategori_petugas = 1;
                    else $model_r->kategori_petugas = 2;

                    $model_r->nomor_st = 'B-' . $nomor_st . '/BPS' . $request->get('unit_kerja_ttd') . '/' . $model_r->kode_klasifikasi .'/'. date('Y');

                    if ($model_r->jenis_petugas == 1 && $model->jenis_st != 3 && $model->jenis_st != 4) {
                        $model_r->status_aktif = 1;
                        // if($unit_kerja->kode==Auth::user()->kdprop.'00')
                        //     $model_r->nomor_spd = $nomor_spd.'.'.$nomor_ujung_spd.'/'.$unit_kerja->kode.'/SPD/'.date('m').'/'.date('Y');
                        // else
                        //     $model_r->nomor_spd = $nomor_spd.'.'.$nomor_ujung_spd.'/'.Auth::user()->kdprop.'00/'.$unit_kerja->kode.'/SPD/'.date('m').'/'.date('Y');
                        if (Auth::user()->kdkab != '00') {
                            if ($unit_kerja->kode == Auth::user()->kdprop . '00') {
                                $model_r->nomor_spd = $nomor_spd . '.' . $nomor_ujung_spd . '/' . Auth::user()->kdprop . '00/' . Auth::user()->kdprop . Auth::user()->kdkab . '/SPD/'  . $model_r->kode_klasifikasi .'/'  . date('Y');
                            } else {
                                $model_r->nomor_spd = $nomor_spd . '.' . $nomor_ujung_spd . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                            }
                        } else {
                            $model_r->nomor_spd = $nomor_spd . '.' . $nomor_ujung_spd . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                        }

                        $nomor_ujung_spd++;
                    } else {
                        $model_r->status_aktif = 7;
                    }

                    $model_r->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                    $model_r->unit_kerja_ttd  = $request->get('unit_kerja_ttd');
                    $model_r->unit_kerja_spd = $unit_kerja->kode;
                    $model_r->created_by = Auth::id();
                    $model_r->updated_by = Auth::id();
                    $model_r->save();
                }
            }
        }
        return redirect('surat_tugas')->with('success', 'Information has been added');
    }

    public function create_pelatihan(){
        $model = new \App\SuratTugas;
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
            ->where('kdkab', '=', Auth::user()->kdkab)->get();

        if (Auth::user()->kdkab == '00') {
            $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                ->where('kdkab', '=', Auth::user()->kdkab)
                ->where((function ($query) {
                    $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                }))->get();
        } else {
            $list_pejabat = \App\UserModel::where(
                (function ($query) {
                    $query->where('kdprop', '=', config('app.kode_prov'))
                        ->where('kdkab', '=', Auth::user()->kdkab)
                        ->where((function ($query) {
                            $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                        }));
                })
            )
                ->orWhere(
                    (function ($query) {
                        $query->where('kdprop', '=', config('app.kode_prov'))
                            ->where('kdkab', '=', '00')
                            ->where((function ($query) {
                                $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                            }));
                    })
                )->get();
        }

        $tahun = date('Y');
        $list_anggaran = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop . Auth::user()->kdkab)->get();
        $list_anggaran_prov = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop . '00')->get();
        $list_unit_kerja = \App\UnitKerja::orderBy('kode')->get();
        $model_rincian = new \App\SuratTugasRincian;
        $model_pelatihan = new \App\SuratTugasPesertaPelatihan;

        $list_pegawai = [];
        foreach ($list_unit_kerja as $key => $value) {
            $list_pegawai[$value->kode] = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                ->where('kdkab', '=', substr($value->kode, 2))->get();
        }

        return view(
            'surat_tugas.create_pelatihan',
            compact(
                'list_pegawai',
                'model',
                'list_pejabat',
                'model_rincian',
                'list_anggaran',
                'list_anggaran_prov',
                'model_pelatihan',
                'list_unit_kerja'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_pelatihan(SuratTugasRequest $request){
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_tugas/create')
                ->withErrors($validator)
                ->withInput();
        }

        $total_peserta = $request->get('total_peserta');
        $total_pengajar = $request->get('total_pengajar');
        $total_panitia = $request->get('total_panitia');

        $model = new \App\SuratTugas;
        $model->jenis_st = 5;
        $model->sumber_anggaran = $request->get('sumber_anggaran');
        $model->mak = $request->get('mak');
        $model->tugas = $request->get('tugas');
        $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
        $model->kategori = 3;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();

        //////////PENOMORAN
        ////////////////
        $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . Auth::user()->kdkab)->first();
        if (Auth::user()->kdkab != '00' && $model->sumber_anggaran == 2) {
            $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . '00')->first();
        }

        $nomor_st = 1;
        $datas = \App\SuratTugasRincian::where([
                ['unit_kerja_ttd', '=', $request->get('unit_kerja_ttd')],
                [DB::raw('YEAR(created_at)'), '=', date('Y')],
                // [DB::raw('YEAR(tanggal_mulai)'), '=', date('Y', strtotime($request->get('tanggal_mulai')))],
            ])
            ->orderBy('id', 'desc')->first();

        if ($datas != null) {
            // $exp_nomor_st = explode("/", $datas->nomor_st)[0];
            $exp_nomor_st1 = explode("/", $datas->nomor_st)[0];
            $exp_nomor_st = $exp_nomor_st1;
            if(count(explode("-",$exp_nomor_st1))>1){
                $exp_nomor_st = explode("-", $exp_nomor_st1)[1];
            }

            $prev_nomor_st = (int)$exp_nomor_st;
            $nomor_st = $prev_nomor_st + 1;
        }
        ////////
        $nomor_spd = 1;
        $datas_spd = \App\SuratTugasRincian::where('nomor_spd', '<>', '')
            ->where([
                ['unit_kerja_spd', '=', $unit_kerja->kode],
                [DB::raw('YEAR(created_at)'), '=', date('Y')],
                // [DB::raw('YEAR(tanggal_mulai)'), '=', date('Y', strtotime($request->get('tanggal_mulai')))],
            ])->orderBy('id', 'desc')->first();

        if ($datas_spd != null) {
            $exp_nomor_spd = explode("/", $datas_spd->nomor_spd)[0];
            $exp_nomor_spd = explode(".", $exp_nomor_spd)[0];
            $prev_nomor_spd = (int)$exp_nomor_spd;
            $nomor_spd = $prev_nomor_spd + 1;
        }
        ////////////

        if ($model->save()) {
            if ($total_peserta > 1) {
                /////////RINCIAN PESERTA
                $model_r = new \App\SuratTugasRincian;
                $model_r->id_surtug =  $model->id;
                $model_r->nama   = "PESERTA " . $model->tugas;
                $model_r->jenis_petugas = 0;
                $model_r->tujuan_tugas  = $request->get('tujuan_tugas');
                $model_r->tanggal_mulai       = date('Y-m-d', strtotime($request->get('tanggal_mulai')));
                $model_r->tanggal_selesai       = date('Y-m-d', strtotime($request->get('tanggal_selesai')));
                $model_r->tingkat_biaya  = 0;
                $model_r->kendaraan  = 0;
                $model_r->pejabat_ttd_nip  = $request->get('pejabat_ttd_nip');
                $model_r->pejabat_ttd_nama  = $request->get('pejabat_ttd_nama');
                $model_r->pejabat_ttd_jabatan  = $request->get('pejabat_ttd_jabatan');
                $model_r->ppk_nip  = $unit_kerja->ppk_nip;
                $model_r->ppk_nama  = $unit_kerja->ppk_nama;
                $model_r->bendahara_nip  = $unit_kerja->bendahara_nip;
                $model_r->bendahara_nama  = $unit_kerja->bendahara_nama;
                $model_r->ppspm_nip  = $unit_kerja->ppspm_nip;
                $model_r->ppspm_nama  = $unit_kerja->ppspm_nama;
                $model_r->kode_klasifikasi = $request->get('kode_klasifikasi');

                $nomor_st_label = $nomor_st;
                $nomor_spd_label = $nomor_spd;
                // while (strlen($nomor_st_label) < 4)
                //     $nomor_st_label = '0' . $nomor_st_label;
                // while (strlen($nomor_spd_label) < 4)
                //     $nomor_spd_label = '0' . $nomor_spd_label;

                $model_r->nomor_st = 'B-' . $nomor_st_label . '/BPS' . $request->get('unit_kerja_ttd') . '/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                $model_r->status_aktif = 1;
                if (Auth::user()->kdkab != '00') {
                    if ($unit_kerja->kode == Auth::user()->kdprop . '00')
                        $model_r->nomor_spd = $nomor_spd_label . '/' . Auth::user()->kdprop . '00/' . Auth::user()->kdprop . Auth::user()->kdkab . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                    else
                        $model_r->nomor_spd = $nomor_spd_label . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/'. date('Y');
                } else {
                    $model_r->nomor_spd = $nomor_spd_label . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/'. date('Y');
                }
                $model_r->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                $model_r->unit_kerja_ttd  = $request->get('unit_kerja_ttd');
                $model_r->unit_kerja_spd = $unit_kerja->kode;
                $model_r->created_by = Auth::id();
                $model_r->updated_by = Auth::id();
                $model_r->save();
                $nomor_st++;
                $nomor_spd++;
            }
            //////////
            /////////RINCIAN PENGAJAR
            if ($total_pengajar > 1) {
                $model_r2 = new \App\SuratTugasRincian;
                $model_r2->id_surtug =  $model->id;
                $model_r2->nama   = "PENGAJAR " . $model->tugas;
                $model_r2->jenis_petugas = 0;
                $model_r2->tujuan_tugas  = $request->get('tujuan_tugas');
                $model_r2->tanggal_mulai       = date('Y-m-d', strtotime($request->get('tanggal_mulai')));
                $model_r2->tanggal_selesai       = date('Y-m-d', strtotime($request->get('tanggal_selesai')));
                $model_r2->tingkat_biaya  = 0;
                $model_r2->kendaraan  = 0;
                $model_r2->pejabat_ttd_nip  = $request->get('pejabat_ttd_nip');
                $model_r2->pejabat_ttd_nama  = $request->get('pejabat_ttd_nama');
                $model_r2->pejabat_ttd_jabatan  = $request->get('pejabat_ttd_jabatan');
                $model_r2->ppk_nip  = $unit_kerja->ppk_nip;
                $model_r2->ppk_nama  = $unit_kerja->ppk_nama;
                $model_r2->bendahara_nip  = $unit_kerja->bendahara_nip;
                $model_r2->bendahara_nama  = $unit_kerja->bendahara_nama;
                $model_r2->ppspm_nip  = $unit_kerja->ppspm_nip;
                $model_r2->ppspm_nama  = $unit_kerja->ppspm_nama;

                $nomor_st_label = $nomor_st;
                $nomor_spd_label = $nomor_spd;
                // while (strlen($nomor_st_label) < 4)
                //     $nomor_st_label = '0' . $nomor_st_label;
                // while (strlen($nomor_spd_label) < 4)
                //     $nomor_spd_label = '0' . $nomor_spd_label;

                $model_r2->nomor_st = 'B-' . $nomor_st . '/BPS' . $request->get('unit_kerja_ttd') . '/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                $model_r2->status_aktif = 1;
                if (Auth::user()->kdkab != '00') {
                    if ($unit_kerja->kode == Auth::user()->kdprop . '00')
                        $model_r2->nomor_spd = $nomor_spd . '/' . Auth::user()->kdprop . '00/' . Auth::user()->kdprop . Auth::user()->kdkab . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                    else
                        $model_r2->nomor_spd = $nomor_spd . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/'.date('Y');
                } else {
                    $model_r2->nomor_spd = $nomor_spd . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/'. date('Y');
                }
                $model_r2->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                $model_r2->unit_kerja_ttd  = $request->get('unit_kerja_ttd');
                $model_r2->unit_kerja_spd = $unit_kerja->kode;
                $model_r2->created_by = Auth::id();
                $model_r2->updated_by = Auth::id();
                $model_r2->save();
                $nomor_st++;
                $nomor_spd++;
            }
            //////
            /////////RINCIAN PANITIA
            if ($total_panitia > 1) {
                $model_r3 = new \App\SuratTugasRincian;
                $model_r3->id_surtug =  $model->id;
                $model_r3->nama   = "PANITIA " . $model->tugas;
                $model_r3->jenis_petugas = 0;
                $model_r3->tujuan_tugas  = $request->get('tujuan_tugas');
                $model_r3->tanggal_mulai       = date('Y-m-d', strtotime($request->get('tanggal_mulai')));
                $model_r3->tanggal_selesai       = date('Y-m-d', strtotime($request->get('tanggal_selesai')));
                $model_r3->tingkat_biaya  = 0;
                $model_r3->kendaraan  = 0;
                $model_r3->pejabat_ttd_nip  = $request->get('pejabat_ttd_nip');
                $model_r3->pejabat_ttd_nama  = $request->get('pejabat_ttd_nama');
                $model_r3->pejabat_ttd_jabatan  = $request->get('pejabat_ttd_jabatan');
                $model_r3->ppk_nip  = $unit_kerja->ppk_nip;
                $model_r3->ppk_nama  = $unit_kerja->ppk_nama;
                $model_r3->bendahara_nip  = $unit_kerja->bendahara_nip;
                $model_r3->bendahara_nama  = $unit_kerja->bendahara_nama;
                $model_r3->ppspm_nip  = $unit_kerja->ppspm_nip;
                $model_r3->ppspm_nama  = $unit_kerja->ppspm_nama;

                $nomor_st_label = $nomor_st;
                $nomor_spd_label = $nomor_spd;
                // while (strlen($nomor_st_label) < 4)
                //     $nomor_st_label = '0' . $nomor_st_label;
                // while (strlen($nomor_spd_label) < 4)
                //     $nomor_spd_label = '0' . $nomor_spd_label;

                $model_r3->nomor_st = 'B-' . $nomor_st . '/BPS' . $request->get('unit_kerja_ttd') . '/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                $model_r3->status_aktif = 1;
                if (Auth::user()->kdkab != '00') {
                    if ($unit_kerja->kode == Auth::user()->kdprop . '00')
                        $model_r3->nomor_spd = $nomor_spd . '/' . Auth::user()->kdprop . '00/' . Auth::user()->kdprop . Auth::user()->kdkab . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                    else
                        $model_r3->nomor_spd = $nomor_spd . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                } else {
                    $model_r3->nomor_spd = $nomor_spd . '/' . $unit_kerja->kode . '/SPD/'  . $model_r->kode_klasifikasi .'/' . date('Y');
                }
                $model_r3->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                $model_r3->unit_kerja_ttd  = $request->get('unit_kerja_ttd');
                $model_r3->unit_kerja_spd = $unit_kerja->kode;
                $model_r3->created_by = Auth::id();
                $model_r3->updated_by = Auth::id();
                $model_r3->save();
            }
            //////
            for ($i = 1; $i <= $total_peserta; ++$i) {
                if (
                    strlen($request->get('peserta_namaau' . $i)) > 0 && strlen($request->get('peserta_tingkat_biayaau' . $i)) > 0
                    && strlen($request->get('peserta_kendaraanau' . $i)) > 0 && strlen($request->get('peserta_jenis_pesertaau' . $i)) > 0
                    && strlen($request->get('peserta_jabatan_pelatihanau' . $i)) > 0
                ) {
                    $model_p = new \App\SuratTugasPesertaPelatihan;
                    $model_p->id_surtug =   $model_r->id;
                    $model_p->nip = $request->get('peserta_nipau' . $i);
                    $model_p->nama   = $request->get('peserta_namaau' . $i);
                    $model_p->gol = $request->get('peserta_golau' . $i);
                    $model_p->jabatan = $request->get('peserta_jabatanau' . $i);
                    $model_p->jabatan_pelatihan = $request->get('peserta_jabatan_pelatihanau' . $i);
                    $model_p->asal_daerah = $request->get('peserta_asal_daerahau' . $i);
                    $model_p->unit_kerja = $request->get('peserta_unit_kerjaau' . $i);
                    $model_p->jenis_peserta = $request->get('peserta_jenis_pesertaau' . $i);
                    $model_p->tingkat_biaya = $request->get('peserta_tingkat_biayaau' . $i);
                    $model_p->kendaraan = $request->get('peserta_kendaraanau' . $i);
                    $model_p->kategori_peserta = 1;
                    $model_p->created_by = Auth::id();
                    $model_p->updated_by = Auth::id();
                    $model_p->save();
                }
            }

            for ($i = 1; $i <= $total_pengajar; ++$i) {
                if (
                    strlen($request->get('pengajar_namaau' . $i)) > 0 && strlen($request->get('pengajar_tingkat_biayaau' . $i)) > 0
                    && strlen($request->get('pengajar_kendaraanau' . $i)) > 0 && strlen($request->get('pengajar_jenis_pesertaau' . $i)) > 0
                    && strlen($request->get('pengajar_jabatan_pelatihanau' . $i)) > 0
                ) {
                    $model_p = new \App\SuratTugasPesertaPelatihan;
                    $model_p->id_surtug =   $model_r2->id;
                    $model_p->nip = $request->get('pengajar_nipau' . $i);
                    $model_p->nama   = $request->get('pengajar_namaau' . $i);
                    $model_p->gol = $request->get('pengajar_golau' . $i);
                    $model_p->jabatan = $request->get('pengajar_jabatanau' . $i);
                    $model_p->jabatan_pelatihan = $request->get('pengajar_jabatan_pelatihanau' . $i);
                    $model_p->asal_daerah = $request->get('pengajar_asal_daerahau' . $i);
                    $model_p->unit_kerja = $request->get('pengajar_unit_kerjaau' . $i);
                    $model_p->jenis_peserta = $request->get('pengajar_jenis_pesertaau' . $i);
                    $model_p->tingkat_biaya = $request->get('peserta_tingkat_biayaau' . $i);
                    $model_p->kendaraan = $request->get('pengajar_kendaraanau' . $i);
                    $model_p->kategori_peserta = 2;
                    $model_p->created_by = Auth::id();
                    $model_p->updated_by = Auth::id();
                    $model_p->save();
                }
            }

            for ($i = 1; $i <= $total_panitia; ++$i) {
                if (
                    strlen($request->get('panitia_namaau' . $i)) > 0 && strlen($request->get('panitia_tingkat_biayaau' . $i)) > 0
                    && strlen($request->get('panitia_kendaraanau' . $i)) > 0 && strlen($request->get('panitia_jenis_pesertaau' . $i)) > 0
                    && strlen($request->get('panitia_jabatan_pelatihanau' . $i)) > 0
                ) {
                    $model_p = new \App\SuratTugasPesertaPelatihan;
                    $model_p->id_surtug =   $model_r3->id;
                    $model_p->nip = $request->get('panitia_nipau' . $i);
                    $model_p->nama   = $request->get('panitia_namaau' . $i);
                    $model_p->gol = $request->get('panitia_golau' . $i);
                    $model_p->jabatan = $request->get('panitia_jabatanau' . $i);
                    $model_p->jabatan_pelatihan = $request->get('panitia_jabatan_pelatihanau' . $i);
                    $model_p->asal_daerah = $request->get('panitia_asal_daerahau' . $i);
                    $model_p->unit_kerja = $request->get('panitia_unit_kerjaau' . $i);
                    $model_p->jenis_peserta = $request->get('panitia_jenis_pesertaau' . $i);
                    $model_p->tingkat_biaya = $request->get('peserta_tingkat_biayaau' . $i);
                    $model_p->kendaraan = $request->get('panitia_kendaraanau' . $i);
                    $model_p->kategori_peserta = 3;
                    $model_p->created_by = Auth::id();
                    $model_p->updated_by = Auth::id();
                    $model_p->save();
                }
            }
        }
        return redirect('surat_tugas')->with('success', 'Information has been added');
    }

    public function insert_kwitansi($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $model_kwitansi = \App\SuratTugasKwitansi::where('id_surtug_pegawai', '=', $real_id)->get();

        if ($model_rincian->status_aktif != 2) {
            return view('surat_tugas.insert_kwitansi', compact(
                'model',
                'id',
                'real_id',
                'model_rincian',
                'model_kwitansi'
            ));
        } else {
            abort(403, 'Data telah dibatalkan, permintaan tidak diberikan');
        }
    }

    public function store_kwitansi(Request $request, $id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);

        $total_utama = $request->get('total_utama');

        $datas = \App\SuratTugasKwitansi::where('id_surtug_pegawai', '=', $real_id)->get();
        foreach ($datas as $data) {
            if (
                strlen($request->get('u_rincian' . $data->id)) > 0 && strlen($request->get('u_anggaran' . $data->id)) > 0
                && strlen($request->get('u_is_rill' . $data->id)) > 0
            ) {
                $model_kw = \App\SuratTugasKwitansi::find($data->id);
                $model_kw->rincian   = $request->get('u_rincian' . $data->id);
                $model_kw->anggaran = $request->get('u_anggaran' . $data->id);
                $model_kw->is_rill  = $request->get('u_is_rill' . $data->id);
                $model_kw->updated_by = Auth::id();
                $model_kw->save();
            }
        }

        for ($i = 1; $i <= $total_utama; ++$i) {
            if (
                strlen($request->get('u_rincianau' . $i)) > 0 && strlen($request->get('u_anggaranau' . $i)) > 0
                && strlen($request->get('u_is_rillau' . $i)) > 0
            ) {

                $model_r = new \App\SuratTugasKwitansi;
                $model_r->id_surtug =  $model->id;
                $model_r->id_surtug_pegawai  = $model_rincian->id;
                $model_r->rincian   = $request->get('u_rincianau' . $i);
                $model_r->anggaran = $request->get('u_anggaranau' . $i);
                $model_r->is_rill  = $request->get('u_is_rillau' . $i);
                $model_r->created_by = Auth::id();
                $model_r->updated_by = Auth::id();
                $model_r->save();
            }
        }

        return redirect('surat_tugas')->with('success', 'Information has been added');
    }

    public function insert_kwitansi_pelatihan($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $mak = \App\MataAnggaran::where('id', '=', $model->mak)->first();
        $list_anggota = \App\SuratTugasPesertaPelatihan::where('id_surtug', '=', $real_id)->get();

        if ($model_rincian->status_aktif != 2) {
            return view('surat_tugas.insert_kwitansi_pelatihan', compact(
                'model',
                'id',
                'real_id',
                'model_rincian',
                'mak',
                'list_anggota'
            ));
        } else {
            abort(403, 'Data telah dibatalkan, permintaan tidak diberikan');
        }
    }

    public function store_kwitansi_pelatihan(Request $request, $id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $mak = \App\MataAnggaran::where('id', '=', $model->mak)->first();
        $list_anggota = \App\SuratTugasPesertaPelatihan::where('id_surtug', '=', $real_id)->get();

        foreach ($list_anggota as $key => $value) {
            $value->biaya_perjadin = $request->get('biaya_perjadin' . $value->id);
            $value->biaya_fullboard = $request->get('biaya_fullboard' . $value->id);
            $value->transport_pergi = $request->get('transport_pergi' . $value->id);
            $value->transport_pulang = $request->get('tranposrt_pulang' . $value->id);
            $value->save();
        }
        return redirect('surat_tugas')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
    }

    public function print_st($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $user_ttd = \App\UserModel::where('nip_baru', '=', $model_rincian->pejabat_ttd_nip)->first();
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja)->first();
        $unit_kerja_ttd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_ttd)->first();
        $list_anggota = \App\SuratTugasRincian::where('id_surtug', '=', $model->id)
            ->where('kategori_petugas', '=', 2)->get();
        $ketua = \App\SuratTugasRincian::where('id_surtug', '=', $model->id)
            ->where('kategori_petugas', '=', 1)->first();

        // $pdf = PDF::loadView('surat_tugas.print_st', compact(
        //     'real_id',
        //     'model_rincian',
        //     'model',
        //     'unit_kerja',
        //     'unit_kerja_ttd',
        //     'list_anggota',
        //     'ketua',
        //     'user_ttd'
        // ))->setPaper('a4', 'potrait');

        // $nama_file = 'st_' . $model_rincian->nomor_st . '.pdf';
        // return $pdf->download($nama_file);

        return view('surat_tugas.print_st',compact(
                'real_id',
                'model_rincian',
                'model',
                'unit_kerja',
                'unit_kerja_ttd',
                'list_anggota',
                'ketua',
                'user_ttd'
            ));
    }

    public function print_st_pelatihan($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $user_ttd = \App\UserModel::where('nip_baru', '=', $model_rincian->pejabat_ttd_nip)->first();
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja)->first();
        $unit_kerja_ttd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_ttd)->first();
        $list_anggota = \App\SuratTugasPesertaPelatihan::where('id_surtug', '=', $real_id)->get();

        $pdf = PDF::loadView('surat_tugas.print_st_pelatihan', compact(
            'real_id',
            'model_rincian',
            'model',
            'unit_kerja',
            'unit_kerja_ttd',
            'list_anggota',
            'user_ttd'
        ))->setPaper('a4', 'potrait');

        $nama_file = 'st_' . $model_rincian->nomor_st . '.pdf';
        return $pdf->download($nama_file);
        // return view('surat_tugas.print_st_pelatihan',compact('real_id', 
        //     'model_rincian', 'model', 'unit_kerja', 'unit_kerja_ttd', 
        //     'list_anggota'));
    }

    public function print_spd($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja)->first();
        $unit_kerja_ttd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_ttd)->first();
        $unit_kerja_spd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_spd)->first();
        $pegawai = \App\UserModel::where('nip_baru', '=', $model_rincian->nip)->first();
        $mak = \App\MataAnggaran::where('id', '=', $model->mak)->first();

        $pdf = PDF::loadView('surat_tugas.print_spd', compact(
            'real_id',
            'model_rincian',
            'model',
            'unit_kerja',
            'unit_kerja_spd',
            'unit_kerja_ttd',
            'pegawai',
            'mak'
        ))->setPaper('a4', 'potrait');

        $nama_file = 'spd_' . $model_rincian->nomor_spd . '.pdf';
        return $pdf->download($nama_file);

        // return view('surat_tugas.print_spd',compact('real_id', 
        //     'model_rincian', 'model', 'unit_kerja', 'unit_kerja_spd', 'pegawai', 'mak'));
    }

    public function print_spd_pelatihan($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja)->first();
        $unit_kerja_ttd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_ttd)->first();
        $unit_kerja_spd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_spd)->first();
        $pegawai = \App\UserModel::where('nip_baru', '=', $model_rincian->nip)->first();
        $mak = \App\MataAnggaran::where('id', '=', $model->mak)->first();
        $list_anggota = \App\SuratTugasPesertaPelatihan::where('id_surtug', '=', $real_id)->get();

        $m = new Merger();
        $pdf = PDF::loadView('surat_tugas.print_spd_pelatihan', compact(
            'real_id',
            'model_rincian',
            'model',
            'unit_kerja',
            'unit_kerja_spd',
            'unit_kerja_ttd',
            'pegawai',
            'mak'
        ))->setPaper('a4', 'potrait');

        // $nama_file = 'spd_'.$model_rincian->nomor_spd.'.pdf';
        // return $pdf->download($nama_file);
        // $pdf->render();
        $m->addRaw($pdf->output());

        $pdf2 = PDF::loadView('surat_tugas.print_spd_pelatihan_lampiran', compact(
            'real_id',
            'model_rincian',
            'model',
            'unit_kerja',
            'unit_kerja_spd',
            'unit_kerja_ttd',
            'pegawai',
            'mak',
            'list_anggota'
        ))->setPaper('a4', 'landscape');

        $nama_file = 'spd_' . $model_rincian->nomor_spd . '.pdf';
        $m->addRaw($pdf2->output());
        return response($m->merge())
            ->withHeaders([
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'attachment; filename="' . $nama_file,
            ]);
    }

    public function print_kwitansi($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $model_kwitansi = \App\SuratTugasKwitansi::where([
            ['id_surtug_pegawai', '=', $real_id], ['is_rill', '=', 0]
        ])->get();

        $model_kwitansi_rill = \App\SuratTugasKwitansi::where([
            ['id_surtug_pegawai', '=', $real_id], ['is_rill', '=', 1]
        ])->get();

        $model_kwitansi_rill_total = \App\SuratTugasKwitansi::where([
            ['id_surtug_pegawai', '=', $real_id], ['is_rill', '=', 1]
        ])->sum('anggaran');
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja)->first();
        $unit_kerja_spd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_spd)->first();
        if ($model->sumber_anggaran == 2)
            $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . '00')->first();
        $pegawai = \App\UserModel::where('nip_baru', '=', $model_rincian->nip)->first();
        $mak = \App\MataAnggaran::where('id', '=', $model->mak)->first();

        $pdf = PDF::loadView('surat_tugas.print_kwitansi', compact(
            'real_id',
            'model_rincian',
            'model',
            'model_kwitansi',
            'model_kwitansi_rill',
            'unit_kerja',
            'unit_kerja_spd',
            'model_kwitansi_rill_total',
            'pegawai',
            'mak'
        ))->setPaper('a4', 'potrait');

        $nama_file = 'kwitansi_' . $model_rincian->nomor_spd . '.pdf';
        return $pdf->download($nama_file);

        // return view('surat_tugas.print_kwitansi',compact('real_id', 
        //     'model_rincian', 'model_kwitansi', 'model_kwitansi_rill',
        //     'model_kwitansi_rill_total', 'model', 
        //     'unit_kerja', 'pegawai', 'mak'));
    }

    public function print_kwitansi_pelatihan($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $unit_kerja = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja)->first();
        $unit_kerja_spd = \App\UnitKerja::where('kode', '=', $model_rincian->unit_kerja_spd)->first();
        if ($model->sumber_anggaran == 2)
            $unit_kerja = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . '00')->first();
        $mak = \App\MataAnggaran::where('id', '=', $model->mak)->first();
        $list_anggota = \App\SuratTugasPesertaPelatihan::where('id_surtug', '=', $real_id)->get();

        $pdf = PDF::loadView('surat_tugas.print_kwitansi_pelatihan', compact(
            'real_id',
            'model_rincian',
            'model',
            'unit_kerja',
            'unit_kerja_spd',
            'mak',
            'list_anggota'
        ))->setPaper('a4', 'landscape');

        $nama_file = 'kwitansi_' . $model_rincian->nomor_spd . '.pdf';
        return $pdf->download($nama_file);
        // return view('surat_tugas.print_kwitansi_pelatihan',compact('real_id', 
        //     'model_rincian', 'model', 
        //     'unit_kerja', 'unit_kerja_spd', 'mak', 'list_anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);

        if ($model_rincian->status_aktif != 2) {
            $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))->where('kdkab', '=', Auth::user()->kdkab)->get();

            if (Auth::user()->kdkab == '00') {
                $list_pejabat = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
                    ->where('kdkab', '=', Auth::user()->kdkab)
                    ->where(
                        (function ($query) {
                            $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                        })
                    )->get();
            } else {
                $list_pejabat = \App\UserModel::where(
                    (function ($query) {
                        $query->where('kdprop', '=', config('app.kode_prov'))
                            ->where('kdkab', '=', Auth::user()->kdkab)
                            ->where(
                                (function ($query) {
                                    $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 4);
                                })
                            );
                    })
                )
                    ->orWhere(
                        (function ($query) {
                            $query->where('kdprop', '=', config('app.kode_prov'))
                                ->where('kdkab', '=', '00')
                                ->where(
                                    (function ($query) {
                                        $query->where('kdesl', '=', 3)->orWhere('kdesl', '=', 2);
                                    })
                                );
                        })
                    )->get();
            }

            $tahun = date('Y');
            $list_anggaran = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop . Auth::user()->kdkab)->get();
            $list_anggaran_prov = \App\MataAnggaran::where('kode_uker', '=', Auth::user()->kdprop . '00')->get();

            return view('surat_tugas.edit', compact(
                'model',
                'id',
                'real_id',
                'list_pegawai',
                'list_pejabat',
                'list_anggaran',
                'list_anggaran_prov',
                'model_rincian'
            ));
        } else {
            abort(403, 'Data telah dibatalkan, permintaan tidak diberikan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        // if (isset($request->validator) && $request->validator->fails()) {
        //     return redirect('surat_tugas/edit',$id)
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        $real_id = Crypt::decrypt($id);
        $model_rincian = \App\SuratTugasRincian::find($real_id);
        $model = \App\SuratTugas::find($model_rincian->id_surtug);
        $model->jenis_st = $request->get('jenis_st');
        $model->sumber_anggaran = $request->get('sumber_anggaran');
        $model->mak = $request->get('mak');
        $model->tugas = $request->get('tugas');

        $model->menimbang = $request->get('menimbang');
        $model->mengingat = $request->get('mengingat');

        $model->updated_by = Auth::id();
        // $model->created_at = date('Y-m-d H:i:s', strtotime($request->get('created_at')));
        $model->save();

        /////////
        // $model_rincian->nip  = $request->get('nip');
        // $model_rincian->nama   = $request->get('nama');
        // $model_rincian->jabatan = $request->get('jabatan');
        $model_rincian->tujuan_tugas  = $request->get('tujuan_tugas');
        $model_rincian->tanggal_mulai   = date('Y-m-d', strtotime($request->get('tanggal_mulai')));
        $model_rincian->tanggal_selesai = date('Y-m-d', strtotime($request->get('tanggal_selesai')));
        $model_rincian->tingkat_biaya  = $request->get('tingkat_biaya');
        $model_rincian->kendaraan  = $request->get('kendaraan');
        $model_rincian->kode_klasifikasi  = $request->get('kode_klasifikasi');

        $explode_st = explode("/",$model_rincian->nomor_st);

        if(count($explode_st)==4) $model_rincian->nomor_st = $explode_st[0] . '/' . $explode_st[1] . '/' . $model_rincian->kode_klasifikasi .'/'  . $explode_st[3];

        $explode_spd = explode("/",$model_rincian->nomor_spd);
        if(count($explode_spd)>0){
            if(count($explode_spd)==5){
                $model_rincian->nomor_spd = $explode_spd[0] . '/' . $explode_spd[1] . '/SPD/'  . $model_rincian->kode_klasifikasi . '/'  . $explode_spd[4];
            }
            else if(count($explode_spd)==6){
                $model_rincian->nomor_spd = $explode_spd[0] . '/' . $explode_spd[1] . '/' . $explode_spd[2] . '/SPD/'  . $model_rincian->kode_klasifikasi . '/' . $explode_spd[4]. '/' . $explode_spd[5];
            }
        }

        // $model_rincian->pejabat_ttd_nip  = $request->get('pejabat_ttd_nip');
        // $model_rincian->pejabat_ttd_nama  = $request->get('pejabat_ttd_nama');
        // $model_rincian->pejabat_ttd_jabatan  = $request->get('pejabat_ttd_jabatan');
        // $model_rincian->unit_kerja_ttd  = $request->get('unit_kerja_ttd');
        $model_rincian->updated_by = Auth::id();
        $model_rincian->created_at = date('Y-m-d H:i:s', strtotime($request->get('created_at')));
        $model_rincian->save();
        ///////////
        return redirect('surat_tugas')->with('success', 'Data berhasil diperbaharui');
    }

    public function edit_unit_kerja(){
        $model = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . Auth::user()->kdkab)->first();
        $list_pegawai = \App\UserModel::where('kdprop', '=', Auth::user()->kdprop)->where('kdkab', '=', Auth::user()->kdkab)->get();

        return view('surat_tugas.edit_unit_kerja', compact('model', 'list_pegawai'));
    }

    public function update_unit_kerja(Request $request){
        $model = \App\UnitKerja::where('kode', '=', Auth::user()->kdprop . Auth::user()->kdkab)->first();
        $model->kepala_nip  = $request->get('kepala_nip');
        $model->kepala_nama = $request->get('kepala_nama');
        $model->ppk_nip = $request->get('ppk_nip');
        $model->ppk_nama = $request->get('ppk_nama');
        $model->bendahara_nip = $request->get('bendahara_nip');
        $model->bendahara_nama = $request->get('bendahara_nama');
        $model->ppspm_nip = $request->get('ppspm_nip');
        $model->ppspm_nama = $request->get('ppspm_nama');
        $model->ibu_kota = $request->get('ibu_kota');
        $model->alamat_kantor = $request->get('alamat_kantor');
        $model->kontak_kantor = $request->get('kontak_kantor');
        $model->updated_by = Auth::id();
        $model->save();
        return redirect('surat_tugas')->with('success', 'Data berhasil diperbaharui');
    }

    public function set_status(Request $request){
        if ($request->form_id_data != '') {
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);
            $model_rincian->status_aktif = $request->form_status_data;
            $model_rincian->save();
            return response()->json(['result' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['result' => 'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }
    
    public function set_pejabat_spd(Request $request){
        if ($request->form_id_data != '') {
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);
            $model_rincian->spd_ttd_nip = $request->spd_ttd_nip;
            $model_rincian->spd_ttd_nama = $request->spd_ttd_nama;
            $model_rincian->spd_ttd_jabatan = $request->spd_ttd_jabatan;
            $model_rincian->save();
            return response()->json(['result' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['result' => 'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function set_aktif(Request $request){
        if ($request->form_id_data != '') {
            $real_id = Crypt::decrypt($request->form_id_data);
            $model_rincian = \App\SuratTugasRincian::find($real_id);
            $model_rincian->status_aktif = 2;
            $model_rincian->save();

            return response()->json(['result' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['result' => 'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function is_available(Request $request){
        if ($request->nip != '' && $request->t_start != '' && $request->t_end != '') {
            $model = new \App\SuratTugasRincian;
            
            $result = $model->isAvailable($request->nip, $request->t_start, $request->t_end, $request->cur_id);

            return response()->json([
                'response' => 1,
                'result' => $result,
                'message' => 'Data berhasil disimpan'
            ]);
        } else {
            return response()->json([
                'response' => 0,
                'result' => 0,
                'message' => 'Terjadi kesalahan, refresh halaman dan coba lagi'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $model = \App\SuratTugas::find($id);
        $model->delete();
        return redirect('surat_tugas')->with('success', 'Information has been  deleted');
    }

    public function destroy_kwitansi($id){
        $model = \App\SuratTugasKwitansi::find($id);
        $model->delete();
        return response()->json(['success' => 'Sukses']);
    }
}
