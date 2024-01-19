<?php

namespace App\Http\Controllers;

use App\IkiMaster;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IkiReportController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user();
        $model = new IkiMaster();

        if ($request->bulan && $request->tahun) {
            $nip_iki = IkiMaster::where('bulan', $request->bulan)->select('nip')->get()->toArray();
            $data_iki = User::where('kdkab', $auth->kdkab)->wherein('nip_baru', $nip_iki)->get();
            $data_tidak_iki = User::where('kdkab', $auth->kdkab)->wherenotin('nip_baru', $nip_iki)->get();
        } else {
            $data_iki = [];
            $data_tidak_iki = [];
        }
        // dd($data_iki[0]->iki);


        return  view('iki_report.index', compact('auth', 'request', 'model', 'data_iki', 'data_tidak_iki'));
    }
}
