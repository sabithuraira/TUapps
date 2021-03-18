@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('uker4')}}">Unit Kerja</a></li>                            
    <li class="breadcrumb-item">{{ $model->nama }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Unit Kerja</h2>
          </div>
          <div class="body">
              <form method="post" action="{{action('Uker4Controller@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                @include('uker4._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
