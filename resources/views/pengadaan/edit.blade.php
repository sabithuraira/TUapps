@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('/pengadaan') }}">Daftar Pengadaan</i></a></li>
        <li class="breadcrumb-item">Pengajuan Pengadaan</li>
    </ul>
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Pengajuan Pengadaan</h2>
                </div>
                <div class="body">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ \Session::get('success') }}</p>
                        </div>
                    @endif
                    <form method="post" class="frep" action="{{ url('pengadaan/update/' . $id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @include('pengadaan._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <style>
        .hrdivider {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .hrdivider span {
            position: absolute;
            top: -11px;
            background: #fff;
            /* padding: 0 20px; */
            font-weight: bold;
            font-size: 16px;
            margin-left: 30px
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script> <!-- Select2 Js -->
    <script>
        //
        // var konfirmasi_ppk = JSON.parse({{ json_encode($model->konfirmasi_ppk) }});
        var konfirmasi_ppk = @json($model->konfirmasi_ppk);
        var auth = @json($auth->getRoleNames());
        $(document).ready(function() {
            $('.datepicker').datepicker({
                // endDate: 'd',
            });
            $('#skffield').attr("disabled", "disabled");

            var ppk = auth.includes("ppk") || auth.includes("superadmin")
            if (konfirmasi_ppk != "Diterima" && ppk) {
                $('#ppkfield').removeAttr("disabled");
                $('#konfirmasi_ppk').removeAttr("disabled");
                $('#field_hps').css('background-color', 'white');
            }
            if (konfirmasi_ppk == "Ditolak") {
                $("#ppkfield").attr("hidden", true);
                $("#ppkfield").attr("disabled", "disabled");
                $("#konfirmasi_ppk").attr('disabled', 'disabled');
                $("#field_penolakan_ppk").removeAttr('hidden');
            }

            var pbj = auth.includes("pbj") || auth.includes("superadmin")
            if (konfirmasi_ppk == "Diterima" && pbj) {
                $('#pbjfield').removeAttr("disabled");
                $("#konfirmasi_pbj").removeAttr("disabled");
            }

            if ($('#nilai').val() < 10000000) {
                $('#lk_hps').attr("disabled", "disabled");
                $('#hps').attr("disabled", "disabled");
                $('#field_hps').css('background-color', '#e9ecef');
            }

            if (konfirmasi_pbj == "Ditolak") {
                $("#pbjfield").attr("hidden", true);
                $("#pbjfield").attr("disabled", "disabled");
                $("#konfirmasi_pbj").attr('disabled', 'disabled');
                $("#field_penolakan_pbj").removeAttr('hidden');
            }

            $('#konfirmasi_ppk').change(function() {
                var option = $('#konfirmasi_ppk').find(":selected").text();
                if (option == "Ditolak") {
                    $("#ppkfield").attr("hidden", true);
                    $('#ppkfield').attr("disabled", "disabled");
                    $("#field_penolakan_ppk").removeAttr('hidden');
                    $('#field_penolakan_ppk').removeAttr("disabled");
                } else {
                    $("#ppkfield").removeAttr('hidden');
                    $('#ppkfield').removeAttr("disabled");
                    $("#field_penolakan_ppk").attr("hidden", true);
                    $('#field_penolakan_ppk').attr("disabled", "disabled");
                }
            })


            $('#konfirmasi_pbj').change(function() {
                var option = $('#konfirmasi_pbj').find(":selected").text();
                if (option == "Ditolak") {
                    $("#pbjfield").attr("hidden", true);
                    $('#pbjfield').attr("disabled", "disabled");
                    $("#field_penolakan_pbj").removeAttr('hidden');
                    $('#field_penolakan_pbj').removeAttr("disabled");
                } else {
                    $("#pbjfield").removeAttr('hidden');
                    $('#pbjfield').removeAttr("disabled");
                    $("#field_penolakan_pbj").attr("hidden", true);
                    $('#field_penolakan_pbj').attr("disabled", "disabled");

                }
            })



        });
    </script>
@endsection
