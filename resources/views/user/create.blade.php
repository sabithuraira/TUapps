@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('uker')}}">Unit Kerja</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Unit Kerja</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('uker')}}" enctype="multipart/form-data">
              @csrf
                  <div class="form-group">
                      <label>Kode:</label>
                      <input type="text" class="form-control {{($errors->first('kode') ? ' parsley-error' : '')}}" name="kode" value="{{ old('kode') }}" >
                      @foreach ($errors->get('kode') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                      
                  </div>

                  <div class="form-group">
                      <label>Nama:</label>
                      <input type="text" class="form-control {{($errors->first('nama') ? ' parsley-error' : '')}}" name="nama" value="{{ old('nama') }}" >
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
