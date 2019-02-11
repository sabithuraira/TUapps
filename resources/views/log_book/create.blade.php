@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('log_book')}}">Log Book</a></li>                            
    <li class="breadcrumb-item">Buat Log Book</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Buat Log Book</h2>
          </div>
          <div class="body">
              <form method="post" action="{{action('LogBookController@store')}}" enctype="multipart/form-data">
              @csrf
              @include('log_book._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
