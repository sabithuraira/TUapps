@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
        <div class="col-lg-12 col-md-12">
            @include('dashboard.st2023.index')
        </div>

        {{-- <div class="col-lg-12 col-md-12">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-12">
                    @include('dashboard.random_profile')
                </div>
                <div class="col-lg-6 col-md-12">
                    @include('dashboard.list_unit_kerja')
                </div>
            </div>
        </div> --}}
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
@endsection
