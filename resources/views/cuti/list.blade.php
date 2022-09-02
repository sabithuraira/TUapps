<div id="load" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas) == 0)
            <thead>
                <tr>
                    <th>Tidak ditemukan data</th>
                </tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">
                        Pegawai<br />
                    </th>
                    <th class="text-center" colspan="2">Tanggal</th>
                    <th class="text-center" rowspan="2">Jenis Cuti</th>
                    <th class="text-center" rowspan="2">Lama Cuti<br />(Hari)</th>
                    <th class="text-center" colspan="2">Status</th>
                    <th class="text-center" rowspan="2">Print</th>
                    <th class="text-center" rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th class="text-center">Mulai</th>
                    <th class="text-center">Selesai</th>
                    <th class="text-center">Atasan</th>
                    <th class="text-center">Pejabat</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ json_encode($datas) }} --}}
                @foreach ($datas as $data)
                    <tr>
                        <td class="text-center">
                            <u>{{ $data['nip'] }}</u><br />
                            {{ $data['nama'] }}
                        </td>
                        <td class="text-center">{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                        <td class="text-center">{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                        <td class="text-center">{{ $data['jenis_cuti'] }}</td>
                        <td class="text-center">{{ $data['lama_cuti_hari_kerja'] + $data['lam_cuti_hari_libur'] }}</td>
                        <td class="text-center">
                            {!! $data->listStatus[$data['status_atasan']] !!}<br />
                            @if ($auth->hasanyrole('kepegawaian|superadmin') || $auth->name == $data['nama_atasan'])
                                <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                                    data-id="{{ Crypt::encrypt($data['id']) }}"
                                    data-status="{{ $data['status_atasan'] }}"
                                    data-nama_atasan="{{ $data['nama_atasan'] }}"
                                    data-nip_atasan="{{ $data['nip_atasan'] }}" data-target="#set_status_atasan">
                                    <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u>
                                    </p>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            {!! $data->listStatus[$data['status_pejabat']] !!}<br />
                            @if ($auth->hasanyrole('kepegawaian|superadmin') || $auth->name == $data['nama_pejabat'])
                                <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                                    data-id="{{ Crypt::encrypt($data['id']) }}"
                                    data-status="{{ $data['status_pejabat'] }}"
                                    data-nama_pejabat="{{ $data['nama_pejabat'] }}"
                                    data-nip_pejabat="{{ $data['nip_pejabat'] }}"
                                    data-cuti_disetujui_pejabat="{{ $data['cuti_disetujui_pejabat'] }}"
                                    data-keterangan_pejabat="{{ $data['keterangan_pejabat'] }}"
                                    data-target="#set_status_pejabat">
                                    <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u>
                                    </p>
                                </a>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ action('CutiController@print_cuti', Crypt::encrypt($data['id'])) }}"><i
                                    class="fa fa-file-pdf-o text-info"></i>
                            </a>
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @if ($data['status_pejabat'] == 0 || $data['status_atasan'] == 0)
                                    <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                                        data-id="{{ Crypt::encrypt($data->id) }}" data-target="#set_aktif">
                                        <i class="icon-trash text-danger"></i>
                                        <p class='text-danger small'>Hapus</p>
                                    </a>
                                    &nbsp;
                                    <a href="{{ action('CutiController@edit', Crypt::encrypt($data['id'])) }}">
                                        <i class="icon-pencil text-primary"></i>
                                        <p class='text-primary small'>Edit</p>
                                    </a>
                                @elseif ($data['status_pejabat'] > 3 || $data['status_atasan'] > 3)
                                    <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                                        data-id="{{ Crypt::encrypt($data->id) }}" data-target="#set_aktif">
                                        <i class="icon-trash text-danger"></i>
                                        <p class='text-danger small'>Hapus</p>
                                    </a>
                                    &nbsp;
                                    <a href="{{ action('CutiController@edit', Crypt::encrypt($data['id'])) }}">
                                        <i class="icon-pencil text-primary"></i>
                                        <p class='text-primary small'>Edit</p>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    <br />
    {{ $datas->links() }}
</div>

<div class="modal" id="set_status_atasan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Nama Atasan : <input class="form-control" v-model="nama_atasan" readonly>
                NIP Atasan : <input class="form-control" v-model="nip_atasan" readonly>
                Rubah status menjadi:
                <select class="form-control {{ $errors->first('mak') ? ' parsley-error' : '' }}" v-model="st_status">
                    <option v-for="(value, index) in list_label_status" :value="index">
                        @{{ value }}
                    </option>
                </select>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setStatus_atasan">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="set_status_pejabat" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Nama Pejabat : <input class="form-control" v-model="nama_pejabat" readonly>
                NIP Pejabat : <input class="form-control" v-model="nip_pejabat" readonly>
                Rubah status menjadi:
                <select class="form-control {{ $errors->first('mak') ? ' parsley-error' : '' }}" v-model="st_status">
                    <option v-for="(value, index) in list_label_status" :value="index">
                        @{{ value }}
                    </option>
                </select>
                <div class="form-group">
                    {{-- {{ $model->attributes()['alasan_cuti'] }} --}}
                    Lama cuti yang disetujui
                    <input type="number" name="cuti_disetujui_pejabat"
                        class="form-control form-control-sm {{ $errors->first('cuti_disetujui_pejabat') ? ' parsley-error' : '' }}"
                        v-model="cuti_disetujui_pejabat" value="{{ old('cuti_disetujui_pejabat') }}">
                    @foreach ($errors->get('cuti_disetujui_pejabat') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
                <div class="form-group">
                    Keterangan :
                    <textarea name="keterangan_pejabat"
                        class="form-control form-control-sm {{ $errors->first('keterangan_pejabat') ? ' parsley-error' : '' }}"
                        v-model="keterangan_pejabat" value="{{ old('keterangan_pejabat') }}">
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setStatus_pejabat">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_aktif" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin menghapus cuti ini? Setelah pembatalan data ini tidak
                dapat lagi digunakan.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setDelete">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200"
                        alt="Loading..."></div>
                <h4 class="text-center">Please wait...</h4>
            </div>
        </div>
    </div>
</div>

@section('css')
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="@csrf">
    <style type="text/css">
        * {
            font-family: Segoe UI, Arial, sans-serif;
        }

        table {
            font-size: small;
            border-collapse: collapse;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: small;
        }
    </style>

    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {
                datas: [],
                pathname: window.location.pathname,
                st_id: 0,
                st_status: 1,
                nama_atasan: "1",
                nip_atasan: 1,
                nama_pejabat: "",
                nip_pejabat: 1,
                cuti_disetujui_pejabat: 1,
                keterangan_pejabat: 1,
                list_label_status: {!! json_encode($model->listLabelStatus) !!},
            },
            methods: {
                sendStId: function(event) {
                    var self = this;
                    if (event) {
                        self.st_id = event.currentTarget.getAttribute('data-id');
                        self.st_status = event.currentTarget.getAttribute('data-status');
                        self.nama_atasan = event.currentTarget.getAttribute('data-nama_atasan');
                        self.nip_atasan = event.currentTarget.getAttribute('data-nip_atasan');
                        self.nip_pejabat = event.currentTarget.getAttribute('data-nip_pejabat');
                        self.nama_pejabat = event.currentTarget.getAttribute('data-nama_pejabat');
                        self.cuti_disetujui_pejabat = event.currentTarget.getAttribute(
                            'data-cuti_disetujui_pejabat');
                        self.keterangan_pejabat = event.currentTarget.getAttribute('data-keterangan_pejabat');
                    }
                },
                setStatus_atasan: function($tipe) {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: self.pathname + '/set_status_atasan',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            form_id_data: self.st_id,
                            form_status_data: self.st_status,
                        },
                    }).done(function(data) {
                        window.location.reload(false);
                    }).fail(function(msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
                setStatus_pejabat: function($tipe) {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: self.pathname + '/set_status_pejabat',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            form_id_data: self.st_id,
                            form_status_data: self.st_status,
                            form_cuti_disetujui_pejabat: self.cuti_disetujui_pejabat,
                            form_keterangan_pejabat: self.keterangan_pejabat,
                        },
                    }).done(function(data) {
                        window.location.reload(false);
                    }).fail(function(msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
                setDelete: function(jenis) {
                    var self = this;
                    $('#wait_progres').modal('show');
                    window.location.href = self.pathname + "/" + self.st_id + "/delete";
                },
            }
        });
    </script>
@endsection
