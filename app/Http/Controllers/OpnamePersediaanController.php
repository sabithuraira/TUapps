<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MasterBarangRequest;

class OpnamePersediaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\MasterBarang::where('nama_barang', 'LIKE', '%' . $keyword . '%')
            ->where('unit_kerja', '=', Auth::user()->kdprop.Auth::user()->kdkab)
            ->paginate();

        $datas->withPath('opname_persediaan');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('opname_persediaan.list', array('datas' => $datas))->render());
        }

        return view('opname_persediaan.index',compact('datas', 'keyword'));
    }
}
