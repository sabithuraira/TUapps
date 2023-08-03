<?php

namespace App\Http\Controllers;

use App\RiwayatSK;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $request->session()->get('token');
        $keyword = $request->get('search');
        $datas = \App\User::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('user');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('user.list', array('datas' => $datas))->render());
        }

        return view('user.index', compact('datas', 'keyword', 'token'));
    }

    public function riwayat(Request $request)
    {
        // dd('riwayat');
        try {
            $token = $request->session()->get('token');
            $service_url    = 'https://simpeg.bps.go.id/api/bps16';
            $curl           = curl_init($service_url);
            $curl_post_data = array(
                "apiKey" =>  "L2cvVWtDaE5sczVzTHFPaHBZT0Rzdz09." . $token,
                "kategori" => 'view_jabatan',
                // "nip" => $c_nip,
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = json_decode(curl_exec($curl));
            if (!isset($curl_response->error)) {
                // dd($curl_response);
                if (sizeof($curl_response) == 0) {
                    print_r("Tidak ada Data");
                } else {
                    foreach ($curl_response as $res) {
                        $tmt = date("Y-m-d", strtotime($res->tmt));
                        $tglsk = null;
                        if ($res->tglsk) {
                            $tglsk = date("Y-m-d", strtotime($res->tglsk));
                        }
                        DB::table('riwayat_sk')->updateOrInsert(
                            ['niplama' => $res->niplama, 'nosk' => $res->nosk],
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
                    return redirect()->back()->with('success', 'Berhasil Disimpan');
                }
            } else {
                return redirect()->back()->with('error', $curl_response);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e);
            // die();
        }
    }


    public function load_data_pegawai(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            $service_url    = 'https://simpeg.bps.go.id/api/bps16';
            $curl           = curl_init($service_url);
            $curl_post_data = array(
                "apiKey" =>  "L2cvVWtDaE5sczVzTHFPaHBZT0Rzdz09." . $token,
                "kategori" => 'view_pegawai',
                // "nip" => $c_nip,
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = json_decode(curl_exec($curl));

            if (!isset($curl_response->error)) {
                // dd($curl_response->pegawai);
                if (sizeof($curl_response->pegawai) == 0) {
                    print_r("Tidak ada Data");
                } else {
                    foreach ($curl_response->pegawai as $res) {
                        // dd($res);

                        // if ($res->niplama == "340054178") {
                        //     dd($res);
                        // }
                        $model = \App\User::where('email', '=', $res->niplama)->first();
                        $c_model = $res;
                        // dd($c_model);
                        if ($model == null) {
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
                    }
                    return redirect()->back()->with('success', 'Berhasil Disimpan');
                }
            } else {
                return redirect()->back()->with('error', $curl_response);
            }
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('error', $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $model = \App\UserModel::find($id);

        $list_pegawai = \App\UserModel::where([
            ['id', '<>', 1],
            ['kdkab', '=', $model->kdkab]
        ])
            ->orWhere([['kdesl', '=', 2],])
            ->orderBy('name', 'ASC')->get();

        return view('user.edit', compact(
            'model',
            'id',
            'list_pegawai'
        ));
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
        if (isset($request->validator) && $request->validator->fails()) {
            return redirect('user/edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $model = \App\UserModel::find($id);
        $pimpinan = \App\UserModel::find($request->pimpinan_id);
        if ($pimpinan != null) {
            $model->pimpinan_id    = $pimpinan->id;
            $model->pimpinan_nik    = $pimpinan->nip_baru;
            $model->pimpinan_nama    = $pimpinan->name;
            $model->pimpinan_jabatan    = $pimpinan->nmjab;
            $model->save();
        }

        return redirect('user');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = \App\User::find($id);
        $model->delete();
        return redirect('user')->with('success', 'Information has been  deleted');
    }
}
