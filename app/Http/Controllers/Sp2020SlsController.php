<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\Sp2020SlsPartialImport;
// use App\Imports\Sp2020LfAllImport;
use App\Imports\Sp2020LfPartialImport;
use App\Imports\Sp2020LfPenggantiImport;
use App\Imports\RegsosekPartialImport;
use App\Imports\PesSt2023Import;
use App\Imports\SlsUmkmImport;

class Sp2020SlsController extends Controller
{
    public function upload_some(){
        $model = new \App\Sp2020Sls();
        return view('sp2020sls.upload_some',compact('model'));
    }

    public function import_some(Request $request){
        // Excel::import(new Sp2020SlsPartialImport(), $request->file('excel_file'));
        // Excel::import(new Sp2020LfAllImport(), $request->file('excel_file'));
        // Excel::import(new PesSt2023Import(), $request->file('excel_file'));
        Excel::import(new SlsUmkmImport(), $request->file('excel_file'));
        return redirect('sp2020sls/import_some')->with('success', 'Information has been added');
    }

    public function upload_pengganti(){
        $model = new \App\Sp2020Sls();
        return view('sp2020sls.upload_pengganti',compact('model'));
    }

    public function import_pengganti(Request $request){
        Excel::import(new Sp2020LfPenggantiImport(), $request->file('excel_file'));
        return redirect('sp2020sls/import_pengganti')->with('success', 'Information has been added');
    }

    public function upload_progres(){
        $model = new \App\Sp2020Sls();
        return view('sp2020sls.upload_some',compact('model'));
    }

    public function import_progres(Request $request){
        // Excel::import(new Sp2020SlsAllImport(), $request->file('excel_file'));
        Excel::import(new Sp2020LfAllImport(), $request->file('excel_file'));
        return redirect('sp2020sls/import_some')->with('success', 'Information has been added');
    }
}
