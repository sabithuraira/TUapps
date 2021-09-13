<?php

namespace App\Http\Controllers;

use App\Cuti;
use App\Http\Requests\CutiRequest;
use App\UnitKerja;
use App\User;
use Doctrine\DBAL\Types\JsonType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PHPUnit\Util\Json;
use PDF;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $keyword = $request->get('search');
        $month = '';
        $year = '';
        $unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
        $type = 1;
        if (strlen($request->get('action')) > 0) {
            $type = $request->get('action');
        }

        if (Auth::user()->kdkab == '00') {
            if (strlen($request->get('unit_kerja')) > 0) {
                $unit_kerja = Auth::user()->kdprop . $request->get('unit_kerja');
            }
        }

        $arr_where = [];

        if (strlen($request->get('month')) > 0) {
            $month = $request->get('month');
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $month];
        }

        if (strlen($request->get('year')) > 0) {
            $year = $request->get('year');
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $year];
        }

        if ($type == 2) {
            // return Excel::download(new \App\Exports\SuratTugasExport($unit_kerja, $month, $year, $keyword), 'cuti.xlsx');
        } else {
            $datas = \App\Cuti::where($arr_where)
                ->where(
                    (function ($query) use ($unit_kerja) {
                        $query->where('unit_kerja', '=', $unit_kerja);
                    })
                )
                ->where(
                    (function ($query) use ($keyword) {
                        $query->where('nama', 'LIKE', '%' . $keyword . '%');
                    })
                )->orderBy('id', 'desc')
                ->paginate();

            $datas->withPath('cuti');
            $datas->appends($request->all());
            $model = new \App\Cuti;
            // dd($datas);
            return view('cuti.index', compact(
                'datas',
                'keyword',
                'model',
                'month',
                'year',
                'unit_kerja'
            ));
        }
        // return view('cuti.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new \App\Cuti;
        $catatan_cuti = new \App\Cuti;
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $current_date =  date('Y-m-d');
        return view('cuti.create', compact(
            'list_pegawai',
            'model',
            'current_date',
            'catatan_cuti'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CutiRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('cuti/create')
                ->withErrors($request->validator)
                ->withInput();
        }

        $model = new \App\Cuti;
        $user = User::find($request->get('id_user'));
        $model->id_user = $request->get('id_user');
        $model->nip = $request->get('nip');
        $model->nama = $request->get('nama');
        $model->jabatan = $request->get('jabatan');
        $model->masa_kerja = $request->get('masa_kerja');
        $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;

        $model->jenis_cuti = $request->get('jenis_cuti');
        $model->alasan = $request->get('alasan_cuti');

        $model->lama_cuti = $request->get('lama_cuti');
        $model->tanggal_mulai = $request->get('tanggal_mulai');
        $model->tanggal_selesai = $request->get('tanggal_selesai');

        $catatan_cuti = new JsonType;
        $catatan_cuti->cuti_tahunan_sebelum = $request->get('cuti_tahunan_sebelum');
        $catatan_cuti->cuti_tahunan = $request->get('cuti_tahunan');
        $catatan_cuti->cuti_besar = $request->get('cuti_besar');
        $catatan_cuti->cuti_sakit = $request->get('cuti_sakit');
        $catatan_cuti->cuti_melahirkan = $request->get('cuti_melahirkan');
        $catatan_cuti->cuti_penting = $request->get('cuti_penting');
        $catatan_cuti->cuti_luar_tanggungan = $request->get('cuti_luar_tanggungan');

        $catatan_cuti->keterangan_cuti_tahunan_sebelum = $request->get('keterangan_cuti_tahunan_sebelum');
        $catatan_cuti->keterangan_cuti_tahunan = $request->get('keterangan_cuti_tahunan');
        $catatan_cuti->keterangan_cuti_besar = $request->get('keterangan_cuti_besar');
        $catatan_cuti->keterangan_cuti_sakit = $request->get('keterangan_cuti_sakit');
        $catatan_cuti->keterangan_cuti_melahirkan = $request->get('keterangan_cuti_melahirkan');
        $catatan_cuti->keterangan_cuti_penting = $request->get('keterangan_cuti_penting');
        $catatan_cuti->keterangan_luar_tanggunan = $request->get('keterangan_luar_tanggunan');

        $model->catatan_cuti_pegawai = json_encode($catatan_cuti);

        $model->alamat_cuti = $request->get('alamat_cuti');
        $model->no_telp = $request->get('no_telp');

        $model->nama_atasan =  $user->pimpinan->name;
        $model->nip_atasan = $user->pimpinan->nip_baru;
        $model->status_atasan = 0;

        $model->nama_pejabat = $request->get('nama_pejabat');;
        $model->nip_pejabat = $request->get('nip_pejabat');;
        $model->status_pejabat = 0;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();
        $model->save();
        return redirect('cuti')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list_pegawai = \App\UserModel::where('kdprop', '=', config('app.kode_prov'))
            ->where('kdkab', '=', Auth::user()->kdkab)->get();
        $real_id = Crypt::decrypt($id);
        $model = \App\Cuti::find($real_id);
        $catatan_cuti = (json_decode($model->catatan_cuti_pegawai));
        return view('cuti.edit', compact(
            'model',
            'id',
            'real_id',
            'list_pegawai',
            'catatan_cuti'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CutiRequest $request, $id)
    {
        //
        $real_id = Crypt::decrypt($id);
        $model = \App\Cuti::find($real_id);

        $model->jenis_cuti = $request->get('jenis_cuti');
        $model->alasan = $request->get('alasan_cuti');

        $model->lama_cuti = $request->get('lama_cuti');
        $model->tanggal_mulai = $request->get('tanggal_mulai');
        $model->tanggal_selesai = $request->get('tanggal_selesai');

        $catatan_cuti = new JsonType;
        $catatan_cuti->cuti_tahunan_sebelum = $request->get('cuti_tahunan_sebelum');
        $catatan_cuti->cuti_tahunan = $request->get('cuti_tahunan');
        $catatan_cuti->cuti_besar = $request->get('cuti_besar');
        $catatan_cuti->cuti_sakit = $request->get('cuti_sakit');
        $catatan_cuti->cuti_melahirkan = $request->get('cuti_melahirkan');
        $catatan_cuti->cuti_penting = $request->get('cuti_penting');
        $catatan_cuti->cuti_luar_tanggungan = $request->get('cuti_luar_tanggungan');
        $catatan_cuti->keterangan_cuti_tahunan_sebelum = $request->get('keterangan_cuti_tahunan_sebelum');
        $catatan_cuti->keterangan_cuti_tahunan = $request->get('keterangan_cuti_tahunan');
        $catatan_cuti->keterangan_cuti_besar = $request->get('keterangan_cuti_besar');
        $catatan_cuti->keterangan_cuti_sakit = $request->get('keterangan_cuti_sakit');
        $catatan_cuti->keterangan_cuti_melahirkan = $request->get('keterangan_cuti_melahirkan');
        $catatan_cuti->keterangan_cuti_penting = $request->get('keterangan_cuti_penting');
        $catatan_cuti->keterangan_luar_tanggunan = $request->get('keterangan_luar_tanggunan');
        $model->catatan_cuti_pegawai = json_encode($catatan_cuti);

        $model->alamat_cuti = $request->get('alamat_cuti');
        $model->no_telp = $request->get('no_telp');

        $model->updated_by = Auth::id();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
        return redirect('cuti')->with('success', 'Data berhasil diperbaharui');
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
        Cuti::where('id', Crypt::decrypt($id))->delete();
        return redirect('cuti')->with('success', 'Data berhasil dihapus');
    }

    public function set_status_atasan(Request $request)
    {
        if ($request->form_id_data != '') {
            $real_id = Crypt::decrypt($request->form_id_data);
            $model = \App\Cuti::find($real_id);
            $model->status_atasan = $request->form_status_data;
            $model->tanggal_status_atasan = date('Y-m-d H:i:s');
            $model->save();
            return response()->json(['result' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['result' => 'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function set_status_pejabat(Request $request)
    {
        if ($request->form_id_data != '') {
            $real_id = Crypt::decrypt($request->form_id_data);
            $model = \App\Cuti::find($real_id);
            $model->status_pejabat = $request->form_status_data;
            $model->tanggal_status_pejabat = date('Y-m-d H:i:s');
            $model->save();
            return response()->json(['result' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['result' => 'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }

    public function print_cuti($id)
    {
        $real_id = Crypt::decrypt($id);

        $model = Cuti::find($real_id);
        $user = User::find($model->id_user);
        $kodewil = $user->kdprop . $user->kdkab;
        $unit_kerja = UnitKerja::where('kode', $kodewil)->first();
        // dd($user->pimpinan);
        $catatan_cuti = (json_decode($model->catatan_cuti_pegawai));
        $current_date =  date('Y-m-d');

        $pdf = PDF::loadView('cuti.print_cuti', compact(
            'real_id',
            'catatan_cuti',
            'model',
            'user',
            'unit_kerja'
        ))->setPaper('a4', 'potrait');

        $nama_file = 'cuti_' . $model->nama . '.pdf';
        // return $pdf->download($nama_file);
        // dd($user);
        return view('cuti.print_cuti', compact(
            'real_id',
            'catatan_cuti',
            'user',
            'model',
            'unit_kerja'
        ));
    }
}
