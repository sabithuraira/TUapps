<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = $request->get('search');
        $month = '';
        $year = '';
        $unit_kerja = Auth::user()->kdprop.Auth::user()->kdkab;

        if(Auth::user()->kdkab=='00'){
            if(strlen($request->get('unit_kerja'))>0){
                $unit_kerja = Auth::user()->kdprop.$request->get('unit_kerja');
            }
        }
        
        $arr_where = [];

        if(strlen($request->get('month'))>0){
            $month = $request->get('month');
            $arr_where[] = [\DB::raw('MONTH(created_at)'), '=', $month];
        }
        
        if(strlen($request->get('year'))>0){
            $year = $request->get('year');
            $arr_where[] = [\DB::raw('YEAR(created_at)'), '=', $year];
        }

        return view('penugasan.index', compact(
                // 'datas',
                'keyword',
                // 'model',
                'month',
                'year',
                'unit_kerja'
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penugasan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('penugasan.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('penugasan.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
