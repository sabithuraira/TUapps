@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sertifikat_induk')}}">Sertifikat</a></li>
    <li class="breadcrumb-item">Tambah data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah sertifikat (induk & peserta)</h2>
          </div>
          <div class="body">
              <form method="post" action="{{ url('sertifikat_induk') }}" enctype="multipart/form-data">
              @csrf
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
