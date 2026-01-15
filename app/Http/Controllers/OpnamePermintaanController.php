<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\OpnamePermintaan;
use App\OpnamePengurangan;
use PDF;

class OpnamePermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = OpnamePermintaan::with(['masterBarang', 'unitKerja', 'unitKerja4', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json(['success' => '1', 'datas' => $datas]);
        }

        $master_barang = \App\MasterBarang::all();
        $unit_kerja = \App\UnitKerja::all();
        $unit_kerja4 = \App\UnitKerja4::all();

        return view('opname_permintaan.index', compact('datas', 'master_barang', 'unit_kerja', 'unit_kerja4'));
    }

    /**
     * Load data for AJAX requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadData(Request $request)
    {
        $datas = OpnamePermintaan::with(['masterBarang', 'unitKerja', 'unitKerja4', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => '1', 'datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $master_barang = \App\MasterBarang::all();
        $unit_kerja = \App\UnitKerja::all();
        $unit_kerja4 = \App\UnitKerja4::all();

        return view('opname_permintaan.form', compact('master_barang', 'unit_kerja', 'unit_kerja4'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new OpnamePermintaan();
        
        // Check if updating existing record
        if ($request->form_id_data != 0 && $request->form_id_data != '') {
            $model = OpnamePermintaan::find($request->form_id_data);
            if ($model == null) {
                return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
            }
        }

        $model->id_barang = $request->form_id_barang;
        $model->tanggal_permintaan = date('Y-m-d', strtotime($request->form_tanggal_permintaan));
        
        if (strlen($request->form_tanggal_penyerahan) > 0) {
            $model->tanggal_penyerahan = date('Y-m-d', strtotime($request->form_tanggal_penyerahan));
        }
        
        $model->jumlah_diminta = $request->form_jumlah_diminta;
        
        if (strlen($request->form_jumlah_disetujui) > 0) {
            $model->jumlah_disetujui = $request->form_jumlah_disetujui;
        }
        
        $model->unit_kerja = $request->form_unit_kerja;
        $model->unit_kerja4 = $request->form_unit_kerja4;
        $model->status_aktif = $request->form_status_aktif ?? 1;
        
        if ($request->form_id_data == 0 || $request->form_id_data == '') {
            $model->created_by = Auth::id();
        }
        $model->updated_by = Auth::id();
        
        if ($model->save()) {
            return response()->json(['success' => 'Data berhasil disimpan']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menyimpan data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = OpnamePermintaan::with(['masterBarang', 'unitKerja', 'unitKerja4'])
            ->find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        return response()->json(['success' => '1', 'data' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = OpnamePermintaan::find($id);
        $master_barang = \App\MasterBarang::all();
        $unit_kerja = \App\UnitKerja::all();
        $unit_kerja4 = \App\UnitKerja4::all();

        return view('opname_permintaan.form', compact('model', 'master_barang', 'unit_kerja', 'unit_kerja4'));
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
        $model = OpnamePermintaan::find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        $model->id_barang = $request->form_id_barang;
        $model->tanggal_permintaan = date('Y-m-d', strtotime($request->form_tanggal_permintaan));
        
        if (strlen($request->form_tanggal_penyerahan) > 0) {
            $model->tanggal_penyerahan = date('Y-m-d', strtotime($request->form_tanggal_penyerahan));
        } else {
            $model->tanggal_penyerahan = null;
        }
        
        $model->jumlah_diminta = $request->form_jumlah_diminta;
        
        if (strlen($request->form_jumlah_disetujui) > 0) {
            $model->jumlah_disetujui = $request->form_jumlah_disetujui;
        } else {
            $model->jumlah_disetujui = null;
        }
        
        $model->unit_kerja = $request->form_unit_kerja;
        $model->unit_kerja4 = $request->form_unit_kerja4;
        $model->status_aktif = $request->form_status_aktif ?? 1;
        $model->updated_by = Auth::id();

        if ($model->save()) {
            return response()->json(['success' => 'Data berhasil diperbarui']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal memperbarui data']);
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

        $model = OpnamePermintaan::find($id);

        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        if ($model->delete()) {
            return response()->json(['success' => 'Data berhasil dihapus']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal menghapus data']);
    }

    /**
     * Display the process page for managing permintaan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function proses(Request $request)
    {
        $model = new OpnamePermintaan();
        $list_status_aktif = $model->listStatusAktif;
        $unit_kerja4 = \App\UnitKerja4::all();
        $master_barang = \App\MasterBarang::all();
        
        return view('opname_permintaan.proses', compact('list_status_aktif', 'unit_kerja4', 'master_barang'));
    }

    /**
     * Load data for process page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadDataProses(Request $request)
    {
        $query = OpnamePermintaan::with(['masterBarang', 'unitKerja', 'unitKerja4', 'createdBy']);
        
        // Filter by status_aktif
        if ($request->has('filter_status_aktif') && $request->filter_status_aktif !== '' && $request->filter_status_aktif !== null) {
            $query->where('status_aktif', $request->filter_status_aktif);
        }
        
        // Filter by unit_kerja4
        if ($request->has('filter_unit_kerja4') && $request->filter_unit_kerja4 !== '' && $request->filter_unit_kerja4 !== null) {
            $query->where('unit_kerja4', $request->filter_unit_kerja4);
        }
        
        $datas = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['success' => '1', 'datas' => $datas]);
    }

    /**
     * Update process data (tanggal_penyerahan, jumlah_disetujui, status_aktif)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProses(Request $request)
    {
        $model = OpnamePermintaan::find($request->form_id_data);
        
        if ($model == null) {
            return response()->json(['success' => '0', 'message' => 'Data tidak ditemukan']);
        }

        if (strlen($request->form_tanggal_penyerahan) > 0) {
            $model->tanggal_penyerahan = date('Y-m-d', strtotime($request->form_tanggal_penyerahan));
        } else {
            $model->tanggal_penyerahan = null;
        }
        
        if (strlen($request->form_jumlah_disetujui) > 0) {
            $model->jumlah_disetujui = $request->form_jumlah_disetujui;
        } else {
            $model->jumlah_disetujui = null;
        }
        
        $model->status_aktif = $request->form_status_aktif ?? 1;
        $model->updated_by = Auth::id();

        if ($model->save()) {
            // If status is "Disetujui" (2), save to opname_pengurangan table
            if ($model->status_aktif == 2 && $request->form_id_barang_pengurangan) {
                // Get the selected barang to get harga_satuan
                $barang = \App\MasterBarang::find($request->form_id_barang_pengurangan);
                
                if ($barang && $model->tanggal_penyerahan && $model->jumlah_disetujui) {
                    // Extract bulan and tahun from tanggal_penyerahan
                    $tanggal_penyerahan = date('Y-m-d', strtotime($model->tanggal_penyerahan));
                    $bulan = date('n', strtotime($tanggal_penyerahan)); // 1-12
                    $tahun = date('Y', strtotime($tanggal_penyerahan));
                    
                    // Calculate harga_kurang = harga_satuan * jumlah_kurang
                    $harga_kurang = $barang->harga_satuan * $model->jumlah_disetujui;
                    
                    // Create opname_pengurangan record
                    $opnamePengurangan = new OpnamePengurangan();
                    $opnamePengurangan->id_barang = $request->form_id_barang_pengurangan;
                    $opnamePengurangan->bulan = $bulan;
                    $opnamePengurangan->tahun = $tahun;
                    $opnamePengurangan->jumlah_kurang = $model->jumlah_disetujui;
                    $opnamePengurangan->harga_kurang = $harga_kurang;
                    $opnamePengurangan->unit_kerja = $model->unit_kerja;
                    $opnamePengurangan->unit_kerja4 = $model->unit_kerja4;
                    $opnamePengurangan->tanggal = $tanggal_penyerahan;
                    $opnamePengurangan->created_by = Auth::id();
                    $opnamePengurangan->updated_by = Auth::id();
                    if ($opnamePengurangan->save()) {
                        $model_o = new \App\Opnamepersediaan();
                        $model_o->triggerPersediaan($request->form_id_barang_pengurangan, $bulan, 
                                $tahun, $barang->nama_barang);
                    }
                }
            }
            
            return response()->json(['success' => 'Data berhasil diperbarui']);
        }

        return response()->json(['success' => '0', 'message' => 'Gagal memperbarui data']);
    }

    /**
     * Print permintaan barang to PDF
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $model = OpnamePermintaan::with(['masterBarang', 'unitKerja', 'unitKerja4', 'createdBy'])
            ->find($id);

        if ($model == null) {
            abort(404, 'Data tidak ditemukan');
        }

        $unit_kerja = $model->unitKerja4 ? $model->unitKerja4->nama : '-';
        $penerima_nama = $model->createdBy ? $model->createdBy->name : '-';
        $penerima_nip = $model->createdBy ? $model->createdBy->nip_baru : '-';

        $tanggal_permintaan = $model->tanggal_permintaan ?: date('Y-m-d');
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $tanggal_label = date('d', strtotime($tanggal_permintaan)) . ' ' .
            ($months[(int) date('m', strtotime($tanggal_permintaan))] ?? date('F')) . ' ' .
            date('Y', strtotime($tanggal_permintaan));

        $pdf = PDF::loadView('opname_permintaan.print_permintaan', compact(
            'model',
            'unit_kerja',
            'penerima_nama',
            'penerima_nip',
            'tanggal_label'
        ))->setPaper('a4', 'portrait');

        $nama_file = 'permintaan_barang_' . $model->id . '.pdf';

        return $pdf->download($nama_file);
    }
}

