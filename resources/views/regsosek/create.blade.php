@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ url('regsosek') }}">Master Barang</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Rincian Master Barang</h2>
          </div>
          <div class="body">
                @foreach ($errors->get('general') as $msg)
                    <h4 class="text-danger">{{ $msg }}</h4>
                @endforeach
              <form method="post" action="{{ url('regsosek') }}" enctype="multipart/form-data">
              @csrf
              @include('regsosek._form_create')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
