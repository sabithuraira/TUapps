@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('log_book')}}"> LOG BOOK</a></li>                      
    <li class="breadcrumb-item">Rekapitulasi Pekerjaan Pegawai</li>
</ul>
@endsection

@section('content')

<div id="app_vue">
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
            <div class="row clearfix">
                @if(auth()->user()->kdesl==3 || auth()->user()->kdesl==2 || auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('kepegawaian'))
                    <div class="col-lg-6 col-md-12 left-box">
                        <div class="form-group">
                            <label>Tanggal:</label>

                            <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
                                <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ date('m/d/Y', strtotime($tanggal)) }}">
                                <div class="input-group-append">                                            
                                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 right-box">
                        <div class="form-group">
                            <label>Pegawai:</label>
                            
                            <div class="input-group">
                                <select class="form-control  form-control-sm" v-model="user_id">
                                    @foreach ($list_user as $key=>$value)
                                        <option value="{{ $value->email }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 col-md-12 left-box">
                        <div class="form-group">
                            <label>Tanggal:</label>

                            <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
                                <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ date('m/d/Y', strtotime($tanggal)) }}">
                                <div class="input-group-append">                                            
                                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <form action="{{ action('LogBookController@downloadExcelWfh') }}" method="post">
                @csrf 
                <input type="hidden"  v-model="tanggal" name="tanggal">
                <input type="hidden"  v-model="user_id" name="user_id">
                <button name="action" class="float-right" type="submit"><i class="icon-printer"></i>&nbsp Cetak Laporan WFH &nbsp</button>
            </form>
            <br/><br/>

          <section class="datas">
            @include('log_book.laporan_wfh_list')
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
</div>
@endsection


@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
  
    <style type="text/css">
        * {font-family: Segoe UI, Arial, sans-serif;}
        table{font-size: small;border-collapse: collapse;}
        tfoot tr td{font-weight: bold;font-size: small;}
    </style>
@endsection


@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        datas: [],
        tanggal: {!! json_encode(date('m/d/Y', strtotime($tanggal))) !!},
        user_id: {!! json_encode($model->email) !!},
        profile: {
            'name': {!! json_encode($model->name) !!},
            'nmjab': {!! json_encode($model->nmjab) !!},
            'fotoUrl' : {!! json_encode($model->fotoUrl) !!},
        },
    },
    watch: {
        tanggal: function (val) {
            this.setDatas();
        },
        user_id: function (val) {
            this.setDatas();
            this.setProfile();
        },
    },
    methods: {
        durasi: function(val1, val2){
            var timeStart = new Date("01/01/2007 " + val2);
            var timeEnd = new Date("01/01/2007 " + val1);

            var timeDiff = timeEnd - timeStart;   
            var minuteDiff = timeDiff/60/1000;

            var num = minuteDiff;
            var hours = (num / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);

            return rhours + " jam " + rminutes + " menit";
        },
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url :  "{{ url('/log_book/data_log_book/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    start: self.tanggal, 
                    end: self.tanggal, 
                    user_id: self.user_id,
                },
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        setProfile: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url :  "{{ url('/ckp/data_profile/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    user_id: self.ckp_user,
                },
            }).done(function (data) {
                self.profile = {
                    'name': data.model.name,
                    'nmjab': data.model.nmjab,
                    'fotoUrl' : data.model.fotoUrl,
                };
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
    
    $('#tanggal').change(function() {
        vm.tanggal = this.value;
    });
</script>
@endsection