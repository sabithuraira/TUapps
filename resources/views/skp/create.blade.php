@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><i class="icon-home"></i></li>
    <li class="breadcrumb-item"><a href="{{url('ckp')}}">CKP</a></li>                            
    <li class="breadcrumb-item">Buat CKP</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="body" id="app_vue">
              <form method="post" action="{{ url('ckp') }}" enctype="multipart/form-data">
              @csrf
              @include('skp._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
