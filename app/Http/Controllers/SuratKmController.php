<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuratKmRequest;
use Illuminate\Support\Facades\DB;

class SuratKmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\SuratKm::where('nomor_urut', 'LIKE', '%' . $keyword . '%')
            ->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
            ->orWhere('perihal', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('surat_km');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('surat_km.list', array('datas' => $datas))->render());
        }

        return view('surat_km.index',compact('datas', 'keyword'));
    }

    public function getNomorUrut(Request $request){
        $jenis_surat = 1;
        // $nomor_petunjuk = 0;
        $tanggal = date('Y-m-d');
        $total=1;

        if(strlen($request->get('jenis_surat'))>0)
            $jenis_surat = $request->get('jenis_surat');

        // if(strlen($request->get('nomor_petunjuk'))>0)
        //     $nomor_petunjuk = $request->get('nomor_petunjuk');

        if(strlen($request->get('tanggal'))>0){
            $tanggal = date('Y-m-d', strtotime($request->get('tanggal')));
        }
        
        $total_after = \App\SuratKm::where([
                ['tanggal', '>', $tanggal],
                ['jenis_surat', '=', $jenis_surat],
            ])->count();
        
        if ($total_after == 0) {
            $last_data = \App\SuratKm::where([
                    [DB::raw('YEAR(tanggal)'), '=', date('Y', strtotime($tanggal))],
                    ['jenis_surat', '=', $jenis_surat],
                ])
                ->orderBy('tanggal', 'desc')
                ->first();
            
            if($last_data!=null) $total = $last_data->nomor_urut + 1;
        }
        else{
            $first_after = \App\SuratKm::where([
                    ['tanggal', '>', $tanggal],
                    ['jenis_surat', '=', $jenis_surat],
                ])
                ->orderBy('tanggal', 'asc')
                ->first();

            $first_number_after = $first_after->nomor_urut;

            // if the number not numeric, ex: 306.A, 90.C,
            // we will explode by "." char and take the numeric only
            if(!is_numeric($first_number_after)){
                $exp = explode(".", $first_number_after);
                $first_number_after = $exp[0];
            }

            $current_number = $first_number_after - 1;

            $total_current_number = \App\SuratKm::where([
                ['nomor_urut', 'LIKE', $current_number.'%'],
                ['jenis_surat', '=', $jenis_surat],
            ])
            ->count();

            $alphabet = range('A', 'Z');
            
            $total = $current_number.'.'.$alphabet[$total_current_number];
        }

        return response()->json(['success'=>'Sukses', 'total'=>$total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model= new \App\SuratKm;
        $model->tanggal = date('Y-m-d');
        return view('surat_km.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuratKmRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_km/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model= new \App\SuratKm;
        $model->nomor_urut=$request->get('nomor_urut');
        $model->alamat=$request->get('alamat');
        $model->tanggal= date('Y-m-d', strtotime($request->get('tanggal')));
        $model->nomor=$request->get('nomor');
        $model->perihal=$request->get('perihal');
        $model->nomor_petunjuk=$request->get('nomor_petunjuk');
        $model->jenis_surat=$request->get('jenis_surat');
        $model->created_by=Auth::id();
        $model->updated_by=Auth::id();
        $model->save();
        
        return redirect('surat_km')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = \App\SuratKm::find($id);
        return view('surat_km.edit',compact('model','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuratKmRequest $request, $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('surat_km/edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $model= \App\SuratKm::find($id);
        $model->nomor_urut=$request->get('nomor_urut');
        $model->alamat=$request->get('alamat');
        $model->tanggal= date('Y-m-d', strtotime($request->get('tanggal')));
        $model->nomor=$request->get('nomor');
        $model->perihal=$request->get('perihal');
        $model->nomor_petunjuk=$request->get('nomor_petunjuk');
        $model->jenis_surat=$request->get('jenis_surat');
        $model->updated_by=Auth::id();
        $model->save();
        return redirect('surat_km');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\SuratKm::find($id);
        $model->delete();
        return redirect('surat_km')->with('success','Information has been  deleted');
    }
}
