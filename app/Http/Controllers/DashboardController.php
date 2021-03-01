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

    
    public function rekap_dl(Request $request)
    {
        $year = date('Y');
        $month = date('m');
        $uk = '00';
        $list_libur = [];

        if(strlen($request->get('month'))>0)
            $month = $request->get('month');

        if(strlen($request->get('year'))>0)
            $year = $request->get('year');
            
        if(strlen($request->get('uk'))>0)
            $uk = $request->get('uk');
    
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
        for($i=1;$i<=$d;$i++){
            $hari = date('N', strtotime($year.'-'.$month.'-'.$i));
            if($hari >= 6){
                $list_libur[] = $i;
            }
        }

        $datas = \App\SuratTugasRincian::rekapUnitKerja($uk, $month, $year);
        return view('dashboard.rekap_dl',compact(
            'datas', 'month', 'year', 'uk', 'list_libur'));
    }

}
