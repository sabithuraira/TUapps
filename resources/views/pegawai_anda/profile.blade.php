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


            <form method="post" action="{{url('pegawai_anda/'.$id.'/store')}}" enctype="multipart/form-data">
                @csrf
                <div>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    <br/>
                    <hr/>
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#ckp">CKP UTAMA</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ckp_penilaian">CKP PENILAIAN</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#log_book">Log Book</a></li>
                    </ul>
                    <div class="tab-content">
                        @include('pegawai_anda.ckp_utama')
                        @include('pegawai_anda.ckp_penilaian')
                        @include('pegawai_anda.log_book')
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
            var jumlah_kegiatan=0;

            for(i=0;i<this.kegiatan_utama.length;++i){
                if(typeof this.kegiatan_utama[i].target_kuantitas !== 'undefined'){
                    if((this.kegiatan_utama[i].realisasi_kuantitas/this.kegiatan_utama[i].target_kuantitas*100)>100){
                        result+=100;
                    }
                    else{
                        result+= (this.kegiatan_utama[i].realisasi_kuantitas/this.kegiatan_utama[i].target_kuantitas*100)
                    }
                    jumlah_kegiatan++;
                }
            }
            
            for(i=0;i<this.kegiatan_tambahan.length;++i){
                if(typeof this.kegiatan_tambahan[i].target_kuantitas !== 'undefined'){
                    if((this.kegiatan_tambahan[i].realisasi_kuantitas/this.kegiatan_tambahan[i].target_kuantitas*100)>100){
                        result+=100;
                    }
                    else{           
                        result+= (this.kegiatan_tambahan[i].realisasi_kuantitas/this.kegiatan_tambahan[i].target_kuantitas*100)
                    }
                    jumlah_kegiatan++;
                }
            }
            
            return parseFloat(result/jumlah_kegiatan).toFixed(2);
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
                url :  "{{ url('/ckp/data_ckp/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    user_id: {!! json_encode($model->email) !!},
                    month: self.ckp_month, 
                    year: self.ckp_year, 
                    type: 1,
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
        
        nilaiRata2: function(val1, val2, val3){
            if(typeof val1 == 'undefined') val1 = 0;
            if(typeof val2 == 'undefined') val2 = 0;
            if(typeof val3 == 'undefined') val3 = 0;

            return ((parseInt(val1)+parseInt(val2)+parseInt(val3))/3).toFixed(2);
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
