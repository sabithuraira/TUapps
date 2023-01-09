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
                    <form method="post" class="frep" action="{{ url('pengadaan/store') }}" enctype="multipart/form-data">
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
    <script src="{!! asset('js/jquery.mask.js') !!}"></script> <!-- Select2 Js -->
    <script>
        $(document).ready(function() {

            $('.uang').mask('000.000.000.000.000', {
                reverse: true
            });
            $('.datepicker').datepicker({
                // endDate: 'd',
            });

        });
    </script>
@endsection
