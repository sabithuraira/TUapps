<?php

namespace App\Http\Controllers;

use App\Iki;
use App\IkiBukti;
use App\IkiMaster;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IkiMasterController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user();
        $user = $request->get('user');
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');
        $user_list = User::where('kdkab', $auth->kdkab)->get();
        // mengambil status user apakah atasan atau ketua tim
        $status_user = [];
        $iki_atasan = ['IKI 1', 'IKI 2']; // jika ketua tim maka iki atasan kosong
        $iki_atasan = IkiMaster::all();
        if ($status_user == 'anggota_tim' || $status_user == 'ketua_tim') {
            $iki_atasan = ['IKI 1', 'IKI 2', 'IKI 3'];
        }
        $datas = IkiMaster::where('id_user', $user)
            ->where('tahun', 'LIKE', '%' . $tahun . '%')
            ->where('bulan', 'LIKE', '%' . $bulan . '%')
            ->get();
        foreach ($datas as $i => $data) {
            $sub_ikis = $data->sub_iki;
            foreach ($sub_ikis as $sub_iki) {
                if ($sub_iki->referensi_jenis == "Masuk Bukti Dukung Atasan") {
                    $sub_bukti = IkiBukti::where('id_iki', $sub_iki->id)->get();
                    $data->ikibukti = $data->ikibukti->merge($sub_bukti);
                } else if ($sub_iki->referensi_jenis == "Masuk Bukti Dukung & Realisasi Atasan") {
                    $sub_bukti = IkiBukti::where('id_iki', $sub_iki->id)->get();
                    $data->ikibukti = $data->ikibukti->merge($sub_bukti);
                }
            }
        }


        $model = new IkiMaster();
        return view('iki_master.index', compact('datas', 'auth', 'model', 'user_list', 'iki_atasan', 'request'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $model = new IkiMaster();
        $model->id_user = $request->id_user;
        $model->ik = $request->ik;
        $model->satuan = $request->satuan;
        $model->target = $request->target;
        $model->tahun = $request->tahun;
        $model->bulan = $request->bulan;
        $model->referensi_jenis = $request->referensi_jenis;
        $model->referensi_sumber = $request->referensi_sumber;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();
        $model->save();
        return redirect()->back()->with('success', 'Data berhasil diperbaharui');
    }

    public function update($id, Request $request)
    {
        $auth = Auth::user();
        $model = IkiMaster::find($id);
        if ($model) {
            $model->ik = $request->ik;
            $model->satuan = $request->satuan;
            $model->target = $request->target;
            $model->tahun = $request->tahun;
            $model->bulan = $request->bulan;
            $model->referensi_jenis = $request->referensi_jenis;
            $model->referensi_sumber = $request->referensi_sumber;
            $model->updated_by = Auth::id();
            $model->save();
            return redirect()->back()->with('success', 'Data berhasil diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Coba Lagi');
        }
    }

    public function store_bukti(Request $request)
    {
        $auth = Auth::user();
        $model = new IkiBukti();
        $iki = IkiMaster::find($request->id_iki);
        $model->id_iki = $request->id_iki;
        $model->id_iki_referensi = $iki->referensi_sumber;
        $model->id_user = $iki->id_user;
        $model->jenis_bukti_dukung = $request->jenis_bukti_dukung;
        $model->link_bukti_dukung = $request->link_bukti_dukung;
        $model->deadline = $request->deadline;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();
        $model->save();
        return redirect()->back()->with('success', 'Data berhasil diperbaharui');
    }

    public function update_bukti($id, Request $request)
    {
        $auth = Auth::user();
        $model = IkiBukti::find($id);
        $iki = IkiMaster::find($model->id_iki);
        if ($model) {
            $model->id_iki_referensi = $iki->referensi_sumber;
            $model->jenis_bukti_dukung = $request->jenis_bukti_dukung;
            $model->link_bukti_dukung = $request->link_bukti_dukung;
            $model->deadline = $request->deadline;
            $model->updated_by = Auth::id();
            $model->save();
            return redirect()->back()->with('success', 'Data berhasil diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Coba Lagi');
        }
    }


    public function destroy($id)
    {
        $auth = Auth::user();
        $model = IkiMaster::find($id);
        if ($model) {
            $bukti = IkiBukti::where('id_iki', $id)->get();
            if ($bukti) {
                $bukti->each->delete();
            }
            $model->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus coba lagi');
        }
    }

    public function destroy_bukti($id)
    {
        $auth = Auth::user();
        $model = IkiBukti::find($id);
        if ($model) {
            $model->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus coba lagi');
        }
    }
}
