@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sira')}}">Kelengkapan Administrasi</a></li>                            
    <li class="breadcrumb-item">Tambah Akun</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Akun</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('sira/create_akun')}}" enctype="multipart/form-data">
              @csrf
              @include('sira._form_akun')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
