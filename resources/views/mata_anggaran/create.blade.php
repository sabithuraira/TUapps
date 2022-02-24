@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('mata_anggaran')}}">Mata Anggaran</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Unit Kerja</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('mata_anggaran')}}" enctype="multipart/form-data">
              @csrf
              @include('mata_anggaran._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
