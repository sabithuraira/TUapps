@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                            
    <li class="breadcrumb-item">Penilaian Anda</li>
</ul>
@endsection

@section('content')
<div id="app_vue">
    <div class="container">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body profilepage_2 blog-page">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-12 left-box">
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

                <div class="col-lg-6 col-md-12 right-box">
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

            <form method="post" action="{{url('pegawai_anda/store_penilaian')}}" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    <br/>
                    <hr/>
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#ckp_penilaian">CKP PENILAIAN</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#log_book">Log Book</a></li>
                    </ul>
                    <div class="tab-content">
                        @include('pegawai_anda.penilaian_ckp_penilaian')
                        @include('pegawai_anda.penilaian_log_book')
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    <br/>
                </div>
            </form>
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
  
    <style type="text/css">
        * {font-family: Segoe UI, Arial, sans-serif;}
        table{font-size: small;border-collapse: collapse;}
        tfoot tr td{font-weight: bold;font-size: small;}
        input[type='number'] {
            -moz-appearance:textfield;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
@endsection


@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      ckps: [],
      month: parseInt({!! json_encode($month) !!}),
      year: {!! json_encode($year) !!},
      user_id: {!! json_encode($user_id) !!},
      datas: [],
      catatan_approve: '',
      id_row: 0,
    },
    computed: {
        // total_kuantitas: function(){
        //     var result = 0;
        //     var jumlah_kegiatan=0;

        //     for(i=0;i<this.kegiatan_utama.length;++i){
        //         if(typeof this.kegiatan_utama[i].target_kuantitas !== 'undefined'){
        //             if((this.kegiatan_utama[i].realisasi_kuantitas/this.kegiatan_utama[i].target_kuantitas*100)>100){
        //                 result+=100;
        //             }
        //             else{
        //                 result+= (this.kegiatan_utama[i].realisasi_kuantitas/this.kegiatan_utama[i].target_kuantitas*100)
        //             }
        //             jumlah_kegiatan++;
        //         }
        //     }
            
        //     for(i=0;i<this.kegiatan_tambahan.length;++i){
        //         if(typeof this.kegiatan_tambahan[i].target_kuantitas !== 'undefined'){
        //             if((this.kegiatan_tambahan[i].realisasi_kuantitas/this.kegiatan_tambahan[i].target_kuantitas*100)>100){
        //                 result+=100;
        //             }
        //             else{           
        //                 result+= (this.kegiatan_tambahan[i].realisasi_kuantitas/this.kegiatan_tambahan[i].target_kuantitas*100)
        //             }
        //             jumlah_kegiatan++;
        //         }
        //     }
            
        //     return parseFloat(result/jumlah_kegiatan).toFixed(2);
        // },
        // total_kualitas: function(){
        //     var result = 0;

        //     for(i=0;i<this.kegiatan_utama.length;++i){
        //         // if(typeof this.kegiatan_utama[i].kualitas !== 'undefined' && this.kegiatan_utama[i].kualitas!=null && this.kegiatan_utama[i].kualitas!='') 
        //         //     result+= parseInt(this.kegiatan_utama[i].kualitas);
        //         result += parseFloat(this.nilaiRata2(
        //                     this.kegiatan_utama[i].kecepatan,
        //                     this.kegiatan_utama[i].ketepatan,
        //                     this.kegiatan_utama[i].ketuntasan));
        //     }
            
        //     for(i=0;i<this.kegiatan_tambahan.length;++i){
        //         // if(typeof this.kegiatan_tambahan[i].kualitas !== 'undefined' && this.kegiatan_tambahan[i].kualitas!=null && this.kegiatan_tambahan[i].kualitas!='')
        //         //     result+= parseInt(this.kegiatan_tambahan[i].kualitas);
        //         result += parseFloat(this.nilaiRata2(
        //                     this.kegiatan_tambahan[i].kecepatan,
        //                     this.kegiatan_tambahan[i].ketepatan,
        //                     this.kegiatan_tambahan[i].ketuntasan));
        //     }

        //     return parseFloat(result/(this.kegiatan_utama.length+this.kegiatan_tambahan.length)).toFixed(2);
        // }
    },
    watch: {
        month: function (val) {
            this.setDatas();
        },
        year: function (val) {
            this.setDatas();
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
                url :  "{{ url('/ckp/data_ckp_tim/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    user_id: ,
                    month: self.month, 
                    year: self.year, 
                    type: 1,
                },
            }).done(function (data) {
                // console.log(data);
                self.ckps = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        
        nilaiRata2: function(val1, val2, val3){
            if(typeof val1 == 'undefined' || val1 == '' || val1 == null) val1 = 0;
            if(typeof val2 == 'undefined' || val2 == '' || val2 == null) val2 = 0;
            if(typeof val3 == 'undefined' || val3 == '' || val3 == null) val3 = 0;

            return ((parseInt(val1)+parseInt(val2)+parseInt(val3))/3).toFixed(2);
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
                    user_id:'',
                },
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        setDatasRencanaKerja: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : "{{ url('/rencana_kerja/data_rencana_kerja/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    start: self.start_rencana, 
                    end: self.end_rencana, 
                    user_id: '',
                },
            }).done(function (data) {
                self.datas_rencana = data.datas;
                console.log(data)
                console.log("")
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
        // vm.setDatasLogBook();
        // vm.setDatasRencanaKerja();
    });
</script
@endsection
