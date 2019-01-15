@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('log_book')}}">Peruntukan Angka Kredit</a></li>                            
    <li class="breadcrumb-item">{{ $model->uraian }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Peruntukan Angka Kredit</h2>
          </div>
          <div class="body">
              <form method="post" action="{{action('AngkaKreditController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                @include('log_book._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
