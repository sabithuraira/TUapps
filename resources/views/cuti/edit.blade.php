@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('cuti') }}">Cuti</a></li>
        <li class="breadcrumb-item">{!! json_encode($model->nama) !!}</li>
    </ul>
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Perbaharui Cuti</h2>
                </div>
                <div class="body">
                    <form method="post" action="{{ action('CutiController@update', $id) }}" enctype="multipart/form-data">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH">
                        @include('cuti._form')
                    </form>
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
@endsection

@section('css')
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <style>
        .table td,
        .table th {
            padding: 2px 20px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {
                list_pegawai: {!! json_encode($list_pegawai) !!},
                id_user: {!! json_encode($model->id_user) !!},
                nama: {!! json_encode($model->nama) !!},
                nip: {!! json_encode($model->nip) !!},
                catatan_cuti: {!! json_encode($catatan_cuti) !!},
            },
            methods: {
                lamacuti: function(event) {
                    lama = $("input[name='lama_cuti_hari_kerja']").val()
                    mulai = $("input[name='tanggal_mulai']").val()
                    selesai = $("input[name='tanggal_selesai']").val()
                    var datemulai = new Date(mulai);
                    var dateselesai = new Date(selesai);
                    difference = dateselesai.getTime() - datemulai.getTime()
                    var days = Math.ceil(difference / (1000 * 3600 * 24));
                    if (lama > days + 1) {
                        $("input[name='lama_cuti_hari_kerja']")[0].setCustomValidity(
                            'Jumlah hari terlalu banyak, maksimal ' + parseInt(days + 1));
                        $("input[name='lama_cuti_hari_kerja']")[0].reportValidity();
                    } else if (lama < Math.floor(((days + 1) * 60 / 100))) {
                        $("input[name='lama_cuti_hari_kerja']")[0].setCustomValidity('Minimal ' + Math
                            .floor(((days + 1) * 60 / 100)) +
                            ', atau 60% hari kerja dari rentang waktu');
                        $("input[name='lama_cuti_hari_kerja']")[0].reportValidity();
                    } else {
                        $("input[name='lama_cuti_hari_kerja']")[0].setCustomValidity("");
                    }
                }
            },

        });

        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
            $('#id_user').attr('disabled', 'disabled')
            $('#nama_pejabat').attr('disabled', 'disabled')
            $('#nama_atasan').attr('disabled', 'disabled')
        });
    </script>
@endsection
