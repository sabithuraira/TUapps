@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('vicon')}}">Penggunaan Ruang Vicon</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Izin Penggunaan Ruang Vicon</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('vicon')}}" enctype="multipart/form-data">
              @csrf
              @include('vicon.form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
