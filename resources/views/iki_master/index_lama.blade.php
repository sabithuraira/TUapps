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
                    @if (($auth->hasanyrole('kepegawaian|superadmin') && $request->user) || $request->user == $auth->nip_baru)
                        <a href="#modal_tambah_iki" class="btn btn-info" data-toggle="modal"
                            data-target="#modal_tambah_iki">
                            Tambah
                        </a>
                    @endif
                    <br /><br />
                    <form action="{{ url('iki_pegawai') }}" method="get">
                        <div class="row px-2">
                            <div class="col-8">
                                <label for="" class="label">Pegawai</label>
                                <select name="user" id="user_filter" class="form-control show-tick ms search-select"
                                    required onchange="this.form.submit()">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($user_list as $usr)
                                        <option value="{{ $usr->nip_baru }}"
                                            @if ($request->user == $usr->nip_baru) selected @endif>
                                            {{ $usr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Tahun</label>
                                <select name="tahun" id="tahun_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    @for ($i=2022;$i<=date('Y');$i++) 
                                        <option value="{{ $i }}" @if ($request->tahun==$i) selected="selected" @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Bulan</label>
                                <select name="bulan" id="bulan_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    <option value="" selected>Semua</option>
                                    @foreach ($model->namaBulan as $g => $bln)
                                        <option value="{{ ++$g }}"
                                            @if ($request->bulan == $g) selected @endif>{{ $bln }}</option>
                                    @endforeach

                                </select>
                            </div>
                            {{-- <div class="col-2">
                                <label for="" class="label text-white">a</label>
                                <br>
                                <button class="btn btn-info" type="submit">Cari <i class="fa fa-search"></i></button>
                            </div> --}}
                        </div>
                    </form>
                    <br>
                    <div class="row px-2">
                        <div class="col table-responsive">
                            <table class="table table-sm table-bordered text-center" style="font-size: small">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>IK</th>
                                        <th>Target & Satuan</th>
                                        <th>Link Bukti</th>
                                        <th>Aksi Bukti</th>
                                        <th>Aksi IK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($datas) > 0)
                                        @foreach ($datas as $i => $dt)
                                            @if (sizeof($dt->ikibukti) < 1)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        {{ $dt->ik }} </td>
                                                    <td>{{ $dt->target . ' ' . $dt->satuan }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        @if ($auth->hasanyrole('kepegawaian|superadmin') || $request->user == $auth->nip_baru)
                                                            <a class="btn btn-info btn-sm" href="#modal_tambah_bukti"
                                                                data-toggle="modal" data-target="#modal_tambah_bukti"
                                                                data-id_iki="{{ $dt->id }}"
                                                                @click="btn_tambah_bukti($event)">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a class="btn btn-warning btn-sm" href="#modal_edit_iki"
                                                                data-toggle="modal" data-target="#modal_edit_iki"
                                                                data-id_iki="{{ $dt->id }}"
                                                                data-ik="{{ $dt->ik }}"
                                                                data-satuan = "{{ $dt->satuan }}"
                                                                data-target_iki="{{ $dt->target }}"
                                                                data-bulan="{{ $dt->bulan }}"
                                                                data-tahun="{{ $dt->tahun }}"
                                                                data-id_tim="{{ $dt->id_tim }}"
                                                                data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                                data-referensi_jenis="{{ $dt->referensi_jenis }}"
                                                                @click="btn_edit_iki($event)">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm" href="#modal_hapus_iki"
                                                                data-toggle="modal" data-target="#modal_hapus_iki"
                                                                data-id_iki="{{ $dt->id }}"
                                                                data-ik="{{ $dt->ik }}"
                                                                @click="btn_hapus_iki($event)">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @elseif (sizeof($dt->ikibukti) >= 1)
                                                <tr>
                                                    <td rowspan="{{ count($dt->ikibukti) }}">{{ ++$i }}</td>
                                                    <td style="max-width: 200px; word-wrap: break-word; white-space:normal"
                                                        rowspan="{{ count($dt->ikibukti) }}">{{ $dt->ik }} </td>

                                                    <td rowspan="{{ count($dt->ikibukti) }}">
                                                        {{ $dt->target . ' ' . $dt->satuan }}</td>
                                                    {{-- <td rowspan="{{ count($dt->ikibukti) }}">{{ $dt->satuan }}</td>
                                                    <td rowspan="{{ count($dt->ikibukti) }}">{{ $dt->target }}</td> --}}
                                                    {{-- <td>1</td>
                                                    <td style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        {{ $dt->ikibukti[0]->jenis_bukti_dukung }}</td>
                                                    <td>{{ $model->namaBulan[$dt->ikibukti[0]->deadline - 1] }}</td> --}}
                                                    <td style="max-width: 200px; word-wrap: break-word; white-space:normal"
                                                        class="text-left">
                                                        {{ '(' . $dt->ikibukti[0]->user->name . ') ' }}
                                                        <a href="{{ $dt->ikibukti[0]->link_bukti_dukung }}"
                                                            target="_blank">
                                                            {{ $dt->ikibukti[0]->link_bukti_dukung }}</a>
                                                    </td>
                                                    <td>

                                                        <a class="btn btn-info btn-sm" href="#modal_lihat_bukti"
                                                            data-toggle="modal" data-target="#modal_lihat_bukti"
                                                            data-id_iki="{{ $dt->id }}"
                                                            data-ik="{{ $dt->ik }}"
                                                            data-satuan = "{{ $dt->satuan }}"
                                                            data-target_iki="{{ $dt->target }}"
                                                            data-bulan="{{ $dt->bulan }}"
                                                            data-tahun="{{ $dt->tahun }}"
                                                            data-id_tim="{{ $dt->id_tim }}"
                                                            data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                            data-referensi_jenis="{{ $dt->referensi_jenis }}"
                                                            data-bukti="{{ json_encode($dt->ikibukti) }}"
                                                            data-user_name = "{{ $dt->ikibukti[0]->user->name }}"
                                                            @click="btn_lihat_bukti($event)">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if (
                                                            ($request->user == $dt->ikibukti[0]->nip && $request->user == $auth->nip_baru) ||
                                                                $auth->hasanyrole('kepegawaian|superadmin'))
                                                            <a class="btn btn-warning btn-sm" href="#modal_edit_bukti"
                                                                data-toggle="modal" data-target="#modal_edit_bukti"
                                                                data-id_bukti="{{ $dt->ikibukti[0]->id }}"
                                                                data-jenis_bukti_dukung="{{ $dt->ikibukti[0]->jenis_bukti_dukung }}"
                                                                data-deadline="{{ $dt->ikibukti[0]->deadline }}"
                                                                data-link_bukti_dukung="{{ $dt->ikibukti[0]->link_bukti_dukung }}"
                                                                @click="btn_edit_bukti($event)">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm" href="#modal_hapus_bukti"
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
                                                        @if ($auth->hasanyrole('kepegawaian|superadmin') || $request->user == $auth->nip_baru)
                                                            <a class="btn btn-info btn-sm" href="#modal_tambah_bukti"
                                                                data-toggle="modal" data-target="#modal_tambah_bukti"
                                                                data-id_iki="{{ $dt->id }}"
                                                                @click="btn_tambah_bukti($event)">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a class="btn btn-warning btn-sm" href="#modal_edit_iki"
                                                                data-toggle="modal" data-target="#modal_edit_iki"
                                                                data-id_iki="{{ $dt->id }}"
                                                                data-ik="{{ $dt->ik }}"
                                                                data-satuan = "{{ $dt->satuan }}"
                                                                data-target_iki="{{ $dt->target }}"
                                                                data-id_tim="{{ $dt->id_tim }}"
                                                                data-bulan="{{ $dt->bulan }}"
                                                                data-tahun="{{ $dt->tahun }}"
                                                                data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                                data-referensi_jenis="{{ $dt->referensi_jenis }}"
                                                                @click="btn_edit_iki($event)">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm" href="#modal_hapus_iki"
                                                                data-toggle="modal" data-target="#modal_hapus_iki"
                                                                data-id_iki="{{ $dt->id }}"
                                                                data-ik="{{ $dt->ik }}"
                                                                @click="btn_hapus_iki($event)">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @for ($f = 1; $f < count($dt->ikibukti); $f++)
                                                    <tr>
                                                        {{-- <td>{{ $f + 1 }}</td>
                                                        <td
                                                            style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                            {{ $dt->ikibukti[$f]->jenis_bukti_dukung }}</td>
                                                        <td>{{ $model->namaBulan[$dt->ikibukti[$f]->deadline - 1] }}</td> --}}
                                                        <td style="max-width: 200px; word-wrap: break-word; white-space:normal"
                                                            class="text-left">
                                                            {{ '(' . $dt->ikibukti[$f]->user->name . ') ' }}
                                                            <a href="{{ $dt->ikibukti[$f]->link_bukti_dukung }}"
                                                                target="_blank">{{ $dt->ikibukti[$f]->link_bukti_dukung }}</a>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="#modal_lihat_bukti"
                                                                data-toggle="modal" data-target="#modal_lihat_bukti"
                                                                data-id_iki="{{ $dt->id }}"
                                                                data-ik="{{ $dt->ik }}"
                                                                data-satuan = "{{ $dt->satuan }}"
                                                                data-target_iki="{{ $dt->target }}"
                                                                data-bulan="{{ $dt->bulan }}"
                                                                data-tahun="{{ $dt->tahun }}"
                                                                data-id_tim="{{ $dt->id_tim }}"
                                                                data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                                data-referensi_jenis="{{ $dt->referensi_jenis }}"
                                                                data-bukti="{{ json_encode($dt->ikibukti) }}"
                                                                data-user_name = "{{ $dt->ikibukti[$f]->user->name }}"
                                                                @click="btn_lihat_bukti($event)">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @if (
                                                                ($request->user == $dt->ikibukti[$f]->nip && $request->user == $auth->nip_baru) ||
                                                                    $auth->hasanyrole('kepegawaian|superadmin'))
                                                                <a class="btn btn-warning btn-sm" href="#modal_edit_bukti"
                                                                    data-toggle="modal" data-target="#modal_edit_bukti"
                                                                    data-id_bukti="{{ $dt->ikibukti[$f]->id }}"
                                                                    data-jenis_bukti_dukung="{{ $dt->ikibukti[$f]->jenis_bukti_dukung }}"
                                                                    data-deadline="{{ $dt->ikibukti[$f]->deadline }}"
                                                                    data-link_bukti_dukung="{{ $dt->ikibukti[$f]->link_bukti_dukung }}"
                                                                    @click="btn_edit_bukti($event)">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-danger btn-sm" href="#modal_hapus_bukti"
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
                                    @else
                                        <tr>
                                            <td colspan="10">Belum ada IKI / Belum pilih pegawai</td>
                                        </tr>
                                    @endif
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
                            <input type="text" name="nip" id="nip_tambah_iki" value="{{ $request->user }}"
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
                                <label> Tim</label>
                                <select name="id_tim" id="id_tim_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    @foreach ($tim_user as $tim)
                                        <option value="{{ $tim->id }}"> {{ $tim->nama_tim }}</option>
                                    @endforeach
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
                                <ul>
                                    <li>
                                        <small>
                                            <i>
                                                Tidak Masuk Bukti Dukung Atasan, Pada tabel IK Kepala/Ketua tidak
                                                menampilkan bukti dukung anggota tim
                                            </i>
                                        </small>
                                    </li>
                                    <li>
                                        <small>
                                            <i>
                                                Masuk Bukti Dukung Atasan, Pada tabel IK Kepala/Ketua hanya
                                                menampilkan bukti dukung anggota tim
                                            </i>
                                        </small>
                                    </li>
                                    <li>
                                        <small>
                                            <i>
                                                Masuk Bukti Dukung & Realisasi Atasan, Pada tabel IK Kepala/Ketua
                                                menampilkan bukti dukung anggota tim & menjadi perhitungan realisasi untuk
                                                IK atasan
                                            </i>
                                        </small>
                                    </li>
                                    <li>
                                        <small>
                                            <i>
                                                Realisasi dihitung berdasarkan link bukti dukung yang sudah terisi
                                            </i>
                                        </small>
                                    </li>
                                </ul>
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
                                <label> Tim</label>
                                <select name="id_tim" id="id_tim_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    @foreach ($tim_user as $tim)
                                        <option value="{{ $tim->id }}"> {{ $tim->nama_tim }}</option>
                                    @endforeach
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
                            <ul>
                                <li>
                                    <small><i>Tidak Masuk Bukti Dukung Atasan, Pada tabel IK Kepala/Ketua tidak
                                            menampilkan bukti dukung anggota tim
                                        </i>
                                    </small>
                                </li>
                                <li><small><i>Masuk Bukti Dukung Atasan, Pada tabel IK Kepala/Ketua hanya
                                            menampilkan bukti dukung anggota tim
                                        </i></small></li>
                                <li> <small><i>Masuk Bukti Dukung & Realisasi Atasan, Pada tabel IK Kepala/Ketua
                                            menampilkan bukti dukung anggota tim & menjadi perhitungan realisasi untuk
                                            IK
                                            atasan
                                        </i></small></li>
                            </ul>
                            <div class="form-group">
                                <label>Referensi Sumber IKI</label>
                                <select name="referensi_sumber" id="referensi_sumber_edit_iki"
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
                            <input type="text" name="nip" id="nip_tambah_bukti" value="{{ $request->user }}"
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

        <div class="modal fade" id="modal_lihat_bukti" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title">Bukti IKI</h4>
                    </div>
                    <div class="modal-body">
                        <div class="responsive-table">

                            <table class="table table-bordered">
                                <tr>
                                    <th>IKI</th>
                                    <td id="ik_lihat_bukti">nama iki</td>
                                </tr>
                                <tr>
                                    <th>TIM</th>
                                    <td id="tim_lihat_bukti">nama TIM</td>
                                </tr>
                                <tr>
                                    <th>Target</th>
                                    <td id="target_lihat_bukti">target</td>
                                </tr>
                                <tr>
                                    <th>Satuan</th>
                                    <td id="satuan_lihat_bukti">satuan</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td id="tahun_lihat_bukti">tahun</td>
                                </tr>
                                <tr>
                                    <th>Bulan</th>
                                    <td id="bulan_lihat_bukti">bulan</td>
                                </tr>
                                <tr>
                                    <th>Jenis Iki</th>
                                    <td id="jenis_lihat_bukti">jenis</td>
                                </tr>
                                <tr>
                                    <th>Sumber</th>
                                    <td id="sumber_lihat_bukti">sumber</td>
                                </tr>
                            </table>
                        </div>
                        <div class="responsive-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Bukti</th>
                                        <th>Pegawai</th>
                                        <th>Deadline</th>
                                        <th>Link Bukti</th>
                                    </tr>
                                </thead>
                                <tbody id="table_lihat_bukti">

                                </tbody>

                            </table>
                        </div>
                        <div class="modal-footer">
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
            var timUser = @json($tim_user);
            var ikiAtasan = @json($iki_atasan);
            var vm = new Vue({
                el: "#app_vue",
                data: {
                    id_edit_iki: '',
                    ik_edit_iki: '',
                    satuan_edit_iki: '',
                    target_edit_iki: '',
                    timUser: timUser,
                    ikiAtasan: ikiAtasan,
                },
                methods: {
                    btn_edit_iki: function(event) {
                        this.id_edit_iki = event.currentTarget.getAttribute('data-id_iki');
                        this.ik_edit_iki = event.currentTarget.getAttribute('data-ik');
                        this.satuan_edit_iki = event.currentTarget.getAttribute('data-satuan');
                        this.target_edit_iki = event.currentTarget.getAttribute('data-target_iki');
                        document.getElementById('bulan_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-bulan');
                        document.getElementById('tahun_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-tahun');
                        document.getElementById('id_tim_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-id_tim');
                        document.getElementById('referensi_jenis_edit_iki').value = event.currentTarget
                            .getAttribute('data-referensi_jenis');
                        document.getElementById('referensi_sumber_edit_iki').value = event.currentTarget
                            .getAttribute('data-referensi_sumber');
                        document.getElementById('form_edit_iki').action = window.location.origin +
                            window.location
                            .pathname + '/' + event.currentTarget.getAttribute('data-id_iki');
                    },

                    btn_tambah_bukti: function(event) {
                        // console.log(event.currentTarget.getAttribute('data-id_iki'))
                        document.getElementById('id_iki_tambah_bukti').value = event.currentTarget
                            .getAttribute('data-id_iki');
                    },

                    btn_edit_bukti: function(event) {
                        document.getElementById('id_bukti_edit_bukti').value = event.currentTarget
                            .getAttribute(
                                'data-id_bukti');
                        document.getElementById('jenis_bukti_dukung_edit_bukti').value = event
                            .currentTarget
                            .getAttribute(
                                'data-jenis_bukti_dukung');
                        document.getElementById('link_bukti_dukung_edit_bukti').value = event
                            .currentTarget
                            .getAttribute(
                                'data-link_bukti_dukung');
                        document.getElementById('deadline_edit_bukti').value = event.currentTarget
                            .getAttribute(
                                'data-deadline');
                        document.getElementById('form_edit_bukti').action = window.location.origin +
                            window.location
                            .pathname + '_bukti/' + event.currentTarget.getAttribute('data-id_bukti');
                    },

                    btn_hapus_iki: function(event) {
                        document.getElementById('id_iki_hapus_iki').value = event.currentTarget
                            .getAttribute(
                                'data-id_iki');
                        document.getElementById('text_hapus_iki').innerHTML = event.currentTarget
                            .getAttribute(
                                'data-ik');
                        document.getElementById('form_hapus_iki').action = window.location.origin +
                            window.location
                            .pathname + '/' + event.currentTarget.getAttribute('data-id_iki');
                    },

                    btn_hapus_bukti: function(event) {
                        document.getElementById('id_bukti_hapus_bukti').value = event.currentTarget
                            .getAttribute(
                                'data-id_bukti');
                        document.getElementById('bukti_hapus_bukti').innerHTML = event.currentTarget
                            .getAttribute(
                                'data-jenis_bukti');
                        document.getElementById('ik_hapus_bukti').innerHTML = event.currentTarget
                            .getAttribute(
                                'data-ik');
                        document.getElementById('form_hapus_bukti').action = window.location.origin +
                            window
                            .location.pathname + '_bukti/' + event.currentTarget.getAttribute(
                                'data-id_bukti');
                    },

                    btn_lihat_bukti: function(event) {
                        var namaTim = this.timUser.find(tim => tim.id == event.currentTarget.getAttribute(
                            'data-id_tim'))?.nama_tim;
                        var namaIkiSumber = "";
                        if (event.currentTarget.getAttribute('data-referensi_sumber') != "") {
                            var namaIkiSumber = this.ikiAtasan.find(ikiats => ikiats.id == event.currentTarget
                                .getAttribute('data-referensi_sumber'))?.ik;
                        }
                        document.getElementById('ik_lihat_bukti').innerHTML = event.currentTarget
                            .getAttribute('data-ik');
                        document.getElementById('tim_lihat_bukti').innerHTML = namaTim ||
                            "TIM ...";
                        document.getElementById('target_lihat_bukti').innerHTML = event.currentTarget
                            .getAttribute('data-target_iki');
                        document.getElementById('satuan_lihat_bukti').innerHTML = event.currentTarget
                            .getAttribute('data-satuan');
                        document.getElementById('tahun_lihat_bukti').innerHTML = event.currentTarget
                            .getAttribute('data-tahun');
                        document.getElementById('bulan_lihat_bukti').innerHTML = event.currentTarget
                            .getAttribute('data-bulan');
                        document.getElementById('jenis_lihat_bukti').innerHTML = event.currentTarget
                            .getAttribute('data-referensi_jenis');
                        document.getElementById('sumber_lihat_bukti').innerHTML = namaIkiSumber || "IKI.."

                        var buktiData = JSON.parse(event.currentTarget.getAttribute('data-bukti'));
                        var tablehtml = "";
                        var counter = 1;
                        var namaBulan = {
                            1: "Januari",
                            2: "Februari",
                            3: "Maret",
                            4: "April",
                            5: "Mei",
                            6: "Juni",
                            7: "Juli",
                            8: "Agustus",
                            9: "September",
                            10: "Oktober",
                            11: "November",
                            12: "Desember"
                        };
                        console.log(buktiData)

                        buktiData.forEach(element => {
                            var namaBulanStr = namaBulan[element.deadline];
                            console.log(element.user)
                            tablehtml += "<tr><td>" + counter + "</td><td>" +
                                element.jenis_bukti_dukung + "</td><td>" +
                                element.user.name + "</td><td>" +
                                namaBulanStr +
                                "</td><td style='max-width: 200px; word-wrap: break-word; white-space:normal'><a href='" +
                                element.link_bukti_dukung +
                                "'' target = '_blank'>" +
                                element.link_bukti_dukung +
                                "</a></td></tr>";
                            counter++;
                        });
                        var table = "<table>" + tablehtml + "</table>";
                        document.getElementById('table_lihat_bukti').innerHTML = tablehtml;
                    }
                }
            });
        </script>
    @endsection
