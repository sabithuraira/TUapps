<?php

namespace App\Http\Controllers;

use App\Http\Requests\SertifikatIndukRequest;
use App\Imports\SertifikatPesertaNamaImport;
use App\SertifikatInduk;
use App\SertifikatPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SertifikatIndukController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search', '');
        $query = SertifikatInduk::query()->orderBy('created_at', 'desc');

        if (strlen($keyword) > 0) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kegiatan', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('kode_satker', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('klasifikasi_arsip', 'LIKE', '%'.$keyword.'%');
            });
        }

        $list = $query->withCount('peserta')->paginate();
        $list->withPath('sertifikat_induk');
        $list->appends($request->all());

        return view('sertifikat_induk.index', compact('list', 'keyword'));
    }

    public function create()
    {
        $model = new SertifikatInduk;
        $model->tanggal = date('Y-m-d');
        $id = '';

        return view('sertifikat_induk.create', compact('model', 'id'));
    }

    public function store(SertifikatIndukRequest $request)
    {
        $names = $this->collectPesertaNames($request);
        if (count($names) === 0) {
            return redirect()->back()
                ->withInput($request->except(['excel_peserta']))
                ->withErrors(['peserta_nama' => 'Minimal satu nama peserta (isi tabel atau unggah Excel).']);
        }

        DB::transaction(function () use ($request, $names) {
            $induk = new SertifikatInduk;
            $induk->kegiatan = $request->kegiatan;
            $induk->deskripsi = $request->deskripsi;
            $induk->tanggal = $request->tanggal;
            $induk->kode_satker = $request->kode_satker;
            $induk->klasifikasi_arsip = $request->klasifikasi_arsip;
            $induk->nomor_urut_start = null;
            $induk->nomor_urut_end = null;
            $induk->save();

            $this->replacePesertaForInduk($induk, $names);
        });

        return redirect('sertifikat_induk')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $realId = Crypt::decrypt($id);
        $model = SertifikatInduk::with(['peserta' => function ($q) {
            $q->orderBy('nomor_urut');
        }])->findOrFail($realId);

        return view('sertifikat_induk.show', compact('model', 'id'));
    }

    public function edit($id)
    {
        $realId = Crypt::decrypt($id);
        $model = SertifikatInduk::with(['peserta' => function ($q) {
            $q->orderBy('nomor_urut');
        }])->findOrFail($realId);

        return view('sertifikat_induk.edit', compact('model', 'id'));
    }

    public function update(SertifikatIndukRequest $request, $id)
    {
        $realId = Crypt::decrypt($id);
        $names = $this->collectPesertaNames($request);
        if (count($names) === 0) {
            return redirect()->back()
                ->withInput($request->except(['excel_peserta']))
                ->withErrors(['peserta_nama' => 'Minimal satu nama peserta (isi tabel atau unggah Excel).']);
        }

        DB::transaction(function () use ($request, $realId, $names) {
            $induk = SertifikatInduk::findOrFail($realId);
            $induk->kegiatan = $request->kegiatan;
            $induk->deskripsi = $request->deskripsi;
            $induk->tanggal = $request->tanggal;
            $induk->kode_satker = $request->kode_satker;
            $induk->klasifikasi_arsip = $request->klasifikasi_arsip;
            $induk->save();

            $this->replacePesertaForInduk($induk, $names);
        });

        return redirect('sertifikat_induk')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $model = SertifikatInduk::findOrFail($id);
        $model->delete();

        return redirect('sertifikat_induk')->with('success', 'Data berhasil dihapus');
    }

    /**
     * AJAX: baca kolom pertama Excel sebagai daftar nama.
     */
    public function importPesertaExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $import = new SertifikatPesertaNamaImport;
        Excel::import($import, $request->file('excel_file'));

        return response()->json(['success' => true, 'names' => $import->names]);
    }

    private function collectPesertaNames(Request $request)
    {
        $names = array_values(array_filter(array_map(function ($n) {
            return trim((string) $n);
        }, $request->input('peserta_nama', [])), function ($n) {
            return $n !== '';
        }));

        if ($request->hasFile('excel_peserta')) {
            $import = new SertifikatPesertaNamaImport;
            Excel::import($import, $request->file('excel_peserta'));
            $names = array_merge($names, $import->names);
        }

        return $names;
    }

    /**
     * Nomor urut peserta berlanjut per tahun kalender (dari tanggal induk).
     * Mengabaikan baris peserta milik induk ini agar penyimpanan ulang tidak melonjak nomor.
     */
    private function nextNomorUrutStartForYear(SertifikatInduk $induk)
    {
        $year = \Carbon\Carbon::parse($induk->tanggal)->year;

        $maxUrut = SertifikatPeserta::query()
            ->join('sertifikat_induk', 'sertifikat_peserta.sertifikat_induk_id', '=', 'sertifikat_induk.id')
            ->whereYear('sertifikat_induk.tanggal', $year)
            ->where('sertifikat_induk.id', '!=', $induk->id)
            ->max('sertifikat_peserta.nomor_urut');

        return $maxUrut !== null ? (int) $maxUrut + 1 : 1;
    }

    private function replacePesertaForInduk(SertifikatInduk $induk, array $names)
    {
        $startUrut = $this->nextNomorUrutStartForYear($induk);

        $induk->peserta()->delete();

        foreach ($names as $idx => $nama) {
            $urut = $startUrut + $idx;
            SertifikatPeserta::create([
                'sertifikat_induk_id' => $induk->id,
                'nama_peserta' => $nama,
                'nomor_urut' => $urut,
                'nomor_sertifikat' => SertifikatInduk::formatNomorSertifikat(
                    $urut,
                    $induk->kode_satker,
                    $induk->klasifikasi_arsip,
                    $induk->tanggal
                ),
            ]);
        }

        $induk->refreshNomorUrutRangeFromPeserta();
    }
}
