@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_km')}}">Surat</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Rincian Surat</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('surat_km')}}" enctype="multipart/form-data">
              @csrf
              @include('surat_km._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
