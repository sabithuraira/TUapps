@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sira')}}">Kelengkapan Administrasi</a></li>                            
    <li class="breadcrumb-item">Perbaharui Realisasi</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Realisasi</h2>
          </div>
          <div class="body">
              <form method="post" action="{{ url('sira/'.$id.'/edit_realisasi') }}" enctype="multipart/form-data">
              @csrf
              @include('sira._form_akun_realisasi')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
