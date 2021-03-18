@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('jadwal_dinas')}}">Jadwal Tugas</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Jadwal Tugas</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('jadwal_dinas')}}" enctype="multipart/form-data">
              @csrf
              @include('jadwal_dinas._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
