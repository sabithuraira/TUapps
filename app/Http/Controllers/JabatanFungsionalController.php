<?php

namespace App\Http\Controllers;

use App\JabatanFungsional;
use Hamcrest\Core\HasToString;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;

class JabatanFungsionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        // $datas = JabatanFungsional::join('jafung_subjudul', 'jafung_subjudul.id_subjudul', '=', 'jafung_kegiatan.id_subjudul')
        //     ->join('jafung_judul', 'jafung_judul.id_judul', '=', 'jafung_subjudul.id_judul')
        //     ->join('jafung_jabatan', 'jafung_jabatan.id_jabatan', '=', 'jafung_judul.id_jabatan')
        //     ->get();
        $jafung =  new JabatanFungsional();
        $datas = $jafung->calldata();
        // dd($datas);
        return view('jabatan_fungsional.index', compact('keyword', 'datas'));
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

    public function tambah_jabatan(Request $request)
    {
        // $model = new \App\JabatanFungsional();
        $id = DB::table('jafung_jabatan')->max('id_jabatan') + 1;
        $jabatan = $request->all();
        DB::table('jafung_jabatan')->insert([
            'id_jabatan' =>  $id,
            'Jabatan' => $request->jabatan,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        return redirect('/jabatan_fungsional');
    }

    public function hapus_jabatan(Request $request)
    {
        $id = $request->id_jabatan;
        // dd
        $affected = DB::table('jafung_jabatan')->where('id_jabatan', '=', $id)->delete();
        // dd($affected);
        return redirect('/jabatan_fungsional');
    }

    public function tambah_row(Request $request)
    {
        $model = Collection::make();
        $model->id_jabatan = $request->idjabatan;
        $model->id_judul = $request->idjudul;
        $model->judul = $request->judulbaru;
        $model->id_subjudul = $request->idsubjudul;
        $model->subjudul = $request->subjudulbaru;
        $model->id_kegiatan = $request->idkegiatan;
        $model->kegiatan = $request->kegiatanbaru;
        $model->subkegiatan = $request->subkegiatanbaru;

        if ($request->idjudul) {
            #judul lama
        } else {
            $model->id_judul = DB::table('jafung_judul')->where('id_jabatan', '=', $model->id_jabatan)->max('id_judul') + 1;
            DB::table('jafung_judul')->insert([
                'id_jabatan' => $model->id_jabatan,
                'id_judul' => $model->id_judul,
                'judul' => $model->judul,
                'created_by' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if ($request->idsubjudul) {
            #subjudul lama
        } else {
            if ($request->subjudulbaru) {
                $model->id_subjudul = DB::table('jafung_subjudul')->where('id_judul', '=', $model->id_judul)->max('id_subjudul') + 1;
                // dd($model);
                DB::table('jafung_subjudul')->insert([
                    'id_jabatan' => $model->id_jabatan,
                    'id_judul' => $model->id_judul,
                    'id_subjudul' => $model->id_subjudul,
                    'subjudul' => $model->subjudul,
                    'created_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::id(),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        if ($request->idkegiatan) {
            #kegiatan lama

        } else {
            // dd($request->all());
            if ($request->kegiatanbaru) {
                $model->id_kegiatan = DB::table('jafung_kegiatan')->where('id_judul', '=', $model->id_judul)->where('id_subjudul', '=', $model->id_subjudul)->max('id_kegiatan') + 1;
                // dd($model);
                DB::table('jafung_kegiatan')->insert([
                    'id_jabatan' => $model->id_jabatan,
                    'id_judul' => $model->id_judul,
                    'id_subjudul' => $model->id_subjudul,
                    'id_kegiatan' => $model->id_kegiatan,
                    'kegiatan' => $model->kegiatan,
                    'created_by' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::id(),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            // dd($model);
        }

        if ($request->subkegiatanbaru) {
            $model->id_subkegiatan = DB::table('jafung_subkegiatan')->where('id_judul', '=', $model->id_judul)
                ->where('id_subjudul', '=', $model->id_subjudul)->where('id_kegiatan', '=', $model->id_kegiatan)
                ->max('id_subkegiatan') + 1;
            DB::table('jafung_subkegiatan')->insert([
                'id_jabatan' => $model->id_jabatan,
                'id_judul' => $model->id_judul,
                'id_subjudul' => $model->id_subjudul,
                'id_kegiatan' => $model->id_kegiatan,
                'id_subkegiatan' => $model->id_subkegiatan,
                'subkegiatan' => $model->subkegiatan,
                'created_by' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::id(),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        return redirect('/jabatan_fungsional');
    }

    public function edit_judul(Request $request)
    {
        // dd($request->all());
        DB::table('jafung_judul')
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)
            ->update(['judul' => $request->judul]);
        return redirect('/jabatan_fungsional');
    }
    public function edit_subjudul(Request $request)
    {
        // dd($request->all());
        DB::table('jafung_subjudul')->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)
            ->update(['subjudul' => $request->subjudul]);
        return redirect('/jabatan_fungsional');
    }
    public function edit_kegiatan(Request $request)
    {
        // dd($request->all());
        DB::table('jafung_kegiatan')->where('id_kegiatan', $request->id_kegiatan)->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)
            ->update([
                'kegiatan' => $request->kegiatan, 'satuan_hasil' => $request->satuan_hasil,
                'angka_kredit' => $request->angka_kredit, 'batasan_penilaian' => $request->batasan_penilaian,
                'pelaksana' => $request->pelaksana, 'bukti_fisik' => $request->bukti_fisik
            ]);
        return redirect('/jabatan_fungsional');
    }
    public function edit_subkegiatan(Request $request)
    {
        // dd($request->all());
        DB::table('jafung_subkegiatan')->where('id_subkegiatan', $request->id_subkegiatan)->where('id_kegiatan', $request->id_kegiatan)->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)
            ->update([
                'subkegiatan' => $request->subkegiatan, 'satuan_hasil' => $request->satuan_hasil,
                'angka_kredit' => $request->angka_kredit, 'batasan_penilaian' => $request->batasan_penilaian,
                'pelaksana' => $request->pelaksana, 'bukti_fisik' => $request->bukti_fisik
            ]);
        return redirect('/jabatan_fungsional');
    }

    public function hapus(Request $request)
    {

        // $id = $request->id_jabatan;
        // dd
        if (!$request->id_subkegiatan) {
            if (!$request->id_kegiatan) {
                if (!$request->id_subjudul) {
                    if (!$request->id_judul) {
                    }
                    #ada id_judul

                    $this->hapus_judul($request);
                }
                #ada id_subjudul

                $this->hapus_subjudul($request);
            }
            #ada id_kegiatan

            $this->hapus_kegiatan($request);
        }
        # ada id_subkegiatan
        $this->hapus_subkegiatan($request);

        return redirect('/jabatan_fungsional');
    }

    function hapus_judul(Request $request)
    {
        DB::table('jafung_judul')->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
        DB::table('jafung_subjudul')->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
        DB::table('jafung_kegiatan')->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
        DB::table('jafung_subkegiatan')->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
    }
    function hapus_subjudul(Request $request)
    {
        DB::table('jafung_subjudul')->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
        DB::table('jafung_kegiatan')->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
        DB::table('jafung_subkegiatan')->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
    }
    function hapus_kegiatan(Request $request)
    {
        DB::table('jafung_kegiatan')->where('id_kegiatan', $request->id_kegiatan)->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
        DB::table('jafung_subkegiatan')->where('id_kegiatan', $request->id_kegiatan)->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
    }
    function hapus_subkegiatan(Request $request)
    {
        DB::table('jafung_subkegiatan')->where('id_subkegiatan', $request->id_subkegiatan)->where('id_kegiatan', $request->id_kegiatan)->where('id_subjudul', $request->id_subjudul)
            ->where('id_judul', $request->id_judul)->where('id_jabatan', $request->id_jabatan)->delete();
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
        //
    }
}
