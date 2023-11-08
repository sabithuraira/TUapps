@extends('layouts.blank')

@section('content')
    <div class="container" id="app_vue">
        <br/>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card member-card">
                    <div class="header bg-info">
                        <h4 class="m-t-10 text-light">{{ $model->name }}</h4>
                    </div>
                    <div class="member-img">
                        <a href="javascript:void(0);"><img src="{{ $model->fotoUrl }}" class="rounded-circle"
                                alt="profile-image"></a>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-5 text-left">NIP</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nip_baru }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">NIP Lama</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->email }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Unit Kerja</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">BPS {{ $unit_kerja->nama }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Organisasi Unit Kerja</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nmorg }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Jabatan / Gol</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nmjab }} / {{ $model->nmgol }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Wilayah</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nmwil }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist/css/chartist.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') !!}">
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
    <script src="{!! asset('assets/bundles/chartist.bundle.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/chartist/polar_area_chart.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
@endsection
