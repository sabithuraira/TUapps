@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">User</li>
    </ul>
@endsection

@section('content')
    <div class="container">
        <br />
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif

        <div class="card">
            <div class="body">
                <a href="{{ action('UserController@create') }}" class="btn btn-info">Tambah</a>
                <a href="{{ url('user_riwayat') }}" class="btn btn-info">Load Riwayat SK Pegawai</a>
                <br /><br />
                <form action="{{ url('user') }}" method="get">
                    <div class="input-group mb-3">

                        @csrf
                        <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}"
                            placeholder="Search..">

                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <section class="datas">
                    @include('user.list')
                </section>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
