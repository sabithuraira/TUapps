<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CurhatAnon;

class CurhatAnonController extends Controller
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
        $model = new CurhatAnon();
        $list_status_verifikasi = $model->listStatusVerifikasi;
        
        return view('curhat_anon.index', compact('list_status_verifikasi'));
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
        $filterStatus = $request->get('filter_status_verifikasi');
        
        $query = CurhatAnon::orderBy('created_at', 'desc');
        
        // Apply filter if provided
        if ($filterStatus && $filterStatus !== '') {
            $query->where('status_verifikasi', $filterStatus);
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
        $model = new CurhatAnon();
        
        // Check if updating existing record
        if ($request->form_id_data != 0 && $request->form_id_data != '') {
            $model = CurhatAnon::find($request->form_id_data);
            if ($model == null) {
                return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
            }
        }

        $model->content = $request->form_content;
        $model->status_verifikasi = $request->form_status_verifikasi ?? 1;
        
        if ($request->form_id_data == 0 || $request->form_id_data == '') {
            // New record - no created_by/updated_by needed for anonymous
        }
        
        if ($model->save()) {
            return response()->json(['success' => 'Data berhasil disimpan']);
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

        $model = CurhatAnon::find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        if ($model->delete()) {
            return response()->json(['success' => 'Data berhasil dihapus']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menghapus data']);
    }

    /**
     * Get approved curhats for public display
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getApprovedCurhats(Request $request)
    {
        $limit = $request->get('limit', 10);
        
        $datas = CurhatAnon::where('status_verifikasi', 2) // Disetujui
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => '1', 
            'datas' => $datas
        ]);
    }
}

