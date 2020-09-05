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

    public function hai(Request $request){
        $label = 'prov';
        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $desa = $request->get('desa');

        if(strlen($kab)==0) $kab = null;
        if(strlen($kec)==0) $kec = null;
        if(strlen($desa)==0) $desa = null;
        $model = new \App\Sp2020Sls();

        if($desa!=null){
            $label = 'desa';
            $datas = $model->Rekapitulasi($kab, $kec, $desa);
        }
        else if($desa==null && $kec!=null){
            $label = 'kec';
            $datas = $model->Rekapitulasi($kab, $kec);    
        }
        else if($desa==null && $kec==null && $kab!=null){
            $label = 'kab';
            $datas = $model->Rekapitulasi($kab); 
        }
        else{
            $datas = $model->Rekapitulasi(); 
        }

        $labels = [];
        $persens = [];

        foreach($datas as $key=>$data){
            $labels[] = $data->nama;

            $hasil = ($data->target_penduduk==0) ? 0 : ($data->realisasi_penduduk/$data->target_penduduk*100);
            $persen = round($hasil,3);
            $persens[] = $persen;
        }
        return view('hai',compact('model', 'datas', 'labels', 'persens',
            'kab', 'kec', 'desa', 'label'));
    }

    public function guest(){
        return view('guest');
    }
}
