@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><i class="icon-home"></i></li>
    <li class="breadcrumb-item"><a href="{{url('skp')}}">SKP</a></li>                            
    <li class="breadcrumb-item">Perbaharui CKP</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="body" id="app_vue">
              @include('skp._form')
          </div>
      </div>
  </div>
</div>
@endsection
