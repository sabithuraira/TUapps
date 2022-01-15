@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Daftar Revisi</li>
</ul>
@endsection

@section('content')
<div class="container">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div>
    @endif

    <div class="card" id="app_vue">
        <div class="body">
            <a href="{{action('PokController@create_revisi')}}" class="'btn btn-info btn-sm"><i
                    class='fa fa-plus'></i> Buat Revisi</a>
            <br /><br />
            <form action="{{url('pok/revisi')}}" method="get">
                @csrf
                <div class="row clearfix">
                    <div class="col-md-12 left">
                        <input type="text" class="form-control form-control-sm" name="search" id="search"
                            value="{{ $keyword }}" placeholder="Search..">
                    </div>
                </div>
            </form>
            <br />
            <section class="datas">
                @include('pok.revisi_list')
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection