<?php

namespace App\Http\Controllers;

use App\Pengadaan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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

        $arr_where = [];
        if (strlen($request->get('month')) > 0) {
            $month = $request->get('month');
            $arr_where[] = [DB::raw('MONTH(created_at)'), '=', $month];
        }
        if (strlen($request->get('year')) > 0) {
            $year = $request->get('year');
            $arr_where[] = [DB::raw('YEAR(created_at)'), '=', $year];
        }
        $datas = Pengadaan::orderBy('id', 'DESC')
            ->whereYear('created_at', 'LIKE', '%' . $year . '%')
            ->whereMonth('created_at', 'LIKE', '%' . $month . '%')
            ->where('judul', 'LIKE', '%' . $keyword . '%')
            // ->orwhere('kode_anggaran', 'LIKE', '%' . $keyword . '%')
            ->paginate(15);

        $jumlah_pengajuan = Pengadaan::count('*');
        $jumlah_ditolak_ppk = Pengadaan::where('konfirmasi_ppk', 'Ditolak')->count('*');
        $jumlah_ditolak_pbj = Pengadaan::where('konfirmasi_pbj', 'Ditolak')->count('*');
        $jumlah_selesai = Pengadaan::where('status_pengadaan', '1')->count('*');
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
            'auth',
            'jumlah_pengajuan',
            'jumlah_ditolak_ppk',
            'jumlah_ditolak_pbj',
            'jumlah_selesai'
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
            'nilai_anggaran' =>  str_replace('.', '', $request->nilai_anggaran),
            'waktu_pemakaian' => date("Y-m-d", strtotime($request->get('waktu_pemakaian'))),
            'nota_dinas_skf' => 'input_file',
            'created_by' => $auth->id
        ]);

        if ($request->hasFile('nota_dinas_skf')) {
            $file = $request->file('nota_dinas_skf');
            $name = $data->id . '_nota_dinas_skf_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $data->nota_dinas_skf = $name;
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
        // ppk
        if ($request->konfirmasi_ppk) {
            $model->konfirmasi_ppk = $request->konfirmasi_ppk;
        }

        if ($request->spek) {
            $model->spek = $request->spek;
        }

        if ($request->hasFile('spek_file')) {
            if ($model->spek_file) {
                unlink('upload/pengadaan/' . $model->spek_file);
            }
            $file = $request->file('spek_file');
            $name = $model->id . '_spek_file_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->spek_file = $name;
        }

        if ($request->perkiraan_nilai) {
            $model->perkiraan_nilai =  str_replace('.', '', $request->perkiraan_nilai);
        }

        if ($request->hasFile('lk_hps')) {
            if ($model->lk_hps) {
                unlink('upload/pengadaan/' . $model->lk_hps);
            }
            $file = $request->file('lk_hps');
            $name = $model->id . '_lk_hps_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->lk_hps = $name;
        }

        if ($request->hasFile('hps')) {
            if ($model->hps) {
                unlink('upload/pengadaan/' . $model->hps);
            }
            $file = $request->file('hps');
            $name = $model->id . '_hps_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->hps = $name;
        }

        if ($request->alokasi_anggaran) {
            $model->alokasi_anggaran = $request->alokasi_anggaran;
        }

        if ($request->hasFile('nota_dinas_ppk')) {
            if ($model->nota_dinas_ppk) {
                unlink('upload/pengadaan/' . $model->nota_dinas_ppk);
            }
            $file = $request->file('nota_dinas_ppk');
            $name = $model->id . '_nota_dinas_ppk_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->nota_dinas_ppk = $name;
        }
        if ($request->hasFile('kak_ppk')) {
            if ($model->kak_ppk) {
                unlink('upload/pengadaan/' . $model->kak_ppk);
            }
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
        if ($request->nilai_kwitansi) {
            $model->nilai_kwitansi = $request->nilai_kwitansi;
        }
        if ($request->tgl_mulai_pelaksanaan) {
            $model->tgl_mulai_pelaksanaan = date("Y-m-d", strtotime($request->get('tgl_mulai_pelaksanaan')));
        }
        if ($request->tgl_akhir_pelaksanaan) {
            $model->tgl_akhir_pelaksanaan =  date("Y-m-d", strtotime($request->get('tgl_akhir_pelaksanaan')));
        }
        if ($request->status_pengadaan) {
            $model->status_pengadaan = $request->status_pengadaan;
        } else {
            $model->status_pengadaan = "0";
        }
        if ($request->hasFile('foto')) {
            if ($model->foto) {
                unlink('upload/pengadaan/' . $model->foto);
            }
            $file = $request->file('foto');
            $name = $model->id . '_foto_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->foto = $name;
        }
        if ($request->hasFile('bast')) {
            if ($model->bast) {
                unlink('upload/pengadaan/' . $model->bast);
            }
            $file = $request->file('bast');
            $name = $model->id . '_bast_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->bast = $name;
        }
        if ($request->hasFile('kontrak')) {
            if ($model->kontrak) {
                unlink('upload/pengadaan/' . $model->kontrak);
            }
            $file = $request->file('kontrak');
            $name = $model->id . '_kontrak_' . str_replace(' ', '', $file->getClientOriginalName());
            $file->move('upload/pengadaan', $name);
            $model->bast = $name;
        }

        if ($request->tgl_penolakan_pbj) {
            $model->tgl_penolakan_pbj =  date("Y-m-d", strtotime($request->get('tgl_penolakan_pbj')));
        }
        if ($request->alasan_penolakan_pbj) {
            $model->alasan_penolakan_pbj = $request->alasan_penolakan_pbj;
        }

        $model->updated_by = Auth::user()->id;

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