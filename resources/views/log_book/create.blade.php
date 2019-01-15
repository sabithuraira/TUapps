@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('log_book')}}">CKP</a></li>                            
    <li class="breadcrumb-item">Buat CKP</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Buat CKP</h2>
          </div>
          <div class="body" id="app_vue">
              <form method="post" action="{{url('log_book')}}" enctype="multipart/form-data">
              @csrf
              @include('log_book._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
