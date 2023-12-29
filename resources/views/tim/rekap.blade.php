@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item"><a href="{{ url('penugasan') }}">Matrik Tugas</a></li>                            
    <li class="breadcrumb-item">Rekap Pegawai</li>
</ul>
@endsection

@section('content')
<div id="app_vue">
    <div class="container">
      <br />
      <div class="card">
        <div class="body profilepage_2 blog-page">
            @if(auth()->user()->kdkab=='00')
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control  form-control-sm" v-model="unit_kerja">
                                @foreach (config('app.unit_kerjas') as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Pegawai:</label>
                        <div class="input-group">
                            <select class="form-control  form-control-sm" v-model="user">
                                <option v-for="(data, index) in list_user" :key="data.id" :value="data.id">
                                    @{{ data.name }}
                                </option>
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
                <div class="table-responsive">
                    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
                        <thead>
                            <tr class="text-center">
                                <td rowspan="2">No</td>
                                <td rowspan="2">Judul</td>
                                <td rowspan="2">Ditugaskan Oleh</td>
                                <td colspan="2">Waktu</td>
                                <td colspan="3">Jumlah</td>
                            </tr>

                            <tr class="text-center">
                                <td>Mulai</td>
                                <td>Selesai</td>
                                <td>Target</td>
                                <td>Dilaporkan</td>
                                <td>Realisasi</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(data, index) in rekap_data" :key="data.id">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ data.isi }}</td>
                                <td>@{{ fungsiLabel(data.ditugaskan_oleh_fungsi) }}</td>
                                <td class="text-center">@{{ data.tanggal_mulai }}</td>
                                <td class="text-center">@{{ data.tanggal_selesai }}</td>
                                <td class="text-center">@{{ data.jumlah_target }}</td>
                                <td class="text-center">@{{ data.jumlah_lapor }}</td>
                                <td class="text-center">@{{ data.jumlah_selesai }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
            </section>
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
      rekap_data: [],
      month: parseInt({!! json_encode($month) !!}),
      year: {!! json_encode($year) !!},
      user: {!! json_encode($model->id) !!},
      datas: [],
      id_row: 0,
      list_user: {!! json_encode($list_user) !!},
      list_fungsi: {!! json_encode($list_fungsi) !!},
      unit_kerja: {!! json_encode($unit_kerja) !!},
    },
    watch: {
        month: function (val) {
            this.setDatas();
        },
        year: function (val) {
            this.setDatas();
        },
        user: function (val) {
            this.setDatas();
        },
        unit_kerja: function (val) {
            this.setUnitKerja();
            this.setDatas();
        },
    },
    methods: {
        setUnitKerja: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                url :  "{{ url('/ckp/data_unit_kerja') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    unit_kerja: self.unit_kerja,
                },
            }).done(function (data) {
                self.list_user = data.list_user;
                if(self.list_user.length>0){
                    self.user = self.list_user[0].id;
                }
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
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
                url :  "{{ url('/penugasan/data_rekap') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    user_id: self.user,
                    month: self.month, 
                    year: self.year, 
                },
            }).done(function (data) {
                self.rekap_data = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        fungsiLabel: function(nilai){
            cur_result = this.list_fungsi.find(x => x.id === nilai)

            if(cur_result==undefined){
                return "";
            }
            else{
                return cur_result.nama;
            }

        }
    }
});
    $(document).ready(function() {
        vm.setDatas();
    });
</script>
@endsection
