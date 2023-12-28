@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('tim')}}">Pengelolaan Tim</a></li>                            
    <li class="breadcrumb-item">Tambah</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Kelola Tim</h2>
          </div>
          <div class="body">
              @include('tim._form')
          </div>
      </div>
  </div>
</div>
@endsection
