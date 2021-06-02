@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">SKP</li>
</ul>
@endsection

@section('content')
    <div class="container">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card" id="app_vue">
        <div class="body">
          <a href="{{action('SkpController@create')}}" class="btn btn-success">Perbaharui SKP</a>
          <br/><br/>
          <div class="row clearfix">      
                <div class="col-lg-6 col-md-12 left-box">
                    <div class="form-group">
                        <label>Pilih SKP:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm" v-model="skp_id" name="skp_id">
                                @foreach ($skp_induk as $key=>$value)
                                    <option value="{{ $value->id }}">{{ date('d M Y', strtotime($value->tanggal_mulai)) }} - {{ date('d M Y', strtotime($value->tanggal_selesai)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
          <section class="datas">
            @include('skp.list')
          </section>
      </div>
    </div>
  </div>
@endsection