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
        $service_url    = 'https://backoffice.bps.go.id/simpeg_api/bps16';
        $curl           = curl_init($service_url);
        $curl_post_data = array(
            "apiKey" => '4vl8i/WeNeRlRxM4KDk93VqdT0/LZ9g+GBITo+OiHVs=',
            "kategori"=> 'view_pegawai',
            "nip" => '340055914',
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = json_decode(curl_exec($curl));

        if(!isset($curl_response->error)){
            if($curl_response->total==0){
                // $is_cookie = false;
            }
            else{
                $c_model = $curl_response->pegawai[0];
                print_r($c_model->niplama);
                print_r($c_model->nmstjab);
                print_r($c_model->kdstjab);
                print_r($c_model->nmstkerja);
                die();
            }
        }
        else{
            print_r($curl_response->error);
        }
        // return view('hai');
    }

    public function guest(){
        return view('hai');
    }
}
