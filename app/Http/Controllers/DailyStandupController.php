<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\DailyStandup;
use App\TimMaster;
use App\TimAnggota;
use App\Http\Resources\DailyStandupResource;

class DailyStandupController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Get list of daily standup data (JSON)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        
        // Filters
        $pegawaiNip = $request->get('pegawai_nip');
        $timId = $request->get('tim_id');
        $tanggal = $request->get('tanggal');
        $tanggalFrom = $request->get('tanggal_from');
        $tanggalTo = $request->get('tanggal_to');
        $keyword = $request->get('keyword', '');
        
        $query = DailyStandup::with(['timMaster', 'createdBy', 'updatedBy'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');
        
        // Apply filters
        if ($pegawaiNip && $pegawaiNip !== '') {
            $query->where('pegawai_nip', $pegawaiNip);
        }
        
        if ($timId && $timId !== '') {
            $query->where('tim_id', $timId);
        }
        
        if ($tanggal && $tanggal !== '') {
            $query->where('tanggal', $tanggal);
        }
        
        if ($tanggalFrom && $tanggalFrom !== '') {
            $query->where('tanggal', '>=', $tanggalFrom);
        }
        
        if ($tanggalTo && $tanggalTo !== '') {
            $query->where('tanggal', '<=', $tanggalTo);
        }
        
        // Search in isi and keterangan
        if ($keyword && $keyword !== '') {
            $query->where(function($q) use ($keyword) {
                $q->where('isi', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('keterangan', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        $datas = $query->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json([
            'success' => '1', 
            'datas' => DailyStandupResource::collection($datas->items()),
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
        $request->validate([
            'pegawai_nip' => 'required|string',
            'tim_id' => 'required|integer|exists:master_tim,id',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $model = new DailyStandup();
        
        $model->pegawai_nip = $request->pegawai_nip;
        $model->tim_id = $request->tim_id;
        $model->tanggal = $request->tanggal;
        $model->isi = $request->isi;
        $model->keterangan = $request->keterangan ?? null;
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();
        
        if ($model->save()) {
            $model->load(['timMaster', 'createdBy', 'updatedBy']);
            return response()->json([
                'success' => '1', 
                'message' => 'Data berhasil disimpan',
                'data' => new DailyStandupResource($model)
            ]);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menyimpan data'], 500);
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
        $request->validate([
            'pegawai_nip' => 'sometimes|required|string',
            'tim_id' => 'sometimes|required|integer|exists:master_tim,id',
            'tanggal' => 'sometimes|required|date',
            'isi' => 'sometimes|required|string',
            'keterangan' => 'nullable|string',
        ]);

        $model = DailyStandup::find($id);
        
        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($request->has('pegawai_nip')) {
            $model->pegawai_nip = $request->pegawai_nip;
        }
        if ($request->has('tim_id')) {
            $model->tim_id = $request->tim_id;
        }
        if ($request->has('tanggal')) {
            $model->tanggal = $request->tanggal;
        }
        if ($request->has('isi')) {
            $model->isi = $request->isi;
        }
        if ($request->has('keterangan')) {
            $model->keterangan = $request->keterangan;
        }
        
        $model->updated_by = Auth::id();
        
        if ($model->save()) {
            $model->load(['timMaster', 'createdBy', 'updatedBy']);
            return response()->json([
                'success' => '1', 
                'message' => 'Data berhasil diperbarui',
                'data' => new DailyStandupResource($model)
            ]);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal memperbarui data'], 500);
    }

    /**
     * Bulk insert multiple daily standup records
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'data' => 'required|array|min:1',
            'data.*.pegawai_nip' => 'required|string',
            'data.*.tim_id' => 'required|integer|exists:master_tim,id',
            'data.*.tanggal' => 'required|date',
            'data.*.isi' => 'required|string',
            'data.*.keterangan' => 'nullable|string',
        ]);

        $data = $request->data;
        $userId = Auth::id();
        $inserted = [];
        $failed = [];

        DB::beginTransaction();
        try {
            foreach ($data as $index => $item) {
                try {
                    $model = new DailyStandup();
                    $model->pegawai_nip = $item['pegawai_nip'];
                    $model->tim_id = $item['tim_id'];
                    $model->tanggal = $item['tanggal'];
                    $model->isi = $item['isi'];
                    $model->keterangan = $item['keterangan'] ?? null;
                    $model->created_by = $userId;
                    $model->updated_by = $userId;
                    
                    if ($model->save()) {
                        $inserted[] = [
                            'index' => $index,
                            'id' => $model->id,
                            'pegawai_nip' => $model->pegawai_nip,
                            'tanggal' => $model->tanggal
                        ];
                    } else {
                        $failed[] = [
                            'index' => $index,
                            'error' => 'Gagal menyimpan data'
                        ];
                    }
                } catch (\Exception $e) {
                    $failed[] = [
                        'index' => $index,
                        'error' => $e->getMessage()
                    ];
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => '1',
                'message' => 'Bulk insert selesai',
                'inserted_count' => count($inserted),
                'failed_count' => count($failed),
                'inserted' => $inserted,
                'failed' => $failed
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => '0',
                'message' => 'Gagal melakukan bulk insert: ' . $e->getMessage(),
                'inserted_count' => count($inserted),
                'failed_count' => count($failed),
                'inserted' => $inserted,
                'failed' => $failed
            ], 500);
        }
    }

    /**
     * Bulk update multiple daily standup records
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'data' => 'required|array|min:1',
            'data.*.id' => 'required|integer|exists:daily_standup,id',
            'data.*.pegawai_nip' => 'sometimes|required|string',
            'data.*.tim_id' => 'sometimes|required|integer|exists:master_tim,id',
            'data.*.tanggal' => 'sometimes|required|date',
            'data.*.isi' => 'sometimes|required|string',
            'data.*.keterangan' => 'nullable|string',
        ]);

        $data = $request->data;
        $userId = Auth::id();
        $updated = [];
        $failed = [];

        DB::beginTransaction();
        try {
            foreach ($data as $index => $item) {
                try {
                    $model = DailyStandup::find($item['id']);
                    
                    if ($model == null) {
                        $failed[] = [
                            'index' => $index,
                            'id' => $item['id'],
                            'error' => 'Data tidak ditemukan'
                        ];
                        continue;
                    }

                    if (isset($item['pegawai_nip'])) {
                        $model->pegawai_nip = $item['pegawai_nip'];
                    }
                    if (isset($item['tim_id'])) {
                        $model->tim_id = $item['tim_id'];
                    }
                    if (isset($item['tanggal'])) {
                        $model->tanggal = $item['tanggal'];
                    }
                    if (isset($item['isi'])) {
                        $model->isi = $item['isi'];
                    }
                    if (isset($item['keterangan'])) {
                        $model->keterangan = $item['keterangan'];
                    }
                    
                    $model->updated_by = $userId;
                    
                    if ($model->save()) {
                        $updated[] = [
                            'index' => $index,
                            'id' => $model->id,
                            'pegawai_nip' => $model->pegawai_nip,
                            'tanggal' => $model->tanggal
                        ];
                    } else {
                        $failed[] = [
                            'index' => $index,
                            'id' => $item['id'],
                            'error' => 'Gagal memperbarui data'
                        ];
                    }
                } catch (\Exception $e) {
                    $failed[] = [
                        'index' => $index,
                        'id' => isset($item['id']) ? $item['id'] : null,
                        'error' => $e->getMessage()
                    ];
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => '1',
                'message' => 'Bulk update selesai',
                'updated_count' => count($updated),
                'failed_count' => count($failed),
                'updated' => $updated,
                'failed' => $failed
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => '0',
                'message' => 'Gagal melakukan bulk update: ' . $e->getMessage(),
                'updated_count' => count($updated),
                'failed_count' => count($failed),
                'updated' => $updated,
                'failed' => $failed
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        $id = $id ?? $request->id ?? $request->form_id_data;
        
        if ($id == 0 || $id == '') {
            return response()->json(['success' => '0', 'message' => 'ID tidak valid'], 400);
        }

        $model = DailyStandup::find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($model->delete()) {
            return response()->json(['success' => '1', 'message' => 'Data berhasil dihapus']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menghapus data'], 500);
    }

    /**
     * Show the form for creating daily standup by Tim
     *
     * @return \Illuminate\Http\Response
     */
    public function createByTim()
    {
        $list_tim = TimMaster::orderBy('nama_tim', 'asc')->get();
        
        return view('daily_standup.create_by_tim', compact('list_tim'));
    }

    /**
     * Get anggota list by tim_id (AJAX)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAnggotaByTim(Request $request)
    {
        $timId = $request->get('tim_id');
        
        if (!$timId) {
            return response()->json([
                'success' => '0',
                'message' => 'Tim ID tidak valid',
                'data' => []
            ], 400);
        }

        $anggota = TimAnggota::where('id_tim', $timId)
            ->where('is_active', 1)
            ->orderBy('nama_anggota', 'asc')
            ->get();

        return response()->json([
            'success' => '1',
            'data' => $anggota->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama_anggota' => $item->nama_anggota,
                    'nik_anggota' => $item->nik_anggota,
                ];
            })
        ]);
    }

    /**
     * Store daily standup data by Tim (bulk insert for all anggota)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeByTim(Request $request)
    {
        $request->validate([
            'tim_id' => 'required|integer|exists:master_tim,id',
            'tanggal' => 'required|date',
            'data' => 'required|array|min:1',
            'data.*.nik_anggota' => 'required|string',
            'data.*.isi' => 'required|string',
        ]);

        $timId = $request->tim_id;
        $tanggal = $request->tanggal;
        $data = $request->data;
        $userId = Auth::id();
        $inserted = [];
        $failed = [];

        DB::beginTransaction();
        try {
            foreach ($data as $index => $item) {
                // Skip if isi is empty
                if (empty(trim($item['isi']))) {
                    continue;
                }

                try {
                    $model = new DailyStandup();
                    $model->pegawai_nip = $item['nik_anggota'];
                    $model->tim_id = $timId;
                    $model->tanggal = $tanggal;
                    $model->isi = $item['isi'];
                    $model->keterangan = null;
                    $model->created_by = $userId;
                    $model->updated_by = $userId;
                    
                    if ($model->save()) {
                        $inserted[] = [
                            'index' => $index,
                            'id' => $model->id,
                            'pegawai_nip' => $model->pegawai_nip,
                        ];
                    } else {
                        $failed[] = [
                            'index' => $index,
                            'pegawai_nip' => $item['nik_anggota'],
                            'error' => 'Gagal menyimpan data'
                        ];
                    }
                } catch (\Exception $e) {
                    $failed[] = [
                        'index' => $index,
                        'pegawai_nip' => $item['nik_anggota'] ?? 'unknown',
                        'error' => $e->getMessage()
                    ];
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => '1',
                'message' => 'Data daily standup berhasil disimpan',
                'inserted_count' => count($inserted),
                'failed_count' => count($failed),
                'inserted' => $inserted,
                'failed' => $failed
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => '0',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'inserted_count' => count($inserted),
                'failed_count' => count($failed),
                'inserted' => $inserted,
                'failed' => $failed
            ], 500);
        }
    }
}
