@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('ckp')}}"> CKP</a></li>                      
    <li class="breadcrumb-item">Rekapitulasi CKP</li>
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
            <a href="{{ url('ckp/pemantau_ckp') }}"><button class="btn btn-success float-right">Lihat Detail CKP >></button></a>
            <br/><br/>
            @if(auth()->user()->kdkab=='00')
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-12">
                        <label>Unit Kerja:</label>
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control  form-control-sm" v-model="ckp_unit_kerja">
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
                            <select class="form-control  form-control-sm" v-model="ckp_month" name="month">
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
                            <select class="form-control  form-control-sm"  v-model="ckp_year" name="year">
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
                            <select class="form-control  form-control-sm" v-model="ckp_month" name="month">
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
                            <select class="form-control  form-control-sm"  v-model="ckp_year" name="year">
                                @for ($i=2019;$i<=date('Y');$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            

          <section class="datas">
            @include('ckp.rekap_ckp_list')
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

<script>
    var vm = new Vue({  
        el: "#app_vue",
        data:  {
        datas: [],
        ckp_month: parseInt({!! json_encode($month) !!}),
        ckp_year: {!! json_encode($year) !!},
        ckp_unit_kerja: {!! json_encode($unit_kerja) !!},
        },
        watch: {
            ckp_month: function (val) {
                this.setDatas();
            },
            ckp_year: function (val) {
                this.setDatas();
            },
            ckp_unit_kerja: function (val) {
                this.setDatas();
            },
        },
        methods: {
            setDatas: function(){
                var self = this;
                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url :  "{{ url('/ckp/data_rekap_ckp') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        unit_kerja: self.ckp_unit_kerja,
                        month: self.ckp_month, 
                        year: self.ckp_year, 
                    },
                }).done(function (data) {
                    self.datas = data.datas;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
        }
    });

    $(document).ready(function() {
        vm.setDatas();
    });
</script>
@endsection