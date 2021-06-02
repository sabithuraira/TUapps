<?php 
    function toAlpha($data){
        $alphabet =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $alpha_flip = array_flip($alphabet);
        if($data <= 25){
        return $alphabet[$data];
        }
        elseif($data > 25){
        $dividend = ($data + 1);
        $alpha = '';
        $modulo;
        while ($dividend > 0){
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
        } 
        return $alpha;
        }
    }
    function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
?>

<div id="load" class="table-responsive">
    {{-- @if (count($datas)==0)
    Tidak ditemukan data
    @else --}}
    <h6>Jabatan :</h6>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach ( $datas as $jabatan )
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="{{ $jabatan->id_jabatan }}-tab" data-toggle="tab" href="#{{$jabatan->id_jabatan}}"
                data-id="{{ $jabatan->id_jabatan }}" role="tab" v-on:click="tabJabatan"
                aria-controls="{{ $jabatan->id_jabatan }}">{{ $jabatan->jabatan }}</a>
        </li>
        @endforeach
        <li>
            <a href="#" role="button" style="padding: .5rem; display:block" data-toggle="modal"
                data-target="#modal_tambah_jabatan">
                <i class="icon-plus text-warning "></i>
            </a>
        </li>
        <li>
            <a href="#" role="button" style="padding: .5rem; display:block" data-toggle="modal"
                data-target="#modal_hapus_jabatan">
                <i class="icon-trash text-danger "></i>
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        @foreach ( $datas as $key1=> $jabatan)
        <div class="tab-pane fade" id="{{$jabatan->id_jabatan}}" role="tabpanel"
            aria-labelledby="{{$jabatan->id_jabatan}}-tab">
            <div class="table-responsive">
                <table class="table-bordered" style="width: 100%">
                    <thead class="text-center">
                        <tr>
                            <th colspan="4">Butir Kegiatan</th>
                            <th>Satuan Hasil (Tiap)</th>
                            <th>Angka Kredit</th>
                            <th>Batasan Penilaian</th>
                            <th>Pelaksana</th>
                            <th>Bukti Fisik</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th colspan="4">(1)</th>
                            <th>(2)</th>
                            <th>(3)</th>
                            <th>(4)</th>
                            <th>(5)</th>
                            <th>(6)</th>
                            <th>(7)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ( $jabatan->judul as $key2=> $judul)
                        <tr>
                            <td> <strong>&nbsp;{{ numberToRomanRepresentation($key2+1)}}.</strong></td>
                            <td colspan="8"> <strong>{{ $judul->judul }} </strong> </td>
                            <td class="text-center" style=" white-space: nowrap;">
                                <a href="#" role="button" class="editjudul" data-toggle="modal"
                                    data-target="#modal_edit_judul" data-idjudul="{{ $judul->id_judul }}"
                                    data-idjabatan="{{ $judul->id_jabatan }}" data-judul="{{ $judul->judul }}">
                                    &nbsp; <i class="icon-pencil"></i>
                                </a>
                                <a href="#" role="button" class="hapus" data-toggle="modal" data-target="#modal_hapus"
                                    data-idjudul="{{ $judul->id_judul }}" data-idjabatan="{{ $judul->id_jabatan }}">
                                    &nbsp; <i class="icon-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>

                        @foreach ( $judul->subjudul as $key3=> $subjudul)
                        <tr>
                            <td></td>
                            <td> <strong>&nbsp;{{ toAlpha($key3)}}.</strong></td>
                            <td colspan="7"> <strong>{{ $subjudul->subjudul }} </strong></td>
                            <td class="text-center">
                                <a href="#" role="button" class="editsubjudul" data-toggle="modal"
                                    data-idjabatan="{{ $subjudul->id_jabatan }}"
                                    data-idjudul="{{ $subjudul->id_judul }}"
                                    data-idsubjudul="{{ $subjudul->id_subjudul }}"
                                    data-subjudul="{{ $subjudul->subjudul }}" data-target="#modal_edit_subjudul">
                                    &nbsp;<i class="icon-pencil"></i>
                                </a>
                                <a href="#" role="button" class="hapus" data-toggle="modal" data-target="#modal_hapus"
                                    data-idjabatan="{{ $subjudul->id_jabatan }}"
                                    data-idjudul="{{ $subjudul->id_judul }}"
                                    data-idsubjudul="{{ $subjudul->id_subjudul }}">
                                    &nbsp; <i class="icon-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @foreach ( $subjudul->kegiatan as $key4=> $kegiatan)
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="2">&nbsp;{{ $key4+1 }}. {{ $kegiatan->kegiatan }}</td>
                            <td class="text-center">{{ $kegiatan->satuan_hasil }} </td>
                            <td class="text-center">{{ $kegiatan->angka_kredit }} </td>
                            <td class="text-center">{{ $kegiatan->batasan_penilaian }} </td>
                            <td class="text-center">{{ $kegiatan->pelaksana }}</td>
                            <td class="text-center">{{ $kegiatan->bukti_fisik }}</td>
                            <td class="text-center">
                                <a href="#" role="button" class="editkegiatan" data-toggle="modal"
                                    data-idjabatan="{{$kegiatan->id_jabatan}}" data-idjudul="{{$kegiatan->id_judul}}"
                                    data-idsubjudul="{{$kegiatan->id_subjudul}}"
                                    data-idkegiatan="{{$kegiatan->id_kegiatan}}" data-kegiatan="{{$kegiatan->kegiatan}}"
                                    data-satuan_hasil="{{$kegiatan->satuan_hasil}}"
                                    data-angka_kredit="{{$kegiatan->angka_kredit}}"
                                    data-batasan_penilaian="{{$kegiatan->batasan_penilaian}}"
                                    data-pelaksana="{{$kegiatan->pelaksana}}"
                                    data-bukti_fisik="{{$kegiatan->bukti_fisik}}" data-status=""
                                    data-target="#modal_edit_kegiatan" data-toggle="modal"
                                    {{-- v-on:click="editKegiatan" --}}>
                                    &nbsp;<i class="icon-pencil"></i>
                                </a>
                                <a href="#" role="button" class="hapus" data-toggle="modal" data-target="#modal_hapus"
                                    data-idjabatan="{{$kegiatan->id_jabatan}}" data-idjudul="{{$kegiatan->id_judul}}"
                                    data-idsubjudul="{{$kegiatan->id_subjudul}}"
                                    data-idkegiatan="{{$kegiatan->id_kegiatan}}">
                                    &nbsp; <i class="icon-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>

                        @foreach ( $kegiatan->subkegiatan as $key5=> $subkegiatan)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <li> {{ $subkegiatan->subkegiatan }}</li>
                            </td>
                            <td class="text-center">{{ $subkegiatan->satuan_hasil }} </td>
                            <td class="text-center">{{ $subkegiatan->angka_kredit }} </td>
                            <td class="text-center">{{ $subkegiatan->batasan_penilaian }} </td>
                            <td class="text-center">{{ $subkegiatan->pelaksana }}</td>
                            <td class="text-center">{{ $subkegiatan->bukti_fisik }}</td>
                            <td class="text-center">
                                <a href="#" role="button" class="editsubkegiatan" data-toggle="modal"
                                    data-idjabatan="{{$subkegiatan->id_jabatan}}"
                                    data-idjudul="{{$subkegiatan->id_judul}}"
                                    data-idsubjudul="{{$subkegiatan->id_subjudul}}"
                                    data-idkegiatan="{{$subkegiatan->id_kegiatan}}"
                                    data-idsubkegiatan="{{$subkegiatan->id_subkegiatan}}"
                                    data-subkegiatan="{{$subkegiatan->subkegiatan}}"
                                    data-satuan_hasil="{{$subkegiatan->satuan_hasil}}"
                                    data-angka_kredit="{{$subkegiatan->angka_kredit}}"
                                    data-batasan_penilaian="{{$subkegiatan->batasan_penilaian}}"
                                    data-pelaksana="{{$subkegiatan->pelaksana}}"
                                    data-bukti_fisik="{{$subkegiatan->bukti_fisik}}" data-status=""
                                    data-target="#modal_edit_subkegiatan" data-toggle="modal"
                                    {{-- v-on:click="editKegiatan" --}}>
                                    &nbsp;<i class="icon-pencil"></i>
                                </a>
                                <a href="#" role="button" class="hapus" data-toggle="modal" data-target="#modal_hapus"
                                    data-idjabatan="{{$subkegiatan->id_jabatan}}"
                                    data-idjudul="{{$subkegiatan->id_judul}}"
                                    data-idsubjudul="{{$subkegiatan->id_subjudul}}"
                                    data-idkegiatan="{{$subkegiatan->id_kegiatan}}"
                                    data-idsubkegiatan="{{$subkegiatan->id_subkegiatan}}">
                                    &nbsp; <i class="icon-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                        @endforeach
                        @endforeach
                        <tr class="text-center">
                            <td colspan="10" style="padding:0.5rem">
                                <button type="button" class="btn  btn-outline-warning"
                                    style="display:block; width: -webkit-fill-available;" data-toggle="modal" data-id=""
                                    data-status="" data-target="#modal_tambah_row" v-on:click="setJabatan"><i
                                        class="icon-plus"></i>
                                    <p style="display: inline" class="small">Tambah</p>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    {{-- @endif --}}
</div>

<div class="modal" id="modal_hapus_jabatan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/hapus_jabatan')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="jabatan">Pilih Jabatan Fungsional untuk Dihapus</label>
                        <select class='form-control' name="id_jabatan" id="id_jabatan_hapus">
                            @foreach ( $datas as $jabatan)
                            <option value={{$jabatan->id_jabatan}}>
                                {{$jabatan->id_jabatan}} - {{$jabatan->jabatan}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_tambah_jabatan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/tambah_jabatan')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="jabatan">Masukan Jabatan Fungsional Baru</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-simple" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_tambah_row" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">Tambah Baris</div>
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/tambah_row')}}" method="POST">
                    @csrf
                    <input type="text" name="idjabatan" id="id_jabatan" hidden>
                    <div class="row clearfix">
                        <div class="col-7 ">
                            <div class="mb-2">
                                <label class="col d-flex " for="judul">Judul</label>
                                <div class="col d-flex ">
                                    <select
                                        class="form-control col-9 {{($errors->first('judul') ? ' parsley-error' : '')}}"
                                        id="judulselect" @change="setJudul($event)">
                                    </select>
                                    <input type="text" name="idjudul" id="id_judul" hidden>
                                    <a class="col-3 " href="#" role="button" v-on:click="addjudulbaru">
                                        <i class="icon-plus">Tambah</i>
                                    </a>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="col d-flex" for="subjudul">Sub judul</label>
                                <div class="col d-flex">
                                    <select
                                        class="form-control col-9 {{($errors->first('subjudul') ? ' parsley-error' : '')}}"
                                        id="subjudulselect" @change="setSubjudul($event)">
                                    </select>
                                    <input type="text" name="idsubjudul" id="id_subjudul" hidden>
                                    <a class="col-3" href="#" role="button" v-on:click="addsubjudulbaru">
                                        <i class="icon-plus">Tambah</i>
                                    </a>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="col" for="kegiatan">Kegiatan </label>
                                <div class="col d-flex">
                                    <select
                                        class="form-control col-9 {{($errors->first('subjudul') ? ' parsley-error' : '')}}"
                                        id="kegiatanselect" @change="setKegiatan($event)">
                                    </select>
                                    <input type="text" name="idkegiatan" id="id_kegiatan" hidden>
                                    <a class="col-3" href="#" role="button" v-on:click="addkegiatanbaru">
                                        <i class="icon-plus">Tambah</i>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="col" for="subkegiatan">SubKegiatan Baru</label>
                                <div class="col d-flex">
                                    <input class="form-control col-9 form-control-sm" type="text" name="subkegiatanbaru"
                                        id="subkegiatanbaru" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-5 ">
                            <div class="mb-2" id="judulbarudiv" style="visibility:hidden">
                                <label class="col" for="judulbaru">Judul Baru</label>
                                <div class="col row">
                                    <input class="col-9 form-control form-control-sm" type="text" name="judulbaru"
                                        id="judulbaru" value="" disabled>
                                    <a class="col-3" href="#" role="button" v-on:click="hapusjudulbaru">
                                        &nbsp;<i class="icon-trash text-danger"> </i>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-2" id="subjudulbarudiv" style="visibility:hidden">
                                <label class="col " for="subjudulbaru">Sub Judul Baru</label>
                                <div class="col row ">
                                    <input class="col-9 form-control form-control-sm" type="text" name="subjudulbaru"
                                        id="subjudulbaru" value="" disabled>
                                    <a class="col-3" href="#" role="button" v-on:click="hapussubjudulbaru">
                                        &nbsp;<i class="icon-trash text-danger"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-2" id="kegiatanbarudiv" style="visibility:hidden">
                                <label class="col " for="kegiatanbaru">Kegiatan Baru</label>
                                <div class="col row ">
                                    <input class="col-9 form-control form-control-sm" type="text" name="kegiatanbaru"
                                        id="kegiatanbaru" value="" disabled>
                                    <a class="col-3" href="#" role="button" v-on:click="hapuskegiatanbaru">
                                        &nbsp;<i class="icon-trash text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="m-1 btn btn-simple float-right" data-dismiss="modal">Batal</button>
                    <button type="submit" class="m-1 btn btn-primary float-right">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_edit_judul" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/edit_judul')}}" method="POST">
                    @csrf
                    <div class="row clearfix">
                        <div class="col">
                            <input type="text" name="id_jabatan" id="modal_edit_judul_id_jabatan" hidden>
                            <input type="text" name="id_judul" id="modal_edit_judul_id_judul" hidden>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" name="judul" id="modal_edit_judul_judul"
                                    value="">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="m-1 btn btn-simple float-right" data-dismiss="modal">Batal</button>
                    <button type="submit" class="m-1 btn btn-primary float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_edit_subjudul" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/edit_subjudul')}}" method="POST">
                    @csrf
                    <div class="row clearfix">
                        <div class="col">
                            <input type="text" name="id_jabatan" id="modal_edit_subjudul_id_jabatan" hidden>
                            <input type="text" name="id_judul" id="modal_edit_subjudul_id_judul" hidden>
                            <input type="text" name="id_subjudul" id="modal_edit_subjudul_id_subjudul" hidden>
                            <div class="form-group">
                                <label for="subjudul">Subjudul</label>
                                <input type="text" class="form-control" name="subjudul"
                                    id="modal_edit_subjudul_subjudul" value="">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="m-1 btn btn-simple float-right" data-dismiss="modal">Batal</button>
                    <button type="submit" class="m-1 btn btn-primary float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_edit_kegiatan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/edit_kegiatan')}}" method="POST">
                    @csrf
                    <div class="row clearfix">
                        <div class="col">
                            <div class="col">
                                <input type="text" name="id_jabatan" id="modal_edit_kegiatan_id_jabatan" hidden>
                                <input type="text" name="id_judul" id="modal_edit_kegiatan_id_judul" hidden>
                                <input type="text" name="id_subjudul" id="modal_edit_kegiatan_id_subjudul" hidden>
                                <input type="text" name="id_kegiatan" id="modal_edit_kegiatan_id_kegiatan" hidden>
                                <div class="form-group">
                                    <label for="kegiatan">Kegiatan</label>
                                    <input type="text" class="form-control" name="kegiatan"
                                        id="modal_edit_kegiatan_kegiatan" value="">
                                </div>
                            </div>
                            <div class="row col">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="satuan_hasil">Satuan Hasil</label>
                                        <input type="text" class="form-control" name="satuan_hasil"
                                            id="modal_edit_kegiatan_satuan_hasil" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="batasan_penilaian">Batasan Penilaian</label>
                                        <input type="text" class="form-control" name="batasan_penilaian"
                                            id="modal_edit_kegiatan_batasan_penilaian" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="bukti_fisik">Bukti Fisik</label>
                                        <input type="text" class="form-control" name="bukti_fisik"
                                            id="modal_edit_kegiatan_bukti_fisik" value="">
                                    </div>
                                    {{-- <div class="col-6">
                                    <button type="button" class="btn btn-outline-warning" data-toggle="modal"
                                        v-on:click="addSubkegiatan" data-target="#modal_tambah_subkegiatan"> Tambah
                                        Subkegiatan
                                    </button>
                                </div> --}}
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="angka_kredit">Angka Kredit</label>
                                        <input type="text" class="form-control" name="angka_kredit"
                                            id="modal_edit_kegiatan_angka_kredit" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="pelaksana">Pelaksana</label>
                                        <input type="text" class="form-control" name="pelaksana"
                                            id="modal_edit_kegiatan_pelaksana" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-simple" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_edit_subkegiatan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/edit_subkegiatan')}}" method="POST">
                    @csrf
                    <div class="row clearfix">
                        <div class="col">
                            <div class="col">
                                <input type="text" name="id_jabatan" id="modal_edit_subkegiatan_id_jabatan" hidden>
                                <input type="text" name="id_judul" id="modal_edit_subkegiatan_id_judul" hidden>
                                <input type="text" name="id_subjudul" id="modal_edit_subkegiatan_id_subjudul" hidden>
                                <input type="text" name="id_kegiatan" id="modal_edit_subkegiatan_id_kegiatan" hidden>
                                <input type="text" name="id_subkegiatan" id="modal_edit_subkegiatan_id_subkegiatan"
                                    hidden>
                                <div class="form-group">
                                    <label for="subkegiatan">Sub Kegiatan</label>
                                    <input type="text" class="form-control" name="subkegiatan"
                                        id="modal_edit_subkegiatan_subkegiatan" value="">
                                </div>
                            </div>
                            <div class="row col">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="satuan_hasil">Satuan Hasil</label>
                                        <input type="text" class="form-control" name="satuan_hasil"
                                            id="modal_edit_subkegiatan_satuan_hasil" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="batasan_penilaian">Batasan Penilaian</label>
                                        <input type="text" class="form-control" name="batasan_penilaian"
                                            id="modal_edit_subkegiatan_batasan_penilaian" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="bukti_fisik">Bukti Fisik</label>
                                        <input type="text" class="form-control" name="bukti_fisik"
                                            id="modal_edit_subkegiatan_bukti_fisik" value="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="angka_kredit">Angka Kredit</label>
                                        <input type="text" class="form-control" name="angka_kredit"
                                            id="modal_edit_subkegiatan_angka_kredit" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="pelaksana">Pelaksana</label>
                                        <input type="text" class="form-control" name="pelaksana"
                                            id="modal_edit_subkegiatan_pelaksana" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-simple" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_hapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{url('jabatan_fungsional/hapus')}}" method="POST">
                    @csrf
                    <div>Apa Anda Yakin Ingin Menghapus?</div>
                    <div class="form-group">
                        <input type="text" name="id_jabatan" id="modal_hapus_id_jabatan" hidden>
                        <input type="text" name="id_judul" id="modal_hapus_id_judul" hidden>
                        <input type="text" name="id_subjudul" id="modal_hapus_id_subjudul" hidden>
                        <input type="text" name="id_kegiatan" id="modal_hapus_id_kegiatan" hidden>
                        <input type="text" name="id_subkegiatan" id="modal_hapus_id_subkegiatan" hidden>
                        <button type="button" class="m-1 btn btn-simple float-right" data-dismiss="modal">batal</button>
                        <button type="submit" class="m-1 btn btn-danger float-right">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
    var datass = {!! json_encode($datas) !!}
    datas = datass[0]
    var vm = new Vue({  
            el: "#app_vue",
            data:  {
                pathname : window.location.pathname,
            },
            methods: {
                tabJabatan:function(event){
                    var self = this;
                    var selected_index = event.currentTarget.selectedIndex;
                    $("#myTabContent div").removeClass('active')
                    $("#myTabContent div").removeClass( 'show')
                    $("#"+$(this).attr('data-id')).addClass("active", "show");
                    $("#"+$(this).attr('data-id')).addClass( "show");
                    datas = datass[event.currentTarget.getAttribute('data-id')-1]
                },
                setJabatan:function(event){
                    option="<option value=>Pilih Judul</option> "
                    datas.judul.forEach(element => {
                        option += "<option value="+ element.id_judul +">"+ element.judul+"</option> "
                    });
                    $("#judulselect").html(
                        option
                    )
                    $("#subkegiatan").val(null)
                    $("#id_jabatan").val($('#myTabContent .active').attr('id'))
                    // console.log($('#myTabContent .active').attr('id'))
                    
                },
                setJudul:function(event){
                    var self = this;
                    var selected_index = event.currentTarget.selectedIndex-1;
                    // console.log(selected_index)
                    option= "<option value=>Pilih Sub Judul</option> "
                    if(datas.judul[selected_index]){
                        datas.judul[selected_index].subjudul.forEach(element => {
                            option += "<option value="+ element.id_subjudul +">"+ element.subjudul+"</option>"
                        });
                    }
                    $("#subjudulselect").html(
                        option
                    )
                    $("#kegiatanselect").html(
                        "<option value= >Pilih Kegiatan</option>"
                    )
                    $("#id_judul").val($("#judulselect").val())
                },
                setSubjudul:function(){
                    var self = this;
                    var selected_index = event.currentTarget.selectedIndex-1;
                    var indexJudul = $('#judulselect').prop('selectedIndex')-1
                    // console.log(indexJudul)
                    option= "<option value="+">Pilih Kegiatan</option>"
                    
                    if(datas.judul[indexJudul].subjudul[selected_index]){
                        datas.judul[indexJudul].subjudul[selected_index].kegiatan.forEach(element => {
                            option += "<option value="+ element.id_kegiatan +">"+ element.kegiatan+"</option>"
                        });
                    }
                    $("#kegiatanselect").html(
                        option
                    )
                    $("#id_subjudul").val($("#subjudulselect").val())
                    
                },
                setKegiatan:function(){
                    var self = this;
                    var selected_index = event.currentTarget.selectedIndex-1;
                    var indexJudul = $('#judulselect').prop('selectedIndex')-1
                    var indexSubjudul = $('#subjudul').prop('selectedIndex')-1
                    // console.log(indexJudul)
                    option= "<option value="+">Pilih Kegiatan</option>"
                    if(datas.judul[indexJudul].subjudul[selected_index]){
                        datas.judul[indexJudul].subjudul[selected_index].kegiatan.forEach(element => {
                            option += "<option value="+ element.id_kegiatan +">"+ element.kegiatan+"</option>"
                        });
                    }
                    $("#id_kegiatan").val($("#kegiatanselect").val())
                    
                },
                addjudulbaru:function(){
                    var self = this;
                    $('#judulbarudiv').css('visibility','visible');
                    $("#judulbaru").removeAttr('disabled');
                    $("#judulselect").attr('disabled', 'disabled');
                    $("#judulselect").val('0'+(datas.judul.length+1))
                    // $("#id_judul").selectedIndex = -1
                    $("#id_judul").val('')
                    this.addsubjudulbaru();
                },
                addsubjudulbaru:function(){
                    var self = this;
                    $('#subjudulbarudiv').css('visibility','visible');
                    $("#subjudulbaru").removeAttr('disabled');
                    $("#subjudulselect").attr({'disabled': 'disabled'});
                    $("#subjudulselect").val('0'+(datas.judul.length+1))
                    $("#id_subjudul").val('')
                    this.addkegiatanbaru();
                },
                addkegiatanbaru:function(){
                    $('#kegiatanbarudiv').css('visibility','visible');
                    $("#kegiatanbaru").removeAttr('disabled');
                    $("#kegiatanselect").attr({'disabled': 'disabled'});
                    $("#kegiatanselect").val('0'+(datas.judul.length+1))
                    $("#id_kegiatan").val('')
                },
                hapusjudulbaru:function(){
                    $('#judulbarudiv').css('visibility','hidden');
                    $("#judulselect").removeAttr('disabled');
                    $("#judulbaru").attr({'disabled': 'disabled'});
                },
                hapussubjudulbaru:function(){
                    $('#subjudulbarudiv').css('visibility','hidden');
                    $("#subjudulselect").removeAttr('disabled');
                    $("#subjudulbaru").attr({'disabled': 'disabled'});
                },
                hapuskegiatanbaru:function(){
                    $('#kegiatanbarudiv').css('visibility','hidden');
                    $("#kegiatanselect").removeAttr('disabled');
                    $("#kegiatanbaru").attr({'disabled': 'disabled'});
                },
            }
        });
    $(function () {
        $('#myTab li:first-child a').tab('show')
        $('.editjudul').click(function(e) {
            $('#modal_edit_judul_id_judul').val($(this).data('idjudul'))
            $('#modal_edit_judul_judul').val($(this).data('judul'))
            $('#modal_edit_judul_id_jabatan').val($(this).data('idjabatan'))
        });
        $('.editsubjudul').click(function(e) {
            $('#modal_edit_subjudul_id_judul').val($(this).data('idjudul'))
            $('#modal_edit_subjudul_id_jabatan').val($(this).data('idjabatan'))
            $('#modal_edit_subjudul_id_subjudul').val($(this).data('idsubjudul'))
            $('#modal_edit_subjudul_subjudul').val($(this).data('subjudul'))
        });
        $('.editkegiatan').click(function(e) {
            $('#modal_edit_kegiatan_id_judul').val($(this).data('idjudul'))
            $('#modal_edit_kegiatan_id_jabatan').val($(this).data('idjabatan'))
            $('#modal_edit_kegiatan_id_subjudul').val($(this).data('idsubjudul'))
            $('#modal_edit_kegiatan_id_kegiatan').val($(this).data('idkegiatan'))
            $('#modal_edit_kegiatan_kegiatan').val($(this).data('kegiatan'))
            $('#modal_edit_kegiatan_satuan_hasil').val($(this).data('satuan_hasil'))
            $('#modal_edit_kegiatan_angka_kredit').val($(this).data('angka_kredit'))
            $('#modal_edit_kegiatan_batasan_penilaian').val($(this).data('batasan_penilaian'))
            $('#modal_edit_kegiatan_pelaksana').val($(this).data('pelaksana'))
            $('#modal_edit_kegiatan_bukti_fisik').val($(this).data('bukti_fisik'))
        });
        $('.editsubkegiatan').click(function(e) {
            $('#modal_edit_subkegiatan_id_judul').val($(this).data('idjudul'))
            $('#modal_edit_subkegiatan_id_jabatan').val($(this).data('idjabatan'))
            $('#modal_edit_subkegiatan_id_subjudul').val($(this).data('idsubjudul'))
            $('#modal_edit_subkegiatan_id_kegiatan').val($(this).data('idkegiatan'))
            $('#modal_edit_subkegiatan_id_subkegiatan').val($(this).data('idsubkegiatan'))
            $('#modal_edit_subkegiatan_subkegiatan').val($(this).data('subkegiatan'))
            $('#modal_edit_subkegiatan_satuan_hasil').val($(this).data('satuan_hasil'))
            $('#modal_edit_subkegiatan_angka_kredit').val($(this).data('angka_kredit'))
            $('#modal_edit_subkegiatan_batasan_penilaian').val($(this).data('batasan_penilaian'))
            $('#modal_edit_subkegiatan_pelaksana').val($(this).data('pelaksana'))
            $('#modal_edit_subkegiatan_bukti_fisik').val($(this).data('bukti_fisik'))
        });
        $('.hapus').click(function(e){
            $('#modal_hapus_id_judul').val($(this).data('idjudul'))
            $('#modal_hapus_id_jabatan').val($(this).data('idjabatan'))
            $('#modal_hapus_id_subjudul').val($(this).data('idsubjudul'))
            $('#modal_hapus_id_kegiatan').val($(this).data('idkegiatan'))
            $('#modal_hapus_id_subkegiatan').val($(this).data('idsubkegiatan'))
        })
    })
</script>
@endsection
@section('css')
<style>
    .tab-content {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        padding: 10px;
    }
</style>
@endsection