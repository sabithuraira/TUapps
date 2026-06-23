@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_km')}}">Surat</a></li>                            
    <li class="breadcrumb-item">{{ $model->uraian }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Surat</h2>
          </div>
          <div class="body">
              @if (\Session::has('error'))
                  <div class="alert alert-danger">
                      <p>{{ \Session::get('error') }}</p>
                  </div>
              @endif
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul class="m-b-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <form method="post" action="{{action('SuratKmController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                @include('surat_km._form')
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
