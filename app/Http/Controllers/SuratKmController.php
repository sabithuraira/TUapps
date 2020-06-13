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
        
        $surat_masuk = \App\SuratKm::where('jenis_surat', '=', 1)
            ->where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('created_at', 'desc')->paginate();
            
        $surat_keluar = \App\SuratKm::where('jenis_surat', '=', 2)
            ->where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('created_at', 'desc')->paginate();
            
        $memorandum = \App\SuratKm::where('jenis_surat', '=', 3)
            ->where('kdprop', '=', Auth::user()->kdprop)
            ->where('kdkab', '=', Auth::user()->kdkab)
            ->orderBy('created_at', 'desc')->paginate();
        
        if(strlen($keyword)>0){
            
            $surat_masuk = \App\SuratKm::where('jenis_surat', '=', 1)
                ->where('kdprop', '=', Auth::user()->kdprop)
                ->where('kdkab', '=', Auth::user()->kdkab)
                ->where(
                    (function ($query) use ($keyword) {
                        $query-> where('nomor_urut', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('perihal', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->orderBy('created_at', 'desc')->paginate();

            $surat_keluar = \App\SuratKm::where('jenis_surat', '=', 2)
                ->where('kdprop', '=', Auth::user()->kdprop)
                ->where('kdkab', '=', Auth::user()->kdkab)
                ->where(
                    (function ($query) use ($keyword) {
                        $query-> where('nomor_urut', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('perihal', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->orderBy('created_at', 'desc')->paginate();

            $memorandum = \App\SuratKm::where('jenis_surat', '=', 3)
                ->where('kdprop', '=', Auth::user()->kdprop)
                ->where('kdkab', '=', Auth::user()->kdkab)
                ->where(
                    (function ($query) use ($keyword) {
                        $query-> where('nomor_urut', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('alamat', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('perihal', 'LIKE', '%' . $keyword . '%');
                    })
                )
                ->orderBy('created_at', 'desc')->paginate();
        }

        $surat_masuk->withPath('surat_km');
        $surat_masuk->appends($request->all());
        
        $surat_keluar->withPath('surat_km');
        $surat_keluar->appends($request->all());
        
        $memorandum->withPath('surat_km');
        $memorandum->appends($request->all());

        // if ($request->ajax()) {
        //     return \Response::json(\View::make('surat_km.list', array(
        //         'surat_masuk' => $surat_masuk, 'surat_keluar'=> $surat_keluar, 'memorandum'=>$memorandum))
        //         ->render());
        // }

        return view('surat_km.index',compact('surat_masuk','surat_keluar', 'memorandum', 'keyword'));
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
                ['kdprop', '=', Auth::user()->kdprop],
                ['kdkab', '=', Auth::user()->kdkab],
            ])->count();
        
        if ($total_after == 0) {
            $last_data = \App\SuratKm::where([
                    [DB::raw('YEAR(tanggal)'), '=', date('Y', strtotime($tanggal))],
                    ['jenis_surat', '=', $jenis_surat],
                    ['kdprop', '=', Auth::user()->kdprop],
                    ['kdkab', '=', Auth::user()->kdkab],
                    ['nomor_urut', 'regexp', '^[0-9]+$'],
                ])
                ->orderBy(DB::raw('CAST(nomor_urut as unsigned)'), 'desc')
                ->first();

            // $nomor_terakhir = $last_data->nomor_urut;

            // if(!is_numeric($nomor_terakhir)){
            //     $exp = explode(".", $nomor_terakhir);
            //     $nomor_terakhir = $exp[0];
            // }

            // if($last_data!=null) $total = $nomor_terakhir + 1;
            // else $total = 1;
            
            if($last_data!=null) $total =  $last_data->nomor_urut + 1;
            else $total = 1;
        }
        else{
            $first_after = \App\SuratKm::where([
                    ['tanggal', '>', $tanggal],
                    ['jenis_surat', '=', $jenis_surat],
                    ['kdprop', '=', Auth::user()->kdprop],
                    ['kdkab', '=', Auth::user()->kdkab],
                    // ['nomor_urut', 'regexp', '^[0-9]+$'],
                ])
                ->orderBy('nomor_urut', 'asc')
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
                ['kdprop', '=', Auth::user()->kdprop],
                ['kdkab', '=', Auth::user()->kdkab],
            ])
            ->count();

            $alphabet = range('A', 'Z');
            
            if($current_number==0 || $total_current_number<=0)
                $total = 0;
            else
                $total = $current_number.'.'.$alphabet[$total_current_number-1];
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
        $model->jenis_surat = 1;
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
        
        $model->kdprop =Auth::user()->kdprop;
        $model->kdkab =Auth::user()->kdkab;

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
