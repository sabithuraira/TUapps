@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('log_book')}}"> LOG BOOK</a></li>                      
    <li class="breadcrumb-item">Rekapitulasi Per Satker</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <form action="{{url('log_book/rekap_uker_perbulan')}}" method="get">
            <div class="row clearfix">
                    @if(auth()->user()->kdkab=='00')
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-12">
                                <label>Unit Kerja:</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control  form-control-sm" v-model="uker" name="uker">
                                            @foreach (config('app.unit_kerjas') as $key=>$value)
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
                                    <select class="form-control  form-control-sm" v-model="month" name="month">
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
                                    <select class="form-control  form-control-sm" v-model="year" name="year">
                                        @for ($i=2019;$i<=date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row clearfix">

                            <div class="col-lg-6 col-md-12 left-box">
                                <div class="form-group">
                                    <label>Bulan:</label>

                                    <div class="input-group">
                                    <select class="form-control  form-control-sm" v-model="month"  name="month">
                                            @foreach ( config('app.months') as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 right-box">
                                <div class="form-group">
                                    <label>Tahun:</label>

                                    <div class="input-group">
                                    <select class="form-control  form-control-sm" v-model="year" name="year">
                                        @for ($i=2019;$i<=date('Y');$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    </div>
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
                <div id="load">
                    <div class="table-responsive">
                        <table class="table-bordered  m-b-0" style="min-width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama/NIP</th>
                                    <th style="min-width:60%">Total LogBook</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($datas as $key=>$data)
                                    <tr>
                                        <td>{{ $key+1 }} </td>
                                        <td>{{ $data->name }} / {{ $data->nip_baru }}</td>
                                        <td class="text-center">{!! $data->total_logbook !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>


<script>
    var vm = new Vue({  
        el: "#app_vue",
        data:  {
            month: {!! json_encode($month) !!},
            year: {!! json_encode($year) !!},
            uker: {!! json_encode($uker) !!},
        },
    });
</script>
@endsection