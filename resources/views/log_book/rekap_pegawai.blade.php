@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('log_book')}}"> LOG BOOK</a></li>                      
    <li class="breadcrumb-item">Rekapitulasi Pekerjaan Pegawai</li>
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
        
        <a href="{{ url('log_book/download/'.$tanggal.'/'.$unit_kerja) }}"><button class="btn btn-success float-right">Download Excel</button></a>
            <br/><br/>
          <form action="{{url('log_book/rekap_pegawai')}}" method="get">
            <div class="row clearfix">
                    @if(auth()->user()->kdkab!='00')
                        <div class="col-lg-11 col-md-12 left-box">
                            <div class="form-group">
                                <label>Tanggal:</label>

                                <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', date('m/d/Y', strtotime($tanggal))) }}">
                                    <div class="input-group-append">                                            
                                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-5 col-md-12 left-box">
                            <div class="form-group">
                                <label>Tanggal:</label>

                                <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', date('m/d/Y', strtotime($tanggal))) }}">
                                    <div class="input-group-append">                                            
                                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-12 right-box">
                            <div class="form-group">
                                <label>Unit Kerja:</label>
                                
                                <div class="input-group">
                                    <select class="form-control  form-control-sm" name="unit_kerja">
                                        @if(auth()->user()->kdesl==2 || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('binagram'))
                                        <option @if (111 == old('unit_kerja', $unit_kerja))
                                                selected="selected" @endif value="111">Pimpinan</option>
                                        @endif
                                        @foreach ( config('app.unit_kerjas') as $key=>$value)
                                            <option @if ($key == old('unit_kerja', $unit_kerja))
                                                    selected="selected" @endif value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                       
                            </div>
                        </div>
                    @endif
                    
                    <div class="col-lg-1 col-md-12 right-box">
                    
                        <div class="form-group">
                            <label> &nbsp </label>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

          <section class="datas">
            @include('log_book.rekap_pegawai_list')
          </section>
      </div>

      <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                      <h4 class="text-center">Please wait...</h4>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
@endsection