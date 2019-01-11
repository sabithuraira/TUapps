@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">CKP</li>
</ul>
@endsection

@section('content')
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card" id="app_vue">
        <div class="body">
          <a href="{{action('CkpController@create')}}" class="btn btn-info">Buat CKP</a>
          <br/><br/>
          

          <div class="row clearfix">
                <div class="col-lg-4 col-md-12 left-box">

                    <div class="form-group">
                        <label>Tipe:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm"  v-model="type" name="type">
                              @foreach ($model->listType as $key=>$value)
                                  <option value="{{ $key }}">{{ $value }}</option>
                              @endforeach
                          </select>

                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Bulan:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm"  v-model="month" name="month">
                                @foreach ( config('app.months') as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 right-box">
                    <div class="form-group">
                        <label>Tahun:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm"  v-model="year" name="year">
                              @for ($i=2018;$i<=date('Y');$i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>

            </div>

          <section class="datas">
            @include('ckp.list')
          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
@endsection
