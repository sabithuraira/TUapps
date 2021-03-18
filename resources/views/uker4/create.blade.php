@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('uker4')}}">Unit Kerja 4</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Unit Kerja 4</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('uker4')}}" enctype="multipart/form-data">
              @csrf
              @include('uker4._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
