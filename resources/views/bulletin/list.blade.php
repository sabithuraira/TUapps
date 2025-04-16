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
                <tr class="text-center">
                    <th>Jenis</th>
                    <th>User</th>
                    <th class="text-center">Waktu Tampil</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center">Aksi</th>
                </tr>
                <tr>
            </thead>
            <tbody>
                {{-- {{ json_encode($datas) }} --}}
                {{-- @foreach ($datas as $data)
                    <tr> --}}
                <tr v-for="(data, index) in datas" :key="data.id">
                    <td class="text-center" v-html="badgeJudul[data.judul] || ''"></td>
                    <td class="text-center">@{{ data.user_name }}</td>
                    <td class="text-center">
                        @{{ formatDate(data.start_date) }} - @{{ formatDate(data.end_date) }}
                        {{-- {{ date('d M Y', strtotime($data['start_date'])) }} -
                            {{ date('d M Y', strtotime($data['end_date'])) }} --}}
                    </td>
                    <td class="text-center">@{{ data.deskripsi }}</td>
                    <td class="text-center">
                        <a href="#" role="button" v-on:click="updateBulletin" data-toggle="modal"
                            data-target="#add_bulletin" :data-id="data.id" :data-user="data.user_id"
                            :data-judul="data.judul" :data-waktu_mulai="data.start_date"
                            :data-waktu_selesai="data.end_date" :data-deskripsi="data.deskripsi">
                            <i class="icon-pencil"></i>
                        </a>
                        &nbsp;
                        <a :data-id="data.id" v-on:click="delBulletin(data.id)">
                            <i class="fa fa-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        @endif
    </table>
    <br />
    {{ $datas->links() }}
</div>

@include('bulletin.modal_form')

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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script> <!-- Select2 Js -->
    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {
                datas: [],
                pathname: window.location.pathname,
                form_id: 0,
                form_judul: '',
                form_user: '',
                form_waktu_mulai: '',
                form_waktu_selesai: '',
                form_deskripsi: '',
                badgeJudul: {
                    "Ucapan Selamat": "<div class='badge badge-info'>Ucapan Selamat</div>",
                    "Pensiun": "<div class='badge badge-primary'>Pensiun</div>",
                    "Penghargaan": "<div class='badge badge-warning'>Penghargaan</div>",
                    "Tulisan": "<div class='badge badge-danger'>Tulisan</div>",
                    "Lainnya": "<div class='badge badge-secondary'>Lainnya</div>",
                },
            },

            methods: {
                getBadge(judul) {
                    // console.log(judul)
                    return this.badgeJudul[judul] || '';
                },
                formatDate(dateStr) {
                    if (!dateStr) return '-';
                    const options = {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    };
                    return new Date(dateStr).toLocaleDateString('id-ID', options);
                },

                setDatas: function() {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: self.pathname + "/data_bulletin",
                        method: 'post',
                        dataType: 'json',
                    }).done(function(data) {
                        self.datas = data.datas;
                        // console.log(self.datas)
                        $('#wait_progres').modal('hide');
                    }).fail(function(msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },

                addBulletin: function(event) {
                    var self = this;
                    if (event) {
                        self.form_id = 0;
                        self.form_judul = '';
                        self.form_user = '';
                        self.form_waktu_mulai = '';
                        self.form_waktu_selesai = '';
                        self.form_deskripsi = '';
                    }
                },

                updateBulletin: function(event) {
                    var self = this;
                    if (event) {
                        self.form_id = event.currentTarget.getAttribute('data-id');
                        self.form_judul = event.currentTarget.getAttribute('data-judul');
                        self.form_user = event.currentTarget.getAttribute('data-user');
                        $('#form_user').val(event.currentTarget.getAttribute('data-user')).trigger('change');
                        self.form_waktu_mulai = event.currentTarget.getAttribute('data-waktu_mulai');
                        $('#form_waktu_mulai').val(self.waktu_mulai);
                        self.form_waktu_selesai = event.currentTarget.getAttribute('data-waktu_selesai');
                        $('#form_waktu_selesai').val(self.waktu_selesai);
                        self.form_deskripsi = event.currentTarget.getAttribute('data-deskripsi');
                    }
                },

                saveBulletin: function() {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: self.pathname,
                        method: 'post',
                        dataType: 'json',
                        data: {
                            id: self.form_id,
                            user_id: self.form_user,
                            waktu_mulai: self.form_waktu_mulai,
                            waktu_selesai: self.form_waktu_selesai,
                            judul: self.form_judul,
                            deskripsi: self.form_deskripsi,
                        },
                    }).done(function(data) {
                        $('#add_bulletin').modal('hide');
                        self.setDatas();
                    }).fail(function(msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },

                delBulletin: function(idnya) {
                    if (confirm('anda yakin mau menghapus data ini?')) {
                        var self = this;
                        $('#wait_progres').modal('show');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        })

                        $.ajax({
                            url: self.pathname + '/' + idnya,
                            method: 'DELETE',
                            dataType: 'json',
                        }).done(function(data) {
                            $('#wait_progress').modal('hide');
                            self.setDatas();
                        }).fail(function(msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progres').modal('hide');
                        });
                    }
                },

            }
        });
        $(document).ready(function() {
            vm.setDatas();
            $('.select2').select2();

            $('.datepicker').datepicker({});

            $('#form_waktu_mulai').change(function() {
                vm.form_waktu_mulai = this.value;
            });

            $('#form_waktu_selesai').change(function() {
                vm.form_waktu_selesai = this.value;
            });

            $('#form_user').on("select2-selecting", function(e) {
                console.log(e.choice.id);
                vm.form_user = e.choice.id
            });

            $('#form_judul').change(function() {
                vm.form_judul = this.value;
            });
        })
    </script>
@endsection
