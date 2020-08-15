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

    public function hai(){
        $model = new \App\Sp2020Sls();
        $datas = $model->Rekapitulasi();
        return view('hai',compact('model', 'datas'));
    }

    public function guest(){
        return view('hai');
    }
}
