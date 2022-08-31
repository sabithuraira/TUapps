@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('user')}}">Pegawai</a></li>                            
    <li class="breadcrumb-item">{{ $model->name }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Pegawai</h2>
          </div>
          <div class="body">
              <form method="post" action="{{action('UserController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">

                <div class="form-group">
                      <label>Nama:</label>
                      <input type="text" class="form-control {{($errors->first('name') ? ' parsley-error' : '')}}" disabled name="name" value="{{ old('name', $model->name) }}" >
                      @foreach ($errors->get('name') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                      
                  </div>

                  <div class="form-group">
                      <label>NIP:</label>
                      <input type="text" class="form-control {{($errors->first('nip_baru') ? ' parsley-error' : '')}}" disabled name="nip_baru" value="{{ old('nip_baru', $model->nip_baru) }}" >
                      @foreach ($errors->get('nip_baru') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                  </div>


                  <div class="form-group">
                      <label>Jabatan:</label>
                      <input type="text" class="form-control {{($errors->first('nmjab') ? ' parsley-error' : '')}}" disabled name="nmjab" value="{{ old('nmjab', $model->nmjab) }}" >
                      @foreach ($errors->get('nmjab') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                  </div>  
                  
                  <div class="form-group">
                      <label>Wilayah Kerja:</label>
                      <input type="text" class="form-control {{($errors->first('nmwil') ? ' parsley-error' : '')}}" disabled name="nmwil" value="{{ old('nmwil', $model->nmwil) }}" >
                      @foreach ($errors->get('nmwil') as $msg)
                          <p class="text-danger">{{ $msg }}</p>
                      @endforeach
                  </div>
                  
                  <div class="form-group">
                      <label>Pimpinan:</label>
                      <select class="form-control  form-control-sm  {{($errors->first('pimpinan_id') ? ' parsley-error' : '')}}" name="pimpinan_id">
                        @foreach ($list_pegawai as $value)
                            <option value="{{ $value->id }}" 
                                @if ($value->id == old('pimpinan_id', $model->pimpinan_id))
                                    selected="selected"
                                @endif >{{ $value->nip_baru }} - {{ $value->name }}</option>
                        @endforeach
                    </select>
                      @foreach ($errors->get('pimpinan_id') as $msg)
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
