<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
       
        $random_user = \App\UserModel::inRandomOrder()->first();
        $unit_kerja = \App\UnitKerja::where('kode', '=', $random_user->kdprop.$random_user->kdkab)->first();
        $dl_per_uk = \App\UnitKerja::rekapDlPerUk();

        return view('dashboard.index',compact(
            'random_user', 'unit_kerja', 'dl_per_uk'));
    }

}
