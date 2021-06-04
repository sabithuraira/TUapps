@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('penugasan')}}">Penugasan</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Penugasan</h2>
          </div>
          <div class="body">
              <form method="post" class="frep" action="{{url('penugasan')}}" enctype="multipart/form-data">
              @csrf
              @include('penugasan._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
