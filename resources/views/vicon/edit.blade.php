@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('vicon')}}">Video Conference Room</a></li>                            
    <li class="breadcrumb-item">{{ $model->keperluan }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Video Conference Room</h2>
          </div>
          <div class="body">
              <form method="post" action="{{action('ViconController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                @include('vicon.form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
