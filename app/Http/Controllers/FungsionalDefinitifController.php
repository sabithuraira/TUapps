<?php

namespace App\Http\Controllers;

use App\Exports\FungsionalDefinitifExport;
use App\FungsionalDefinitif;
use App\UnitKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FungsionalDefinitifController extends Controller
{
    //

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $kab = "";
        if ($request->kab_filter) {
            $kab = $request->kab_filter;
        }

        $uker = UnitKerja::all();
        $data = FungsionalDefinitif::where('kode_wilayah', 'LIKE', '%' . $kab . '%')->get();
        // dd($data);
        return view('fungsional_definitif.index', compact('data', 'keyword', 'uker', 'request'));
    }

    public function create()
    {
        $uker = UnitKerja::all();
        $data = new FungsionalDefinitif();
        return view('fungsional_definitif.create', compact('data', 'uker'));
    }

    public function store(Request $request)
    {
        $data = new FungsionalDefinitif();
        $data->nama_jabatan = $request->nama_jabatan;
        $data->kode_wilayah = $request->kd_wilayah;
        $data->abk = $request->abk;
        $result = $data->save();
        if ($result) {
            return redirect('fungsional_definitif?kab_filter=' . $request->kd_wilayah)->with('success', 'Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Gagal Disimpan');
        }
    }
    public function edit($id)
    {
        $uker = UnitKerja::all();
        $data = FungsionalDefinitif::find($id);
        return view('fungsional_definitif.edit', compact('data', 'uker', 'id'));
    }
    public function update(Request $request, $id)
    {
        $data = FungsionalDefinitif::find($id);
        // dd($request->all());
        $data->nama_jabatan = $request->nama_jabatan;
        $data->kode_wilayah = $request->kd_wilayah;
        $data->abk = $request->abk;
        $result =  $data->save();

        if ($result) {
            return redirect('fungsional_definitif?kab_filter=' . $request->kd_wilayah)->with('success', 'Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Gagal Disimpan');
        }
    }
    public function destroy($id)
    {
        $result =  FungsionalDefinitif::find($id)->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Gagal Disimpan');
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new FungsionalDefinitifExport($request), 'fung_definitif_' . $request->kab_filter . '.xlsx');
    }
}
