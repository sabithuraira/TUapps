<?php

namespace App\Http\Controllers;

use App\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    public function dataBulletin(Request $request)
    {
        $datas = array();
        $datas = Bulletin::join('users', 'bulletin.user_id', '=', 'users.id')
            ->select('bulletin.id', 'judul', 'user_id', 'users.name as user_name', 'start_date', 'end_date', 'deskripsi')
            ->get();
        return response()->json([
            'success' => 'Sukses',
            'datas' => $datas
        ]);
    }

    public function index(Request $request)
    {
        $auth = Auth::user();
        $unit_kerja = Auth::user()->kdkab;

        if ($request->all() == []) {
            $unit_kerja = Auth::user()->kdkab;
        } else {
            $unit_kerja = $request->get('unit_kerja');
        }

        $judul = $request->get('judul');
        $user = $request->get('user_id');

        $datas = Bulletin::where('judul', "LIKE", "%" . $judul . "%")
            ->join('users', 'users.id', '=', 'bulletin.user_id')
            ->where('users.kdkab', 'LIKE', '%' . $request->get('unit_kerja') . "%")
            ->orderby("bulletin.id", 'desc')->paginate(15);

        $datas->withPath('bulletin');
        $datas->appends($request->all());
        $model = new Bulletin();
        $list_pegawai = \App\UserModel::where([
            ['id', '<>', 1],
            // ['kdkab', '=', $unit_kerja],
            ['is_active', 1]
        ])->orderby('kdkab', 'asc')->orderby('nip_baru')->get();
        $list_judul = $model->getListJudul();
        return view('bulletin.index', compact(
            'auth',
            'datas',
            'judul',
            'user',
            'unit_kerja',
            'model',
            'list_judul',
            'list_pegawai'
        ));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $model = Bulletin::find($request->get("id"));
        if ($model == null) {
            $model = new Bulletin();
            $model->created_by = Auth::id();
        }

        $model->judul = $request->get('judul');
        $model->user_id = $request->get('user_id');
        $model->start_date = date("Y-m-d", strtotime($request->get('waktu_mulai')));;
        $model->end_date = date("Y-m-d", strtotime($request->get('waktu_selesai')));
        $model->deskripsi = $request->get('deskripsi');
        $model->updated_by = Auth::id();
        $model->save();

        return response()->json(['success' => 'Data berhasil ditambah']);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $model = Bulletin::find($id);
        $model->delete();
        return response()->json(['success' => 'Sukses']);
    }
}
