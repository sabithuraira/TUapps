@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('type_kredit')}}">Peruntukan Angka Kredit</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Peruntukan Angka Kredit</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('type_kredit')}}" enctype="multipart/form-data">
              @csrf
              @include('type_kredit._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
