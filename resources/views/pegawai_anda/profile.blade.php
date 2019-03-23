@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item"><a href="{{url('pegawai_anda')}}">Pegawai Anda</a></li>                            
    <li class="breadcrumb-item">{{ $model->name }}</li>
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

            <div class="profile-header">
                <div>
                    <div class="profile-image"> <img src="{!! $model->fotoUrl !!}" width="70" class="rounded-circle" alt=""> </div>
                    <div>
                        <h4 class="m-b-0">{{ $model->name }}</h4>
                        <p>{{ $model->nmjab }}</p>
                    </div>                           
                </div>
            </div>

            <div>
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#ckp">CKP</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#log_book">Log Book</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="ckp">

                        
                        <div class="row clearfix">

                                
                            <div class="col-lg-6 col-md-12 left-box">
                                <div class="form-group">
                                    <label>Bulan:</label>

                                    <div class="input-group">
                                    <select class="form-control  form-control-sm"  v-model="ckp_month" name="ckp_month">
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
                                    <select class="form-control  form-control-sm"  v-model="ckp_year" name="ckp_year">
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
                                
                                <br/><br/>
                                <table class="table m-b-0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th class="text-center" rowspan="2">{{ $ckp->attributes()['uraian'] }}</th>
                                            <th class="text-center" rowspan="2">{{ $ckp->attributes()['satuan'] }}</th>
                                            
                                                <th class="text-center" colspan="3">Kuantitas</th>
                                                <th class="text-center" rowspan="2">Tingkat Kualitas</th>
                                            
                                            <th class="text-center" rowspan="2">{{ $ckp->attributes()['kode_butir'] }}</th>
                                            <th class="text-center" rowspan="2">{{ $ckp->attributes()['angka_kredit'] }}</th>
                                            <th class="text-center" rowspan="2">{{ $ckp->attributes()['keterangan'] }}</th>
                                        </tr>

                                        <tr>
                                            <th class="text-center" >Target</th>
                                            <th class="text-center" >Realisasi</th>
                                            <th class="text-center" >%</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr><td :colspan="total_column">UTAMA</td></tr>
                                        <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                                            <td>@{{ index+1 }}</td>
                                            <td>@{{ data.uraian }}</td>
                                            <td>@{{data.satuan }}</td>
                                            <td class="text-center">@{{data.target_kuantitas }}</td>
                                            
                                                <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                                                <td class="text-center">@{{ (data.realisasi_kuantitas/data.target_kuantitas)*100 }} %</td>
                                                <td class="text-center">@{{ data.kualitas }} %</td>
                                            
                                            <td>@{{ data.kode_butir }}</td>
                                            <td>@{{ data.angka_kredit }}</td>
                                            <td>@{{ data.keterangan }}</td>
                                        </tr>
                                        
                                        <tr><td :colspan="total_column">TAMBAHAN</td></tr>
                                        <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                                            <td>@{{ index+1 }}</td>
                                            <td>@{{ data.uraian }}</td>
                                            <td>@{{data.satuan }}</td>
                                            <td class="text-center">@{{data.target_kuantitas }}</td>
                                            
                                                <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                                                <td class="text-center">@{{ (data.realisasi_kuantitas/data.target_kuantitas)*100 }} %</td>
                                                <td class="text-center">@{{ data.kualitas }} %</td>
                                            
                                            <td>@{{ data.kode_butir }}</td>
                                            <td>@{{ data.angka_kredit }}</td>
                                            <td>@{{ data.keterangan }}</td>
                                        </tr>

                                        <template>
                                            <tr>
                                                <td colspan="5"><h4>JUMLAH</h4></td>
                                                <td class="text-center">@{{ total_kuantitas }} %</td>
                                                <td class="text-center">@{{ total_kualitas }} %</td>
                                                

                                                <td colspan="3"></td>
                                            </tr>
                                        </template>

                                    </tbody>

                                
                                </table>
                            </div>    


                        </section>


                    </div>
                    
                    <div class="tab-pane" id="log_book">
                    

                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 left-box">

                                <div class="form-group">
                                    <label>Rentang Waktu:</label>
                                    
                                    <div class="input-daterange input-group" data-provide="datepicker">
                                        <input type="text" class="input-sm form-control" v-model="start" id="start">
                                        <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                                        
                                        <input type="text" class="input-sm form-control" v-model="end" id="end">
                                    </div>

                                </div>
                            </div>

                        </div>

                        <section class="datas">

                            <div class="table-responsive">
                                <table class="table m-b-0">
                                    <tbody v-for="(data, index) in all_dates" :key="data.val">
                                        <tr >
                                            <th colspan="3">
                                                @{{ data.label }}
                                            </th>
                                        </tr>

                                        <tr v-for="(data2, index2) in list_times" :key="data2.id">
                                            <td>
                                                <template v-if="getId(data.val, data2.id)!=0">
                                                    <i v-on:click="komentar" data-toggle="modal" data-target="#form_modal" class="btn_comment text-success icon-bubbles" :data-id="getId(data.val, data2.id)"></i>
                                                </template>
                                                
                                                <template v-if="getId(data.val, data2.id)==0">
                                                    &nbsp &nbsp &nbsp
                                                </template>

                                                &nbsp &nbsp &nbsp
                                                @{{ data2.waktu }}
                                            </td>
                                            <td v-html="showIsi(data.val, data2.id)"></td>
                                            <td v-html="showKomentar(data.val, data2.id)"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </section>

                    </div>
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


<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span id="myModalLabel">Catatan Pimpinan</span>
            </div>
            
            <div class="modal-body">
                <table class="table table-hover table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" v-model="id_row"/>
                                <textarea class="form-control" v-model="catatan_approve" data-provide="markdown" rows="10"></textarea>
                            </td>  
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button v-on:click="saveKomentar" class="btn btn-primary" data-dismiss="modal" id="btn-submit">Save changes</button>
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
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      kegiatan_utama: [],
      kegiatan_tambahan: [],
      type: 1,
      ckp_month: parseInt({!! json_encode($month) !!}),
      ckp_year: {!! json_encode($year) !!},
      total_utama: 1,
      total_tambahan: 1,
      total_column: 10,


      datas: [],
      start: {!! json_encode($start) !!},
      end: {!! json_encode($end) !!},
      all_dates: [],
      list_times: [],
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
                    user_id: {!! json_encode($model->email) !!},
                    month: self.ckp_month, 
                    year: self.ckp_year, 
                    type: self.type,
                },
            }).done(function (data) {
                // console.log(data);
                self.kegiatan_utama = data.datas.utama;
                self.kegiatan_tambahan = data.datas.tambahan;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },

        komentar: function (event) {
            var self = this;
            if (event) {
                self.id_row = event.currentTarget.dataset.id;

                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    // url : self.pathname+"/"+self.id_row+"/komentar",
                    url : "{{ url('/log_book/komentar/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.id_row,
                    },
                }).done(function (data) {
                    self.catatan_approve = data.result;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });

            }
        },
        saveKomentar: function (event) {
            console.log("masuk save");
            var self = this;
            if (event) {
                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : "{{ url('/log_book/save_komentar/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.id_row, 
                        catatan_approve: self.catatan_approve,
                    },
                }).done(function (data) {
                    $('#wait_progres').modal('hide');
                    window.location.reload(false); 
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });

            }
        },
        setDatasLogBook: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                // url : self.pathname+"/data_log_book",
                url : "{{ url('/log_book/data_log_book/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    start: self.start, 
                    end: self.end, 
                    user_id: {!! json_encode($model->email) !!},
                },
            }).done(function (data) {
                self.datas = data.datas;
                self.all_dates = data.all_dates;
                self.list_times = data.list_times;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        showIsi: function(tanggal, waktu){
            var self = this;
            const rowData = self.datas.find(el => (el.tanggal == tanggal && el.waktu == waktu));

            if(rowData!=undefined) result=rowData.isi;
            else result = '';

            return result;
        },
        showKomentar: function(tanggal, waktu){
            var self = this;
            const rowData = self.datas.find(el =>  (el.tanggal == tanggal && el.waktu == waktu));

            if(rowData!=undefined) result=rowData.catatan_approve;
            else result = '';

            return result;
        },
        getId: function(tanggal, waktu){
            var self = this;
            const rowData = self.datas.find(el =>  (el.tanggal == tanggal && el.waktu == waktu));

            if(rowData!=undefined) result=rowData.id;
            else result = 0;

            return result;
        },
    }
});

    $(document).ready(function() {
        vm.setDatas();
        vm.setDatasLogBook();
    });


    $('#btn_comment').click(function() {
        $('#form_modal').modal('show');
        vm.id_row = 0;
    });

    $('#start').change(function() {
        vm.start = this.value;
        vm.setDatasLogBook();
    });


    $('#end').change(function() {
        vm.end = this.value;
        vm.setDatasLogBook();
    });
</script>
@endsection
