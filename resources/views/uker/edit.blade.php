@extends('main')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('uker')}}">Unit Kerja</a></li>                            
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
              <form method="post" action="{{action('UkerController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                <div class="form-group">
                      <label>Kode:</label>
                      <input type="text" class="form-control {{($errors->first('kode') ? ' parsley-error' : '')}}" name="kode" value="{{ old('kode', $model->kode) }}" >
                      @foreach ($errors->get('kode') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                      
                  </div>

                  <div class="form-group">
                      <label>Nama:</label>
                      <input type="text" class="form-control {{($errors->first('nama') ? ' parsley-error' : '')}}" name="nama" value="{{ old('nama', $model->nama) }}" >
                      @foreach ($errors->get('nama') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Simpan</button>
              
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
