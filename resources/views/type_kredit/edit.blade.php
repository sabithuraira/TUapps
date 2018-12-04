@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('type_kredit')}}">Peruntukan Angka Kredit</a></li>                            
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
              <form method="post" action="{{action('TypeKreditController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                <div class="form-group">
                      <label>Uraian:</label>
                      <input type="text" class="form-control {{($errors->first('uraian') ? ' parsley-error' : '')}}" name="uraian" value="{{ old('uraian', $model->uraian) }}" autofocus>
                      @foreach ($errors->get('uraian') as $msg)
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
