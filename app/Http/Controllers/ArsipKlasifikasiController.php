<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ArsipKlasifikasi;

class ArsipKlasifikasiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('arsip_klasifikasi.index');
    }

    /**
     * Load data for AJAX requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadData(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $keyword = $request->get('keyword', '');
        
        $query = ArsipKlasifikasi::orderBy('kode_gabung', 'asc');
        
        // Apply search filter if provided
        if ($keyword && $keyword !== '') {
            $query->where(function($q) use ($keyword) {
                $q->where('kode_gabung', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('judul', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('kode', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        $datas = $query->paginate($perPage);

        return response()->json([
            'success' => '1', 
            'datas' => $datas->items(),
            'pagination' => [
                'current_page' => $datas->currentPage(),
                'last_page' => $datas->lastPage(),
                'per_page' => $datas->perPage(),
                'total' => $datas->total(),
                'from' => $datas->firstItem(),
                'to' => $datas->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new ArsipKlasifikasi();
        
        // Check if updating existing record
        if ($request->form_id_data != 0 && $request->form_id_data != '') {
            $model = ArsipKlasifikasi::find($request->form_id_data);
            if ($model == null) {
                return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
            }
        }

        $model->kode = $request->form_kode;
        $model->kode_2 = $request->form_kode_2;
        $model->kode_3 = $request->form_kode_3;
        $model->kode_4 = $request->form_kode_4;
        $model->kode_gabung = $request->form_kode_gabung;
        $model->judul = $request->form_judul;
        
        if ($request->form_id_data == 0 || $request->form_id_data == '') {
            $model->created_by = Auth::id();
        }
        $model->updated_by = Auth::id();
        
        if ($model->save()) {
            return response()->json(['success' => '1', 'message' => 'Data berhasil disimpan']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menyimpan data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->form_id_data ?? $request->id;
        
        if ($id == 0 || $id == '') {
            return response()->json(['success' => '0', 'message' => 'ID tidak valid']);
        }

        $model = ArsipKlasifikasi::find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        if ($model->delete()) {
            return response()->json(['success' => '1', 'message' => 'Data berhasil dihapus']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menghapus data']);
    }
}
