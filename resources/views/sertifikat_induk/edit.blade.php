@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sertifikat_induk')}}">Sertifikat</a></li>
    <li class="breadcrumb-item">Ubah: {{ $model->kegiatan }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Ubah sertifikat</h2>
          </div>
          <div class="body">
              <form method="post" action="{{ action('SertifikatIndukController@update', $id) }}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                @include('sertifikat_induk._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection

@section('scripts')
@include('sertifikat_induk._scripts')
@endsection
