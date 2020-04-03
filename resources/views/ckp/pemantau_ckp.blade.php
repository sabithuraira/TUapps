@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item"><a href="{{url('pegawai_anda')}}">Rincian CKP Pegawai</a></li>                            
    <li class="breadcrumb-item"></li>
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
        <div class="body profilepage_2 blog-page">

            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Pegawai:</label>

                        <div class="input-group">
                        <select class="form-control  form-control-sm" v-model="ckp_user">
                                @foreach ($list_user as $key=>$value)
                                    <option value="{{ $value->email }}">{{ $value->name }}</option>
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

            <div class="profile-header">
                <div>
                    <div class="profile-image"> <img :src="profile.fotoUrl" width="70" class="rounded-circle" alt=""> </div>
                    <div>
                        <h4 class="m-b-0">@{{ profile.name }}</h4>
                        <p>@{{ profile.nmjab }}</p>
                    </div>                           
                </div>
            </div>

            <form action="{{action('CkpController@print')}}" method="post">
                @csrf 
                <input type="hidden"  v-model="ckp_month" name="p_month">
                <input type="hidden"  v-model="ckp_year" name="p_year">
                <input type="hidden"  v-model="ckp_user" name="p_user">
                <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak CKP-R &nbsp</button>
                <span class="float-right">&nbsp &nbsp</span>
                <button name="action" class="float-right" type="submit" value="1"><i class="icon-printer"></i>&nbsp Cetak CKP-T &nbsp</button>
            </form>
            <br/><br/>

            <div>
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#ckp">CKP UTAMA</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ckp_penilaian">CKP PENILAIAN</a></li>
                </ul>
                <div class="tab-content">
                    @include('ckp.ckp_utama')
                    @include('ckp.ckp_penilaian')
                </div>
            </div>
      </div>
    </div>
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
      kegiatan_utama: [],
      kegiatan_tambahan: [],
      ckp_month: parseInt({!! json_encode($month) !!}),
      ckp_year: {!! json_encode($year) !!},
      ckp_user: {!! json_encode($model->email) !!},

      profile: {
          'name': {!! json_encode($model->name) !!},
          'nmjab': {!! json_encode($model->nmjab) !!},
          'fotoUrl' : {!! json_encode($model->fotoUrl) !!},
      },

      total_utama: 1,
      total_tambahan: 1,
      total_column: 10,

      datas: [],
      start: {!! json_encode($start) !!},
      end: {!! json_encode($end) !!},
      catatan_approve: '',
      id_row: 0,
    },
    computed: {
        total_kuantitas: function(){
            var result = 0;

            for(i=0;i<this.kegiatan_utama.length;++i){
                if(typeof this.kegiatan_utama[i].target_kuantitas !== 'undefined') 
                    result+= (this.kegiatan_utama[i].realisasi_kuantitas/this.kegiatan_utama[i].target_kuantitas*100)
            }
            
            for(i=0;i<this.kegiatan_tambahan.length;++i){
                if(typeof this.kegiatan_tambahan[i].target_kuantitas !== 'undefined')
                    result+= (this.kegiatan_tambahan[i].realisasi_kuantitas/this.kegiatan_tambahan[i].target_kuantitas*100)
            }

            return parseFloat(result/(this.kegiatan_utama.length+this.kegiatan_tambahan.length)).toFixed(2);
        },
        total_kualitas: function(){
            var result = 0;

            for(i=0;i<this.kegiatan_utama.length;++i){
                if(typeof this.kegiatan_utama[i].kualitas !== 'undefined' && this.kegiatan_utama[i].kualitas!=null && this.kegiatan_utama[i].kualitas!='') 
                    result+= parseInt(this.kegiatan_utama[i].kualitas);
            }
            
            for(i=0;i<this.kegiatan_tambahan.length;++i){
                if(typeof this.kegiatan_tambahan[i].kualitas !== 'undefined' && this.kegiatan_tambahan[i].kualitas!=null && this.kegiatan_tambahan[i].kualitas!='')
                    result+= parseInt(this.kegiatan_tambahan[i].kualitas);
            }

            return parseFloat(result/(this.kegiatan_utama.length+this.kegiatan_tambahan.length)).toFixed(2);
        }
    },
    watch: {
        ckp_month: function (val) {
            this.setDatas();
        },
        ckp_year: function (val) {
            this.setDatas();
        },
        ckp_user: function (val) {
            this.setDatas();
            this.setProfile();
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
                url :  "{{ url('/ckp/data_ckp/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    user_id: self.ckp_user,
                    month: self.ckp_month, 
                    year: self.ckp_year, 
                    type: 1,
                },
            }).done(function (data) {
                self.kegiatan_utama = data.datas.utama;
                self.kegiatan_tambahan = data.datas.tambahan;
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
</script>
@endsection
