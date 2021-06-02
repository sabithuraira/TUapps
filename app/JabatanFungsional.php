<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JabatanFungsional extends Model
{
    //
    protected $table = 'jafung_kegiatan';

    public function attributes()
    {
        return (new \App\Http\Requests\MasterBarangRequest())->attributes();
    }

    public function calldata()
    {
        $datas = null;
        $jabatan = DB::select('select * from jafung_jabatan');
        $datas = $jabatan;
        foreach ($jabatan as $key1 => $value1) {
            $judul = DB::select('select * from jafung_judul where id_jabatan = :id_jabatan', ['id_jabatan' => $value1->id_jabatan]);
            $datas[$key1]->judul = $judul;
            foreach ($judul as $key2 => $value2) {
                $subjudul = DB::select('select * from jafung_subjudul where id_judul = :id_judul', ['id_judul' => $value2->id_judul]);
                $datas[$key1]->judul[$key2]->subjudul = $subjudul;
                foreach ($subjudul as $key3 => $value3) {
                    // $kegiatan = DB::select('select * from jafung_kegiatan where id_subjudul = :id_subjudul ', ['id_subjudul' => $value3->id_subjudul],  'AND where id_judul = :id_judul', ['id_judul' => $value2->id_judul]);
                    $kegiatan = DB::table('jafung_kegiatan')->where('id_subjudul', $value3->id_subjudul)->where('id_judul', $value2->id_judul)->get()->toArray();
                    $datas[$key1]->judul[$key2]->subjudul[$key3]->kegiatan = $kegiatan;
                    foreach ($kegiatan as $key4 => $value4) {
                        $subkegiatan = DB::table('jafung_subkegiatan')->where('id_kegiatan', $value4->id_kegiatan)->where('id_subjudul', $value3->id_subjudul)->where('id_judul', $value2->id_judul)->get()->toArray();
                        $datas[$key1]->judul[$key2]->subjudul[$key3]->kegiatan[$key4]->subkegiatan = $subkegiatan;
                    }
                }
            }
        }
        // dd($datas);
        return $datas;
    }
}
