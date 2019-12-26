@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('opname_persediaan')}}"> OPNAME PERSEDIAAN</a></li>                      
    <li class="breadcrumb-item">Kartu Kendali</li>
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
          <a href="{{action('OpnamePersediaanController@index')}}" class="btn btn-primary"><i class="fa fa-list"></i> <span>Rekap Persediaan</span></a>
          <br/><br/>
          
          <div class="row clearfix">

                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Barang:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm" v-model="barang" name="barang">
                                @foreach ($list_barang as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->nama_barang }}</option>
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
                              @for ($i=2019;$i<=date('Y');$i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>

            </div>

          <section class="datas">
          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
@endsection
