<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 

class Home2Controller extends Controller
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
        // return redirect('ckp');
        // return view('home');
        $provider = new \JKD\SSO\Client\Provider\Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => '11600-musi-p93',
            'clientSecret'          => 'c9da3629-8a2d-4563-b9a9-043590445e45',
            'redirectUri'           => 'https://webapps.bps.go.id/sumsel/musi/'
        ]);


        //////////
            $request->session()->put('oauth2state', $provider->getState());
        //////////

        if (!$request->has('code')) {
            // Untuk mendapatkan authorization code
            $authUrl = $provider->getAuthorizationUrl();
            header('Location: '.$authUrl);
            dd($request->session()->all());
            exit;
        
        // } elseif (empty($request->get('state')) || ($request->get('state') !== Session::get('oauth2state'))) {
        // } elseif (empty($request->get('state')) || ($request->get('state') !== $request->session()->get('oauth2state'))) {
        //     // unset($_SESSION['oauth2state']);
        //     print('session'.$request->session()->get('oauth2state'));
        //     // var_dump($request->session()->all());
            
        //     // Session::forget('oauth2state');
        //     $request->session()->forget('oauth2state');
        //     print('state'.$request->get('state'));
        //     print('provider'.$provider->getState());
        //     exit('Invalid state');
        
        } else {
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $request->get('code')
                ]);
            } catch (Exception $e) {
                print_r('Gagal mendapatkan akses token : '.$e->getMessage());
            }
        
            // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
            try {
                $user = $provider->getResourceOwner($token);

                $c_nip = $user->getNip();

                $service_url    = 'https://backoffice.bps.go.id/simpeg_api/bps16';
                $curl           = curl_init($service_url);
                $curl_post_data = array(
                    "apiKey" => '4vl8i/WeNeRlRxM4KDk93VqdT0/LZ9g+GBITo+OiHVs=',
                    "kategori"=> 'view_pegawai',
                    "nip" => $c_nip,
                );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
                $curl_response = json_decode(curl_exec($curl));
    
                if(!isset($curl_response->error)){
                    if($curl_response->total==0){
                        if (!$request->expectsJson()) {
                            return route('guest');
                        }
                    }
                    else{
                        $model= \App\User::where('email','=', $c_nip)->first();
                        $c_model = $curl_response->pegawai[0];
        
                        if($model==null){
                            $model = new \App\User;
                            $model->email = $c_model->niplama;
                            $model->nip_baru = $c_model->nipbaru;
                            $model->name = $c_model->namagelar;
                            $model->password = Hash::make($c_model->niplama);
                        }
                        
                        $model->urutreog = $c_model->urutreog;
                        $model->kdorg = $c_model->kdorg;
                        $model->nmorg = $c_model->nmorg;
                        $model->nmjab = $c_model->nmjab;
                        $model->flagwil = $c_model->flagwil;
                        $model->kdprop = $c_model->kdprop;
                        $model->kdkab = $c_model->kdkab;
                        $model->kdkec = $c_model->kdkec;
                        $model->nmwil = $c_model->nmwil;
                        $model->kdgol = $c_model->kdgol;
                        $model->nmgol = $c_model->nmgol;
                        $model->kdstjab = $c_model->kdstjab;
                        $model->nmstjab = $c_model->nmstjab;
                        $model->kdesl = $c_model->kdesl;
                        $model->foto = $c_model->foto;
                        $model->save();
        
                        $data_request = array(
                            $this->username()=>$model->email,
                            'password'  =>$model->email
                        );
                        
                        if ($this->attemptLogin($data_request)) {
                            return $this->sendLoginResponse($data_request);
                        }
                    }
                }
            } catch (Exception $e) {
                print_r('Gagal Mendapatkan Data Pengguna: '.$e->getMessage());
                die();
                
                if (!$request->expectsJson()) {
                    return route('guest');
                }
            }
        
            // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
            // echo $token->getToken();
        }
        // $this->incrementLoginAttempts($request);
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
        return view('hai');
    }

    public function guest(){
        return view('hai');
    }
}
