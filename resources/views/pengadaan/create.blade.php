@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('/pengadaan') }}">Daftar Pengadaan</i></a></li>
        <li class="breadcrumb-item">Pengajuan Pengadaan</li>
    </ul>
@endsection

@section('content')
    <div id="app_vue">
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
                        {{-- <form method="post" class="frep" action="{{ url('pengadaan/store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @include('pengadaan._form')
                        </form> --}}

                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home-withicon"><i
                                        class="fa fa-user"></i> SKF</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile-withicon"><i
                                        class="fa fa-search"></i> PPK</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Contact-withicon"><i
                                        class="fa fa-money"></i> PBJ</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="Home-withicon">
                                <h6>SKF</h6>
                                <form method="post" class="frep" action="{{ url('pengadaan/store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @include('pengadaan._form_skf')
                                </form>
                            </div>
                            <div class="tab-pane" id="Profile-withicon">
                                <h6>PPK</h6>
                                Hanya Edit / diisi apabila SKF telah Submit
                                {{-- <form method="post" class="frep" action="{{ url('pengadaan/store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @include('pengadaan._form_ppk')
                                </form> --}}
                            </div>
                            <div class="tab-pane" id="Contact-withicon">
                                <h6>PBJ</h6>
                                Hanya Edit / diisi apabila SKF telah Submit
                                {{-- <form method="post" class="frep" action="{{ url('pengadaan/store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @include('pengadaan._form_pbj')
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script>
    <script src="{!! asset('js/jquery.mask.js') !!}"></script>
    <script>
        $(document).ready(function() {
            $('.uang').mask('000.000.000.000.000', {
                reverse: true
            });
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd"
            });
        });
    </script>
@endsection
