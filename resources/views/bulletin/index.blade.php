@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Bulletin</li>
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
                <form action="{{ url('bulletin') }}" method="get">
                    <a href="#" role="button" v-on:click="addBulletin" class="btn btn-info" data-toggle="modal"
                        data-target="#add_bulletin"><i class="fa fa-plus-circle"></i>
                        <span>Tambah Buletin</span>
                    </a>
                    <button hidden name="action" type="submit" value="1"></button>
                    <br /><br />
                    @csrf

                    <div class="row clearfix">
                        @if (Auth::user()->kdkab == '00')
                            <div class="col-md-4 left">
                                <select class="form-control  form-control-sm" name="unit_kerja" id="unit_kerja_filter"
                                    onchange="this.form.submit()">
                                    <option @if ($unit_kerja === '') selected @endif value="">
                                        Tampilkan Semua</option>
                                    @foreach (config('app.unit_kerjas') as $key => $value)
                                        <option @if ($key === $unit_kerja) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-md-4 left">
                            <select class="form-control  form-control-sm" name="judul" id="judul_filter"
                                onchange="this.form.submit()">
                                <option value="">Pilih Judul</option>
                                @foreach ($model->getListJudul() as $item)
                                    <option @if ($judul == $item) selected="selected" @endif
                                        value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </form>
                <br />
                <section class="datas">
                    @include('bulletin.list')
                </section>
            </div>
        </div>
    </div>
@endsection
