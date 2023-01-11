<?php

namespace App\Http\Controllers;

use App\RiwayatSK;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $datas = \App\User::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->paginate();

        $datas->withPath('user');
        $datas->appends($request->all());

        if ($request->ajax()) {
            return \Response::json(\View::make('user.list', array('datas' => $datas))->render());
        }

        return view('user.index',compact('datas', 'keyword'));
    }

    public function riwayat(Request $request){
        // dd('riwayat');
        try {
            $token = $request->session()->get('token');
            $service_url    = 'https://simpeg.bps.go.id/api/bps16';
            $curl           = curl_init($service_url);
            $curl_post_data = array(
                "apiKey" =>  "L2cvVWtDaE5sczVzTHFPaHBZT0Rzdz09.".$token,
                "kategori"=> 'view_jabatan',
                // "nip" => $c_nip,
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
                    return redirect()->back()->with('success', 'Berhasil Disimpan');
                }
            }else{
                return redirect()->back()->with('error', $curl_response);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e);
            // die();
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
        //
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
        $model = \App\User::find($id);
        $model->delete();
        return redirect('user')->with('success','Information has been  deleted');
    }
}
