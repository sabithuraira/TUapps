<div id="load" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas) < 1)
            <thead>
                <tr>
                    <th>Tidak ditemukan data</th>
                </tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Anggaran</th>
                    <th class="text-center">Judul</th>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Konfirmasi PPK</th>
                    <th class="text-center">Konfirmasi PBJ</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $data)
                    <tr>
                        <td class="text-center">
                            {{ ++$key }}
                        </td>
                        <td class="text-ceter">
                            {{ $data->kode_anggaran }}
                        </td>
                        <td class="text-center">
                            {{ $data->judul }}
                        </td>

                        <td class="text-center">
                            Rp {{ $data->nilai }}
                        </td>
                        @if ($data->status_aktif == 1)
                            <td class="text-center">
                                {!! $data->badge_konf_ppk($data->konfirmasi_ppk) !!}<br />

                            </td>
                            <td class="text-center">
                                @if ($data->konfirmasi_ppk == 'Ditolak')
                                @else
                                    {!! $data->badge_konf_pbj($data->konfirmasi_pbj) !!}<br />
                                @endif

                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#" role="button" data-toggle="modal" v-on:click="sendId"
                                        data-id="{{ Crypt::encrypt($data['id']) }}" data-target="#set_aktif">
                                        <i class="icon-trash text-danger"></i>
                                        <p class='text-danger small'>Batalkan</p>
                                    </a>
                                    &nbsp;
                                    <a href="{{ url('pengadaan/edit/' . Crypt::encrypt($data['id'])) }}">
                                        <i class="icon-pencil text-primary"></i>
                                        <p class='text-primary small'>Edit</p>
                                    </a>
                                </div>
                            </td>
                        @else
                            <td colspan="3" class="text-center"> DIBATALKAN</td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    <br />
    {{ $datas->links() }}
</div>

<div class="modal" id="set_aktif" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin membatalkan surat tugas ini? Setelah pembatalan data ini tidak
                dapat lagi digunakan.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setAktif">Ya</button>
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
            },
            methods: {
                sendId: function(event) {
                    var self = this;
                    if (event) {
                        self.id = event.currentTarget.getAttribute('data-id');
                    }
                },
                setAktif: function() {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: self.pathname + '/set_aktif',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            id: self.id,
                        },
                    }).done(function(data) {
                        window.location.reload(false);
                    }).fail(function(msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
            }
        });
    </script>
@endsection
