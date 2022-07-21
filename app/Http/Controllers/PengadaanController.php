<?php

namespace App\Http\Controllers;

use App\Pengadaan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PengadaanController extends Controller
{
    //

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $month = '';
        $year = '';
        $unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
        if (Auth::user()->kdkab == '00') {
            if (strlen($request->get('unit_kerja')) > 0) {
                $unit_kerja = Auth::user()->kdprop . $request->get('unit_kerja');
            }
        }


        if (strlen($request->get('month')) > 0) {
            $month = $request->get('month');
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $month];
        }

        if (strlen($request->get('year')) > 0) {
            $year = $request->get('year');
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $year];
        }
        $datas = Pengadaan::orderBy('id', 'DESC')->paginate(15);
        $datas->withPath('pengadaan');
        $datas->appends($request->all());
        $model = new Pengadaan();
        $auth = Auth::user();
        return view('pengadaan.index', compact(
            'datas',
            'keyword',
            'model',
            'month',
            'year',
            'unit_kerja',
            'auth'
        ));
    }


    public function create()
    {
        $auth = Auth::user();
        $model = new Pengadaan();
        return view('pengadaan.create', compact(
            'auth',
            'model'
        ));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $data = Pengadaan::create([
            'kd_kab' => $auth->kdkab,
            'judul' => $request->judul,
            'kode_anggaran' => $request->kode_anggaran,
            'nilai' => $request->nilai,
            'waktu_pemakaian' => date("Y-m-d", strtotime($request->get('waktu_pemakaian'))),
            'nota_dinas_skf' => 'input_file',
            'kak_skf' => 'input_file',
            'konfirmasi_ppk' => null,
            'konfirmasi_pbj' => null,
            'created_by' => $auth->id,
            'updated_by' => $auth->id
        ]);

        if ($request->hasFile('nota_dinas_skf')) {
            $file = $request->file('nota_dinas_skf');
            $name = $data->id . '_notadinasskf_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $data->nota_dinas_skf = $name;
            $data->save();
        }

        if ($request->hasFile('kak_skf')) {
            $file = $request->file('kak_skf');
            $name = $data->id . '_kak_skf_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $data->kak_skf = $name;
            $data->save();
        }

        return redirect('pengadaan')->with('success', 'Data berhasil diperbaharui');
    }


    public function edit($id)
    {
        $auth = Auth::user();
        $real_id = Crypt::decrypt($id);
        $model = Pengadaan::find($real_id);

        return view('pengadaan.edit', compact('model', 'auth', 'id'));
    }

    public function update(Request $request, $id)
    {
        $real_id = Crypt::decrypt($id);
        $model = Pengadaan::find($real_id);
        // dd($request->all());
        // dd($request->spek);
        if ($request->konfirmasi_ppk) {
            $model->konfirmasi_ppk = $request->konfirmasi_ppk;
        }

        if ($request->spek) {
            $model->spek = $request->spek;
        }
        if ($request->alokasi_anggaran) {
            $model->alokasi_anggaran = $request->alokasi_anggaran;
        }

        if ($request->hasFile('lk_hps')) {
            $file = $request->file('lk_hps');
            $name = $model->id . 'lk_hps' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->lk_hps = $name;
        }

        if ($request->hasFile('hps')) {
            $file = $request->file('hps');
            $name = $model->id . 'hps' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->hps = $name;
        }
        if ($request->hasFile('nota_dinas_ppk')) {
            $file = $request->file('nota_dinas_ppk');
            $name = $model->id . '_nota_dinas_ppk_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->nota_dinas_ppk = $name;
        }
        if ($request->hasFile('kak_ppk')) {
            $file = $request->file('kak_ppk');
            $name = $model->id . '_kak_ppk_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->kak_ppk = $name;
        }
        if ($request->tgl_penolakan_ppk) {
            $model->tgl_penolakan_ppk = date("Y-m-d", strtotime($request->get('tgl_penolakan_ppk')));
        }
        if ($request->alasan_penolakan_ppk) {
            $model->alasan_penolakan_ppk = $request->alasan_penolakan_ppk;
        }

        // PBJ
        if ($request->konfirmasi_pbj) {
            $model->konfirmasi_pbj = $request->konfirmasi_pbj;
        }
        if ($request->revisi_nilai) {
            $model->revisi_nilai = $request->revisi_nilai;
        }
        if ($request->tgl_mulai_pelaksanaan) {
            $model->tgl_mulai_pelaksanaan = $request->tgl_mulai_pelaksanaan;
        }
        if ($request->tgl_akhir_pelaksanaan) {
            $model->tgl_akhir_pelaksanaan = $request->tgl_akhir_pelaksanaan;
        }
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $name = $model->id . '_foto_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->foto = $name;
        }
        if ($request->hasFile('bast')) {
            $file = $request->file('bast');
            $name = $model->id . '_bast_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->bast = $name;
        }

        if ($request->tgl_penolakan_pbj) {
            $model->tgl_penolakan_pbj = $request->tgl_penolakan_pbj;
        }
        if ($request->alasan_penolakan_pbj) {
            $model->alasan_penolakan_pbj = $request->alasan_penolakan_pbj;
        }

        $rows = $model->save();
        if ($rows > 0) {
            return back()->with('success', 'Data berhasil diperbaharui');
        } else {
            return back()->with('errors', 'Data gagal diperbaharui');
        }
    }
    public function unduh($file_name)
    {
        $file = public_path() . "/upload/pengadaan/" . $file_name;
        $headers = array('Content-Type: application/pdf',);
        return response()->download($file, $file_name, $headers);
    }


    public function set_aktif(Request $request)
    {
        if ($request->id != '') {
            $real_id = Crypt::decrypt($request->id);
            $model = Pengadaan::find($real_id);
            $model->status_aktif = 2;
            $model->save();
            return response()->json(['result' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['result' => 'Terjadi kesalahan, refresh halaman dan coba lagi']);
        }
    }
}
