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
    //
    public function index(Request $request)
    {
        $auth = Auth::user();
        $user = $request->get('user');
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');
        $user_list = User::where('kdkab', $auth->kdkab)->get();

        // $referensi_jenis = IkiMaster::ListReferensiJenis();

        $status_user = [];
        $iki_atasan = ['IKI 1', 'IKI 2'];
        if ($status_user == 'anggota_tim' || $status_user == 'ketua_tim') {
            $iki_atasan = ['IKI 1', 'IKI 2', 'IKI 3'];
        }

        $datas = IkiMaster::where('id_user', $user)
            ->where('tahun', 'LIKE', '%' . $tahun . '%')
            ->where('bulan', 'LIKE', '%' . $bulan . '%')
            ->get();
        // // var_dump($datas[0]);
        // dd($datas[0]->ikibukti);
        $model = new IkiMaster();
        // dd($model->namaBulan);
        return view('iki_master.index', compact('datas', 'auth', 'model', 'user', 'user_list', 'iki_atasan', 'request'));
    }

    public function create(Request $request)
    {
        $auth = Auth::user();
        // cek apakah dia kepala atau ketua tim atau anggota
        // if(){
        // }
        return view();
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $model = new IkiMaster();
        $model->id_user = $auth->id;
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
        // dd($id);
        // dd($request->all());
        $auth = Auth::user();
        $model = IkiMaster::find($id);

        if ($model) {
            $model->id_user = $auth->id;
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
        // dd($request->all());
        $model->id_user = $auth->id;
        $model->id_iki = $request->id_iki;
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
        // dd($id);
        // dd($request->all());
        $auth = Auth::user();
        $model = IkiBukti::find($id);
        if ($model) {
            $model->id_user = $auth->id;
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
}
