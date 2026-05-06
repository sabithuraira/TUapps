@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Sertifikat</li>
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
          <a href="{{ action('SertifikatIndukController@create') }}" class="btn btn-info">Tambah</a>
          <br/><br/>

          <form action="{{ url('sertifikat_induk') }}" method="get">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label>Kata kunci:</label>
                      <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Kegiatan, kode satker, klasifikasi..." onchange="this.form.submit()">
                  </div>
                </div>
              </div>
          </form>
          <section class="datas">
              @include('sertifikat_induk.list')
          </section>
      </div>
    </div>
  </div>
@endsection
