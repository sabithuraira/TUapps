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

      <div class="card">
        <div class="body">
          <a href="{{action('CkpController@create')}}" class="btn btn-info">Buat CKP</a>
          <br/><br/>
          <form action="{{url('ckp')}}" method="get">
          <div class="row clearfix">
                <div class="col-lg-3 col-md-12 left-box">
                    <div class="form-group">
                        <label>Tipe:</label>

                        <div class="input-group">
                          <select class="form-control"  name="type" id="type">
                              <option value="">- Pilih Type -</option>
                              @foreach ($model->listType as $key=>$value)
                                  <option value="{{ $key }}" 
                                    @if ($type == $key)
                                          selected="selected"
                                      @endif >{{ $value }}</option>
                              @endforeach
                          </select>

                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Bulan:</label>

                        <div class="input-group">
                          <select class="form-control"  name="month" id="month">
                                @foreach ( config('app.months') as $key=>$value)
                                    <option value="{{ $key }}" 
                                      @if ($month == $key)
                                            selected="selected"
                                        @endif >{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12 right-box">
                    <div class="form-group">
                        <label>Tahun:</label>

                        <div class="input-group">
                          <select class="form-control"  name="year" id="year">
                              @for ($i=2018;$i<=date('Y');$i++)
                                  <option value="{{ $i }}" 
                                    @if ($year == $i)
                                          selected="selected"
                                      @endif >{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>


                <div class="col-lg-2 col-md-12 right-box">
                    <div class="form-group">
                        <label>&nbsp</label>

                          <div class="input-group-append">                                            
                            <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          </form>
          <section class="datas">
            @include('ckp.list')
          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
@endsection
