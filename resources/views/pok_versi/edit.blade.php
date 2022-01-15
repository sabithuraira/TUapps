@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('pok_versi')}}">Versi POK</a></li>                            
    <li class="breadcrumb-item">{{ $model->versi }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Versi POK</h2>
          </div>
          <div class="body">
              <form method="post" action="{{action('PokVersiController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                @include('pok_versi._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
