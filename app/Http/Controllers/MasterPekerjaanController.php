<?php

namespace App\Http\Controllers;

use App\Imports\MasterPekerjaanImport;
use App\MasterPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MasterPekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user();
        $datas = MasterPekerjaan::where('tahun', 'LIKE', '%' . $request->tahun . '%')
            ->where(function ($query) use ($request) {
                $query->where('subkegiatan', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('uraian_pekerjaan', 'LIKE', '%' . $request->keyword . '%');
            })
            ->paginate(20);

        $datas->withPath('master_pekerjaan');
        $datas->appends($request->all());
        return view('master_pekerjaan.index', compact('auth', 'request', 'datas'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $model = new MasterPekerjaan();
        $model->tahun = $request->tahun;
        $model->subkegiatan = $request->subkegiatan;
        $model->uraian_pekerjaan = $request->uraian_pekerjaan;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();
        $model->save();
        return redirect()->back()->with('success', 'Data berhasil diperbaharui');
    }

    public function update($id, Request $request)
    {
        $auth = Auth::user();
        $model = MasterPekerjaan::find($id);
        if ($model) {
            $model->tahun = $request->tahun;
            $model->subkegiatan = $request->subkegiatan;
            $model->uraian_pekerjaan = $request->uraian_pekerjaan;
            $model->updated_by = $auth->id;
            $model->save();
            return redirect()->back()->with('success', 'Data berhasil diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Coba Lagi');
        }
    }
    public function destroy($id)
    {
        $auth = Auth::user();
        $model = MasterPekerjaan::find($id);
        if ($model) {
            $model->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus coba lagi');
        }
    }

    public function import(Request $request)
    {
        $auth = Auth::user();
        if ($request->file_import) {
            Excel::import(new MasterPekerjaanImport($request->tahun, $auth), $request->file_import);
            return redirect()->back()->with('success', 'Import Berhasil');
        }
    }
}
