<?php
namespace App\Imports;

use App\PokAktivitas;
use App\PokKomponen;
use App\PokKro;
use App\PokMataAnggaran;
use App\PokProgram;
use App\PokRincianAnggaran;
use App\PokRo;
use App\PokSubKomponen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class PokImport implements ToCollection
{
    use Importable;
    public $tahun;

    public function __construct($tahun) {
        $this->tahun = $tahun;
    }

    public function collection(Collection $rows){
        $last_id_program = 0;
        $last_id_aktivitas = 0;
        $last_id_kro = 0;
        $last_id_ro = 0;
        $last_id_komponen = 0;
        $last_id_sub_komponen = 0;
        $last_id_mata_anggaran = 0;
        
        foreach ($rows as $key=>$row){
            if($key>6){
                // print_r($row);die();
                if($row[1]!=''){
                    $len_col0 = strlen(str_replace(' ','',$row[0])) ;

                    if($len_col0==0){ //rincian anggaran
                        $model = new PokRincianAnggaran;
                        $model->id_mata_anggaran = $last_id_mata_anggaran;
                        $model->label = $row[1];
                        $model->volume = $row[2];
                        $model->satuan = $row[3];
                        $model->harga_satuan = $row[4];
                        $model->harga_jumlah = $row[2]*$row[4];
                        $model->tahun = $this->tahun;
                        $model->created_at = date('Y-m-d h:i:s');
                        $model->created_by = Auth::id();
                        $model->updated_at = date('Y-m-d h:i:s');
                        $model->updated_by = Auth::id();
                        $model->save();
                    }
                    else if($len_col0>=1 && $len_col0<=3){ //komponen & subkomponen
                        if($len_col0==1 && !is_numeric($row[0])){ // sub komponen
                            $model = PokSubKomponen::where('kode','=', $row[0])
                                        ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                                        ->where('id_ro', '=', $last_id_ro)
                                        ->where('id_komponen', '=', $last_id_komponen)
                                        ->where('tahun', '=', $this->tahun)
                                        ->first();

                            if($model==null){
                                $model = new PokSubKomponen;
                                $model->kode = $row[0];
                                $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                                $model->tahun = $this->tahun;
                                $model->id_komponen = $last_id_komponen;
                                $model->created_at = date('Y-m-d h:i:s');
                                $model->created_by = Auth::id();
                            }
                            
                            $model->id_program = $last_id_program;
                            $model->id_aktivitas = $last_id_aktivitas;
                            $model->id_kro = $last_id_kro;
                            $model->id_ro = $last_id_ro;
                            $model->label = $row[1];
                            $model->updated_at = date('Y-m-d h:i:s');
                            $model->updated_by = Auth::id();
                            if($model->save()) $last_id_sub_komponen = $model->id;
                        }
                        else{ //komponen
                            $model = PokKomponen::where('kode','=', $row[0])
                                        ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                                        ->where('id_ro', '=', $last_id_ro)
                                        ->where('tahun', '=', $this->tahun)
                                        ->first();
                            
                            if($model==null){
                                $model = new PokKomponen;
                                $model->kode = $row[0];
                                $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                                $model->id_ro = $last_id_ro;
                                $model->tahun = $this->tahun;
                                $model->created_at = date('Y-m-d h:i:s');
                                $model->created_by = Auth::id();
                            }
                            
                            $model->id_program = $last_id_program;
                            $model->id_aktivitas = $last_id_aktivitas;
                            $model->id_kro = $last_id_kro;
                            $model->label = $row[1];
                            $model->updated_at = date('Y-m-d h:i:s');
                            $model->updated_by = Auth::id();
                            if($model->save()) $last_id_komponen = $model->id;
                        }
                    }
                    else if($len_col0==4){ //aktivitas
                        $model = PokAktivitas::where('kode','=', $row[0])
                                    ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                                    ->where('tahun', '=', $this->tahun)
                                    ->first();
                        if($model==null){
                            $model = new PokAktivitas;
                            $model->kode = $row[0];
                            $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                            $model->created_at = date('Y-m-d h:i:s');
                            $model->created_by = Auth::id();
                        }
                        
                        $model->id_program = $last_id_program;
                        $model->label = $row[1];
                        $model->tahun = $this->tahun;
                        $model->updated_at = date('Y-m-d h:i:s');
                        $model->updated_by = Auth::id();
                        if($model->save()) $last_id_aktivitas = $model->id;
                    }
                    else if($len_col0==6){ //mata anggaran
                        // $model = PokMataAnggaran::where('kode','=', $row[0])
                        //             ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                        //             ->first();

                        // if($model==null){
                            $model = new PokMataAnggaran;
                            $model->kode = $row[0];
                            $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                            $model->created_at = date('Y-m-d h:i:s');
                            $model->created_by = Auth::id();
                        // }
                        
                        $model->id_program = $last_id_program;
                        $model->id_aktivitas = $last_id_aktivitas;
                        $model->id_kro = $last_id_kro;
                        $model->id_ro = $last_id_ro;
                        $model->id_komponen = $last_id_komponen;
                        $model->id_sub_komponen = $last_id_sub_komponen;
                        $model->label = $row[1];
                        $model->tahun = $this->tahun;
                        $model->updated_at = date('Y-m-d h:i:s');
                        $model->updated_by = Auth::id();
                        if($model->save()) $last_id_mata_anggaran = $model->id;
                    }
                    else if($len_col0==8){ //kro
                        $model = PokKro::where('kode','=', $row[0])
                                    ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                                    ->where('tahun', '=', $this->tahun)
                                    ->first();
                        if($model==null){
                            $model = new PokKro;
                            $model->kode = $row[0];
                            $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                            $model->created_at = date('Y-m-d h:i:s');
                            $model->created_by = Auth::id();
                        }
                        
                        $model->id_program = $last_id_program;
                        $model->id_aktivitas = $last_id_aktivitas;
                        $model->label = $row[1];
                        $model->volume = $row[2];
                        $model->satuan = $row[3];
                        $model->tahun = $this->tahun;
                        $model->updated_at = date('Y-m-d h:i:s');
                        $model->updated_by = Auth::id();
                        if($model->save()) $last_id_kro = $model->id;
                    }
                    else if($len_col0==9){ // program
                        $model = PokProgram::where('kode','=', $row[0])
                                    ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                                    ->where('tahun', '=', $this->tahun)
                                    ->first();
                        if($model==null){
                            $model = new PokProgram;
                            $model->kode = $row[0];
                            $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                            $model->created_at = date('Y-m-d h:i:s');
                            $model->created_by = Auth::id();
                        }
                        
                        $model->label = $row[1];
                        $model->tahun = $this->tahun;
                        $model->updated_at = date('Y-m-d h:i:s');
                        $model->updated_by = Auth::id();
                        if($model->save()) $last_id_program = $model->id;
                    }
                    else if($len_col0==12){ //ro
                        $model = PokRo::where('kode','=', $row[0])
                                    ->where('unit_kerja', '=', Auth::user()->kdprop . Auth::user()->kdkab)
                                    ->where('tahun', '=', $this->tahun)
                                    ->first();
                        if($model==null){
                            $model = new PokRo;
                            $model->kode = $row[0];
                            $model->unit_kerja = Auth::user()->kdprop . Auth::user()->kdkab;
                            $model->created_at = date('Y-m-d h:i:s');
                            $model->created_by = Auth::id();
                        }
                        
                        $model->id_program = $last_id_program;
                        $model->id_aktivitas = $last_id_aktivitas;
                        $model->id_kro = $last_id_kro;
                        $model->label = $row[1];
                        $model->volume = $row[2];
                        $model->satuan = $row[3];
                        $model->tahun = $this->tahun;
                        $model->updated_at = date('Y-m-d h:i:s');
                        $model->updated_by = Auth::id();
                        if($model->save()) $last_id_ro = $model->id;
                    }
                }
            }
        }
    }
}