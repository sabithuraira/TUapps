@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">IKI Pegawai</li>
    </ul>
@endsection

@section('content')
    <div id="app_vue">
        <div class="container">
            <br />
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div><br />
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>
                </div><br />
            @endif

            <div class="card">
                <div class="body">
                    @if ($auth->hasanyrole('kepegawaian|superadmin'))
                        <a href="#modal_tambah_iki" class="btn btn-info" data-toggle="modal"
                            data-target="#modal_tambah_iki">
                            Tambah
                        </a>
                    @endif
                    <br /><br />
                    <form action="{{ url('iki_pegawai') }}" method="get">
                        <div class="row px-2">
                            <div class="col-4">
                                <label for="" class="label">Pegawai</label>
                                <select name="user" id="user_filter" class="form-control show-tick ms search-select"
                                    required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($user_list as $usr)
                                        <option value="{{ $usr->id }}"
                                            @if ($request->user == $usr->id) selected @endif>
                                            {{ $usr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Tahun</label>
                                <select name="tahun" id="tahun_filter" class="form-control show-tick ms search-select">
                                    <option value="">Semua</option>
                                    <option value="2022" @if ($request->tahun == '2022') selected @endif>2022</option>
                                    <option value="2023" @if ($request->tahun == '2023') selected @endif>2023</option>
                                    <option value="2024" @if ($request->tahun == '2024') selected @endif>2024</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Bulan</label>
                                <select name="bulan" id="bulan_filter" class="form-control show-tick ms search-select">
                                    <option value="" selected>Semua</option>
                                    @foreach ($model->namaBulan as $g => $bln)
                                        <option value="{{ ++$g }}"
                                            @if ($request->bulan == $g) selected @endif>{{ $bln }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label text-white">a</label>
                                <br>
                                <button class="btn btn-info" type="submit">Cari <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row px-2">
                        <div class="col">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>IK</th>
                                        <th>Satuan</th>
                                        <th>Target</th>
                                        <th>No. Bukti</th>
                                        <th>Jenis Bukti</th>
                                        <th>Deadline</th>
                                        <th>Link Bukti</th>
                                        <th>Aksi Bukti</th>
                                        <th>Aksi IK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ $datas }} --}}
                                    @foreach ($datas as $i => $dt)
                                        @if (sizeof($dt->ikibukti) < 1)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                    {{ $dt->ik }} </td>
                                                <td>{{ $dt->satuan }}</td>
                                                <td>{{ $dt->target }}</td>
                                                @if ($dt->bukti_bawahan)
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif

                                                <td>
                                                    <a class="btn btn-info" href="#modal_tambah_bukti" data-toggle="modal"
                                                        data-target="#modal_tambah_bukti" data-id_iki="{{ $dt->id }}"
                                                        @click="btn_tambah_bukti($event)">
                                                        <i class="fa fa-plus"></i> Bukti
                                                    </a>
                                                    <a class="btn btn-warning" href="#modal_edit_iki" data-toggle="modal"
                                                        data-target="#modal_edit_iki" data-id_iki="{{ $dt->id }}"
                                                        data-ik="{{ $dt->ik }}" data-satuan = "{{ $dt->satuan }}"
                                                        data-target_iki="{{ $dt->target }}"
                                                        data-bulan="{{ $dt->bulan }}" data-tahun="{{ $dt->tahun }}"
                                                        data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                        data-referensi_jenis="{{ $dt->referensi_jenis }}"
                                                        @click="btn_edit_iki($event)">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a class="btn btn-danger" href="#modal_hapus_iki" data-toggle="modal"
                                                        data-target="#modal_hapus_iki" data-id_iki="{{ $dt->id }}"
                                                        data-ik="{{ $dt->ik }}" @click="btn_hapus_iki($event)">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @elseif (sizeof($dt->ikibukti) >= 1)
                                            <tr>
                                                <td rowspan="{{ count($dt->ikibukti) }}">{{ ++$i }}</td>
                                                <td style="max-width: 200px; word-wrap: break-word; white-space:normal"
                                                    rowspan="{{ count($dt->ikibukti) }}">{{ $dt->ik }} </td>
                                                <td rowspan="{{ count($dt->ikibukti) }}">{{ $dt->satuan }}</td>
                                                <td rowspan="{{ count($dt->ikibukti) }}">{{ $dt->target }}</td>
                                                <td>1</td>
                                                <td>{{ $dt->ikibukti[0]->jenis_bukti_dukung }}</td>
                                                <td>{{ $model->namaBulan[$dt->ikibukti[0]->deadline - 1] }}</td>
                                                <td style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                    <a href="{{ $dt->ikibukti[0]->link_bukti_dukung }}"
                                                        target="_blank">{{ $dt->ikibukti[0]->link_bukti_dukung }}</a>
                                                </td>
                                                <td>
                                                    @if ($request->user == $dt->ikibukti[0]->id_user)
                                                        <a class="btn btn-warning" href="#modal_edit_bukti"
                                                            data-toggle="modal" data-target="#modal_edit_bukti"
                                                            data-id_bukti="{{ $dt->ikibukti[0]->id }}"
                                                            data-jenis_bukti_dukung="{{ $dt->ikibukti[0]->jenis_bukti_dukung }}"
                                                            data-deadline="{{ $dt->ikibukti[0]->deadline }}"
                                                            data-link_bukti_dukung="{{ $dt->ikibukti[0]->link_bukti_dukung }}"
                                                            @click="btn_edit_bukti($event)">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a class="btn btn-danger" href="#modal_hapus_bukti"
                                                            data-toggle="modal" data-target="#modal_hapus_bukti"
                                                            data-id_bukti="{{ $dt->ikibukti[0]->id }}"
                                                            data-ik="{{ $dt->ik }}"
                                                            data-jenis_bukti="{{ $dt->ikibukti[0]->jenis_bukti_dukung }}"
                                                            @click="btn_hapus_bukti($event)">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td rowspan="{{ count($dt->ikibukti) }}">
                                                    <a class="btn btn-info" href="#modal_tambah_bukti"
                                                        data-toggle="modal" data-target="#modal_tambah_bukti"
                                                        data-id_iki="{{ $dt->id }}"
                                                        @click="btn_tambah_bukti($event)">
                                                        <i class="fa fa-plus"></i> Bukti
                                                    </a>
                                                    <a class="btn btn-warning" href="#modal_edit_iki" data-toggle="modal"
                                                        data-target="#modal_edit_iki" data-id_iki="{{ $dt->id }}"
                                                        data-ik="{{ $dt->ik }}"
                                                        data-satuan = "{{ $dt->satuan }}"
                                                        data-target_iki="{{ $dt->target }}"
                                                        data-bulan="{{ $dt->bulan }}"
                                                        data-tahun="{{ $dt->tahun }}"
                                                        data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                        data-referensi_jenis="{{ $dt->referensi_jenis }}"
                                                        @click="btn_edit_iki($event)">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a class="btn btn-danger" href="#modal_hapus_iki" data-toggle="modal"
                                                        data-target="#modal_hapus_iki" data-id_iki="{{ $dt->id }}"
                                                        data-ik="{{ $dt->ik }}" @click="btn_hapus_iki($event)">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @for ($f = 1; $f < count($dt->ikibukti); $f++)
                                                <tr>
                                                    <td>{{ $f + 1 }}</td>
                                                    <td>{{ $dt->ikibukti[$f]->jenis_bukti_dukung }}</td>
                                                    <td>{{ $model->namaBulan[$dt->ikibukti[$f]->deadline - 1] }}</td>
                                                    <td
                                                        style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        <a href="{{ $dt->ikibukti[$f]->link_bukti_dukung }}"
                                                            target="_blank">{{ $dt->ikibukti[$f]->link_bukti_dukung }}</a>
                                                    </td>
                                                    <td>
                                                        @if ($request->user == $dt->ikibukti[$f]->id_user)
                                                            <a class="btn btn-warning" href="#modal_edit_bukti"
                                                                data-toggle="modal" data-target="#modal_edit_bukti"
                                                                data-id_bukti="{{ $dt->ikibukti[$f]->id }}"
                                                                data-jenis_bukti_dukung="{{ $dt->ikibukti[$f]->jenis_bukti_dukung }}"
                                                                data-deadline="{{ $dt->ikibukti[$f]->deadline }}"
                                                                data-link_bukti_dukung="{{ $dt->ikibukti[$f]->link_bukti_dukung }}"
                                                                @click="btn_edit_bukti($event)">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-danger" href="#modal_hapus_bukti"
                                                                data-toggle="modal" data-target="#modal_hapus_bukti"
                                                                data-id_bukti="{{ $dt->ikibukti[$f]->id }}"
                                                                data-ik="{{ $dt->ik }}"
                                                                data-jenis_bukti="{{ $dt->ikibukti[$f]->jenis_bukti_dukung }}"
                                                                @click="btn_hapus_bukti($event)">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_tambah_iki" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Tambah IKI</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_tambah_iki" action="{{ url('iki_pegawai') }}" method="POST">
                            @csrf
                            <input type="text" name="id_user" id="id_user_tambah_iki" value="{{ $request->user }}"
                                readonly hidden required>
                            <div class="form-group">
                                <label>Nama IK</label>
                                <input type="text" name="ik" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="text" name="target" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">Semua</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024" selected>2024</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Referensi</label>
                                <select name="referensi_jenis" id="referensi_jenis_tambah_iki"
                                    class="form-control show-tick ms search-select" required>
                                    @foreach ($model->listReferensiJenis as $ref_jns)
                                        <option value="{{ $ref_jns }}">{{ $ref_jns }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Referensi Sumber IKI</label>
                                <select name="referensi_sumber" id="referensi_sumber_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">Tidak ada referensi</option>
                                    @foreach ($iki_atasan as $iki_ats)
                                        <option value="{{ $iki_ats->id }}">{{ $iki_ats->ik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_tambah_iki">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_edit_iki" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Edit IKI</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_edit_iki" method="POST">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Nama IK</label>
                                <input type="text" name="ik" v-model="ik_edit_iki" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" v-model="satuan_edit_iki" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="text" name="target" v-model="target_edit_iki" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">Semua</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024" selected>2024</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Referensi</label>
                                <select name="referensi_jenis" id="referensi_jenis_edit_iki"
                                    class="form-control show-tick ms search-select" required>
                                    @foreach ($model->listReferensiJenis as $ref_jns)
                                        <option value="{{ $ref_jns }}">{{ $ref_jns }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Referensi Sumber IKI</label>
                                <select name="referensi_sumber" id="referensi_sumber_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">Tidak ada referensi</option>
                                    @foreach ($iki_atasan as $iki_ats)
                                        <option value="{{ $iki_ats }}">{{ $iki_ats }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_edit_iki">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_tambah_bukti" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Tambah Bukti</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_tambah_bukti" action="{{ url('iki_pegawai_bukti') }}" method="POST">
                            @csrf
                            <input type="text" name="id_user" id="id_user_tambah_bukti" value="{{ $request->user }}"
                                readonly hidden required>
                            <input type="text" name="id_iki" id="id_iki_tambah_bukti" readonly required hidden>
                            <div class="form-group">
                                <label>Jenis Bukti Dukung</label>
                                <input type="text" name="jenis_bukti_dukung" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deadline</label>
                                <select name="deadline" id="deadline_tambah_bukti"
                                    class="form-control show-tick ms search-select" required>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Link Bukti</label>
                                <textarea type="text" name="link_bukti_dukung" class="form-control"></textarea>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_tambah_bukti">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_edit_bukti" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Edit Bukti</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_edit_bukti" method="POST">
                            @csrf
                            @method('put')
                            <input type="text" name="id_bukti" id="id_bukti_edit_bukti" readonly hidden required>
                            <div class="form-group">
                                <label>Jenis Bukti Dukung</label>
                                <input type="text" name="jenis_bukti_dukung" id="jenis_bukti_dukung_edit_bukti"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deadline</label>
                                <select name="deadline" id="deadline_edit_bukti"
                                    class="form-control show-tick ms search-select" required>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Link Bukti</label>
                                <textarea type="text" name="link_bukti_dukung" id="link_bukti_dukung_edit_bukti" class="form-control"></textarea>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_edit_bukti">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_hapus_iki" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="hapus_iki">Hapus IKI</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_hapus_iki" method="POST">
                            @csrf
                            @method('delete')
                            <div class="form-group">
                                <i>Apakah Anda Yakin Ingin Menghapus IKI <b id="text_hapus_iki">a</b> ?</i>
                                <input type="text" name="id_iki" id="id_iki_hapus_iki" class="form-control" hidden>
                                <br>
                                <i>Menghapus Iki berarti menghapus semua bukti dukung yang terkait</i>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" form="form_hapus_iki">Hapus</button>
                        <button type="button" class="btn" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_hapus_bukti" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="hapus_bukti">Hapus Bukti IKI</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_hapus_bukti" method="POST">
                            @csrf
                            @method('delete')
                            <div class="form-group">
                                <i>Apakah Anda Yakin Ingin Menghapus Bukti <b id="bukti_hapus_bukti">bukti</b> dari IKI <b
                                        id="ik_hapus_bukti">iki</b> ?</i>
                                <input type="text" name="id_bukti" id="id_bukti_hapus_bukti" class="form-control"
                                    hidden>
                                <br>
                                <i>Menghapus Iki berarti menghapus semua bukti dukung yang terkait</i>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" form="form_hapus_bukti">Hapus</button>
                        <button type="button" class="btn" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {
                id_edit_iki: '',
                ik_edit_iki: '',
                satuan_edit_iki: '',
                target_edit_iki: '',
            },
            methods: {
                btn_edit_iki: function(event) {
                    this.id_edit_iki = event.currentTarget.getAttribute('data-id_iki');
                    this.ik_edit_iki = event.currentTarget.getAttribute('data-ik');
                    this.satuan_edit_iki = event.currentTarget.getAttribute('data-satuan');
                    this.target_edit_iki = event.currentTarget.getAttribute('data-target_iki');
                    document.getElementById('bulan_edit_iki').value = event.currentTarget.getAttribute(
                        'data-bulan');
                    document.getElementById('tahun_edit_iki').value = event.currentTarget.getAttribute(
                        'data-tahun');
                    document.getElementById('referensi_jenis_edit_iki').value = event.currentTarget
                        .getAttribute('data-referensi_jenis');
                    document.getElementById('referensi_sumber_edit_iki').value = event.currentTarget
                        .getAttribute('data-referensi_sumber');
                    document.getElementById('form_edit_iki').action = window.location.origin + window.location
                        .pathname + '/' + event.currentTarget.getAttribute('data-id_iki');
                },

                btn_tambah_bukti: function(event) {
                    console.log(event.currentTarget.getAttribute('data-id_iki'))
                    document.getElementById('id_iki_tambah_bukti').value = event.currentTarget
                        .getAttribute('data-id_iki');
                },

                btn_edit_bukti: function(event) {
                    document.getElementById('id_bukti_edit_bukti').value = event.currentTarget.getAttribute(
                        'data-id_bukti');
                    document.getElementById('jenis_bukti_dukung_edit_bukti').value = event.currentTarget
                        .getAttribute(
                            'data-jenis_bukti_dukung');
                    document.getElementById('link_bukti_dukung_edit_bukti').value = event.currentTarget
                        .getAttribute(
                            'data-link_bukti_dukung');
                    document.getElementById('deadline_edit_bukti').value = event.currentTarget.getAttribute(
                        'data-deadline');
                    document.getElementById('form_edit_bukti').action = window.location.origin + window.location
                        .pathname + '_bukti/' + event.currentTarget.getAttribute('data-id_bukti');
                },

                btn_hapus_iki: function(event) {
                    document.getElementById('id_iki_hapus_iki').value = event.currentTarget.getAttribute(
                        'data-id_iki');
                    document.getElementById('text_hapus_iki').innerHTML = event.currentTarget.getAttribute(
                        'data-ik');
                    document.getElementById('form_hapus_iki').action = window.location.origin + window.location
                        .pathname + '/' + event.currentTarget.getAttribute('data-id_iki');
                },

                btn_hapus_bukti: function(event) {
                    document.getElementById('id_bukti_hapus_bukti').value = event.currentTarget.getAttribute(
                        'data-id_bukti');
                    document.getElementById('bukti_hapus_bukti').innerHTML = event.currentTarget.getAttribute(
                        'data-jenis_bukti');
                    document.getElementById('ik_hapus_bukti').innerHTML = event.currentTarget.getAttribute(
                        'data-ik');
                    document.getElementById('form_hapus_bukti').action = window.location.origin + window
                        .location.pathname + '_bukti/' + event.currentTarget.getAttribute('data-id_bukti');
                }

            }
        });
    </script>
@endsection
