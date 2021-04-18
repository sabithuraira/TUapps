@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Surat</li>
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
          <a href="{{action('SuratKmController@create')}}" class="btn btn-info">Tambah</a>
    
          <br/>
          <small class="text-muted font-italic font-weight-lighter float-left">*Pengguna hanya dapat melihat & mengelola surat di unit kerja masing-masing.</small>
    
          <form action="{{url('surat_km')}}" method="get">
            <div class="input-group mb-3">
                    
                    @csrf
                    <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                    </div>
            </div>
          </form>
          <section class="datas">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#surat_masuk">Surat Masuk</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#surat_keluar">Surat Keluar</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#memorandum">Memorandum</a></li>
            </ul>
            <div class="tab-content">
                @include('surat_km.list_surat_masuk')
                @include('surat_km.list_surat_keluar')
                @include('surat_km.list_memorandum')
            </div>
          </section>
      </div>
    </div>
  </div>
@endsection

