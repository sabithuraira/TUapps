<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function d4ft4r_2612(){
        $c_nip = "";

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
            if($curl_response->total!=0){
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
            }
        }
    }

    /**
     * SSO BPS (Keycloak / OpenID Connect - Authorization Code Flow).
     *
     * 1. No `code`  -> redirect to Keycloak login page.
     * 2. With `code` -> exchange for access token, read /userinfo,
     *    sync pegawai data from SIMPEG API, then log the user in.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $base = rtrim(config('sso.url'), '/') . '/realms/' . config('sso.realm') . '/protocol/openid-connect';
        $redirectUri = config('sso.redirect_uri');

        // Step 1: start login -> redirect to Keycloak
        if (!$request->has('code')) {
            $state = bin2hex(random_bytes(16));
            $request->session()->put('sso_state', $state);

            $loginUrl = $base . '/auth?' . http_build_query([
                'response_type' => 'code',
                'client_id'     => config('sso.client_id'),
                'redirect_uri'  => $redirectUri,
                'scope'         => 'openid profile email',
                'state'         => $state,
            ]);

            return redirect()->away($loginUrl);
        }

        // Step 2: validate state (anti login-CSRF), one-time use
        $expectedState = (string) $request->session()->pull('sso_state', '');
        if ($expectedState === '' || !hash_equals($expectedState, (string) $request->get('state', ''))) {
            return redirect($redirectUri)->with('error', 'State SSO tidak valid. Silakan ulangi login.');
        }

        // Exchange code -> token
        $tokenData = $this->ssoRequest($base . '/token', [
            'grant_type'    => 'authorization_code',
            'client_id'     => config('sso.client_id'),
            'client_secret' => config('sso.client_secret'),
            'code'          => $request->get('code'),
            'redirect_uri'  => $redirectUri,
        ]);

        if (empty($tokenData['access_token'])) {
            \Log::error('SSO token error', ['response' => $tokenData]);
            return redirect()->route('guest');
        }
        $accessToken = $tokenData['access_token'];
        $request->session()->put('sso_id_token', $tokenData['id_token'] ?? '');

        // Userinfo
        $userInfo = $this->ssoRequest($base . '/userinfo', null, ['Authorization: Bearer ' . $accessToken]);
        if (!is_array($userInfo) || empty($userInfo)) {
            \Log::error('SSO userinfo error', ['response' => $userInfo]);
            return redirect()->route('guest');
        }

        // NIP lama from SSO profile (claim name can differ per realm/client)
        $c_nip = null;
        foreach (['nip', 'nip_lama', 'nip-lama', 'niplama', 'nipLama'] as $claim) {
            if (!empty($userInfo[$claim])) {
                $c_nip = $userInfo[$claim];
                break;
            }
        }
        if ($c_nip === null) {
            \Log::error('SSO userinfo tidak berisi NIP', ['claims' => array_keys($userInfo)]);
            return redirect()->route('guest');
        }

        // Sync pegawai from SIMPEG
        $curl_response = $this->ssoRequest('https://backoffice.bps.go.id/simpeg_api/bps16', [
            'apiKey'   => '4vl8i/WeNeRlRxM4KDk93VqdT0/LZ9g+GBITo+OiHVs=',
            'kategori' => 'view_pegawai',
            'nip'      => $c_nip,
        ], [], false);

        if (!is_object($curl_response) || isset($curl_response->error) || empty($curl_response->total)) {
            return redirect()->route('guest');
        }

        $c_model = $curl_response->pegawai[0];
        $model = \App\User::where('email', '=', $c_nip)->first();
        if ($model == null) {
            $model = new \App\User;
            $model->email = $c_model->niplama;
            $model->nip_baru = $c_model->nipbaru;
            $model->name = $c_model->namagelar;
            $model->password = \Illuminate\Support\Facades\Hash::make($c_model->niplama);
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

        // Sync riwayat jabatan (best effort: failure must not block login)
        try {
            $riwayat = $this->ssoRequest('https://simpeg.bps.go.id/api/bps16', [
                'apiKey'   => 'L2cvVWtDaE5sczVzTHFPaHBZT0Rzdz09.' . $accessToken,
                'kategori' => 'view_jabatan',
                'nip'      => $c_nip,
            ], [], false);

            if (is_array($riwayat)) {
                foreach ($riwayat as $res) {
                    $tmt = date('Y-m-d', strtotime($res->tmt));
                    $tglsk = $res->tglsk ? date('Y-m-d', strtotime($res->tglsk)) : null;
                    DB::table('riwayat_sk')->updateOrInsert(
                        ['niplama' => $res->niplama, 'nosk' => $res->nosk],
                        [
                            'flagstjab'  => $res->flagstjab,
                            'kdstjab'    => $res->kdstjab,
                            'urutreog'   => $res->urutreog,
                            'kdorg'      => $res->kdorg,
                            'flagwil'    => $res->flagwil,
                            'kdprop'     => $res->kdprop,
                            'kdkab'      => $res->kdkab,
                            'kdkec'      => $res->kdkec,
                            'tmt'        => $tmt,
                            'tglsk'      => $tglsk,
                            'penugasan'  => $res->penugasan,
                            'kdstkerja'  => $res->kdstkerja,
                            'nmstjab'    => $res->nmstjab,
                            'nmorg'      => $res->nmorg,
                            'nmwil'      => $res->nmwil,
                            'created_by' => 1,
                        ]
                    );
                }
            }
        } catch (Exception $e) {
            \Log::error('Gagal sync riwayat SK: ' . $e->getMessage());
        }

        $data_request = [
            $this->username() => $model->email,
            'password'        => $model->email,
        ];
        if ($this->attemptLogin($data_request)) {
            return $this->sendLoginResponse($data_request);
        }

        return redirect()->route('guest');
    }

    /**
     * Small cURL helper for SSO / SIMPEG calls.
     *
     * @param string     $url
     * @param array|null $postFields  POST body (null = GET)
     * @param array      $headers
     * @param bool       $assoc       decode JSON as array (true) or object (false)
     * @return mixed decoded JSON or null
     */
    protected function ssoRequest($url, $postFields = null, array $headers = [], $assoc = true, $urlencoded = null)
    {
        // Keycloak endpoints (assoc=true) need x-www-form-urlencoded; SIMPEG calls keep the old array body.
        $urlencoded = $urlencoded === null ? $assoc : $urlencoded;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if ($postFields !== null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $urlencoded ? http_build_query($postFields) : $postFields);
        }
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        curl_close($ch);

        return $response === false ? null : json_decode($response, $assoc);
    }

    /**
     * BACKUP of the previous SSO flow (JKD\SSO Keycloak provider). Not used anymore.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_old(Request $request)
    {
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
                        try {
                            $service_url    = 'https://simpeg.bps.go.id/api/bps16';
                            $curl           = curl_init($service_url);
                            $curl_post_data = array(
                                "apiKey" =>  "L2cvVWtDaE5sczVzTHFPaHBZT0Rzdz09.".$token,
                                "kategori"=> 'view_jabatan',
                                "nip" => $c_nip,
                            );
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
                            $curl_response = json_decode(curl_exec($curl));
                            if(!isset($curl_response->error)){
                                if(sizeof($curl_response)==0){
                                    print_r("Tidak ada Data");
                                }
                                else{
                                    foreach($curl_response as $res){
                                    $tmt = date("Y-m-d", strtotime($res->tmt) );
                                    $tglsk = null;
                                    if($res->tglsk){
                                        $tglsk = date("Y-m-d", strtotime($res->tglsk) );
                                    }
                                    DB::table('riwayat_sk')->updateOrInsert(
                                        [ 'niplama' => $res->niplama, 'nosk' => $res->nosk],
                                        [
                                            'flagstjab' => $res->flagstjab,
                                            'kdstjab' => $res->kdstjab,
                                            'urutreog' => $res->urutreog,
                                            'kdorg' => $res->kdorg,
                                            'flagwil' => $res->flagwil,
                                            'kdprop' => $res->kdprop,
                                            'kdkab' => $res->kdkab,
                                            'kdkec' => $res->kdkec,
                                            'tmt' => $tmt,
                                            'tglsk' => $tglsk,
                                            'penugasan' => $res->penugasan,
                                            'kdstkerja' => $res->kdstkerja,
                                            'nmstjab' => $res->nmstjab,
                                            'nmorg' => $res->nmorg,
                                            'nmwil' => $res->nmwil,
                                            'created_by' => 1,
                                        ]
                                    );
                                    }
                                    return redirect()->back();
                                }
                            }
                        } catch (Exception $e) {
                            print_r('Gagal Mendapatkan Riwayat SK: '.$e->getMessage());
                            die();
                        }

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
