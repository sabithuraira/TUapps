<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 

class HomeController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = 'hai';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return redirect('ckp');
    }

    protected function attemptLogin($params)
    {
        return $this->guard()->attempt(
            $params, true
        );
    }

    protected function sendLoginResponse($params)
    {
        return redirect('hai');
    }

    public function downloadSp2020(Request $request)
    {
        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');

        $filename = 'sp2020_16'.$kab.$kec.$desa;

        if(strlen($kab)==0) $kab = null;
        if(strlen($kec)==0) $kec = null;
        if(strlen($desa)==0) $desa = null;

        return Excel::download(new \App\Exports\Sp2020Export($kab, $kec, $desa), $filename.'.xlsx');
    }

    public function hai(Request $request){
        $label = 'prov';

        $label_kab = '';
        $label_kec = '';
        $label_desa = '';

        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');

        if(strlen($kab)==0) $kab = null;
        if(strlen($kec)==0) $kec = null;
        if(strlen($desa)==0) $desa = null;
        $model = new \App\Sp2020Sls();

        if($desa!=null){
            $label = 'desa';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if($model_kab!=null) $label_kab = $model_kab->nmKab;
            
            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if($model_kec!=null) $label_kec = $model_kec->nmKec;
            
            $model_desa = \App\Pdesa::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec],
                ['idDesa', '=', $desa],
            ])->first();
            if($model_desa!=null) $label_desa = $model_desa->nmDesa;

            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        }
        else if($desa==null && $kec!=null){
            $label = 'kec';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if($model_kab!=null) $label_kab = $model_kab->nmKab;
            
            $model_kec = \App\Pkec::where([
                ['idKab', '=', $kab],
                ['idKec', '=', $kec]
            ])->first();
            if($model_kec!=null) $label_kec = $model_kec->nmKec;

            $datas = $model->Rekapitulasi($kab, $kec);    
        }
        else if($desa==null && $kec==null && $kab!=null){
            $label = 'kab';
            $model_kab = \App\Pkab::where('idKab', '=', $kab)->first();
            if($model_kab!=null) $label_kab = $model_kab->nmKab;

            $datas = $model->Rekapitulasi($kab); 
        }
        else{
            $datas = $model->Rekapitulasi(); 
        }

        $labels = [];
        $persens = [];

        foreach($datas as $key=>$data){
            $labels[] = $data->nama;
            $persen = 0;
            if($data->target_penduduk>0) $persen = round(($data->realisasi_penduduk/$data->target_penduduk*100),3);
            
            $persens[] = $persen;
        }
        return view('hai',compact('model', 'datas', 'labels', 'persens',
            'kab', 'kec', 'desa', 'label',
            'label_kab', 'label_kec', 'label_desa'));
    }

    public function guest(){
        return view('guest');
    }
}
