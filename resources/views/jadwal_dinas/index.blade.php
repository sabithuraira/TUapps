@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Jadwal Dinas</li>
</ul>
@endsection

<style>
    .scrollme {
        overflow-y: auto;
    }

    td.red {
        background-color: #ff2600 !important;
        color: #fff;
        font-size: 10px;
    }

    td.yellow {
        background-color: #fece44 !important;
        color: #fff;
        font-size: 10px;
    }

    td.gray {
        background-color: #e8e8e8 !important;
    }
</style>

@section('content')
<div class="box box-info" id="calendar_tag">
	<div class="mailbox-controls">
        <b>Kalender Jadwal Tugas - </b>
        <select class="form-control  form-control-sm"  v-model="month" name="month">
            @foreach ( config('app.months') as $key=>$value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        
        <select class="form-control  form-control-sm"  v-model="year" name="year">
            @for ($i=2019;$i<=date('Y');$i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

		<div class="pull-right">
      <a href="{{action('JadwalDinasController@create')}}" class="btn btn-default btn-sm"><i class='fa fa-list'></i> Tambah Jadwal Dinas</a>
		</div>
		<!-- /.pull-right -->
	</div>

	<div class="alert alert-info text-center" id="loading">
		<i class="fa fa-spin fa-refresh"></i>&nbsp; Loading...
    </div>
    
	<div class="box-body">
        <div class="scrollme"> 
            <table class="table table-bordered">
                <thead id="tablehead">
                </thead>

                <tbody id="tablebody">
                </tbody>
            </table>
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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-markdown/bootstrap-markdown.min.css') !!}">
@endsection

@section('scripts')
<script>

var vm = new Vue({  
    el: "#app",
    data:  {
      datas: [],
      jenis: {!! json_encode($jenis) !!},
      tanggal: parseInt({!! json_encode($tanggal) !!}),
      bulan: parseInt({!! json_encode($bulan) !!}),
      tahun: {!! json_encode($tahun) !!},
      periode: {!! json_encode($periode) !!},
      flag_jenis: 1,
      isi: '',
      rentang_waktu: '',
      progress: '',
      keterangan: '',
      id: 0,
    },
    watch: {
        jenis: function (val) {
            if(val==1) 
            {
                this.periode = null;
                this.tanggal = parseInt({!! json_encode($tanggal) !!});
            }
            else if(val==2)
            {
                this.tanggal = null;
                this.periode = 1;
            }
            this.setDatas();
        },
        tanggal:function(val) {
            if(val!=null) this.setDatas(); 
        },
        bulan:function(val) { this.setDatas(); },
        tahun:function(val) { this.setData(s); },
        periode:function(val) { 
            if(val!=null) this.setDatas(); 
        },
    },
    methods: {
        setDatas: function () {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                url : "{{ url('/laporan/data_report/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    jenis: self.jenis,
                    tanggal: self.tanggal,
                    bulan: self.bulan,
                    tahun: self.tahun,
                    periode: self.periode, 
                },
            }).done(function (data) {
                self.datas = data.datas;
                // console.log(this.datas);

                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        saveDatas: function () {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : "{{ url('/laporan/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    jenis: self.jenis,
                    periode: self.periode,
                    isi: self.isi,
                    tanggal: self.tanggal,
                    flag_jenis: self.flag_jenis,
                    bulan: self.bulan,
                    tahun: self.tahun,
                    rentang_waktu: self.rentang_waktu,
                    progress: self.progress,
                    keterangan: self.keterangan, 
                    id: self.id,
                },
            }).done(function (data) {
                // console.log(data);
                // vm.datas = data.datas;
                $('#wait_progres').modal('hide');
                window.location.reload(false); 
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        editData: function(event){
            var self = this;

            if (event) {
                //edit1
                var idnya = parseInt(event.currentTarget.id.substr(4));

                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : "{{ url('/laporan/detail') }}"+'/'+idnya,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    console.log(data);
                    $('#wait_progres').modal('hide');

                    vm.isi= data.model.isi;
                    vm.rentang_waktu = data.model.rentang_waktu;
                    vm.progress= data.model.progress;
                    vm.keterangan= data.model.keterangan;
                    vm.id= data.model.id;

                    $('#form_modal').modal('show');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
                
            }

        },
        deleteData: function(event){
            var self = this;
            //delete1

            if (event) {
                var idnya = parseInt(event.currentTarget.id.substr(6));

                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : "{{ url('/laporan/') }}"+'/'+idnya,
                    method : 'delete',
                    dataType: 'json',
                }).done(function (data) {
                    if(data.msg=='success'){
                        alert('Data berhasil dihapus');
                        window.location.reload(false); 
                    }
                    else{
                        alert('Data gagal dihapus, mohon refresh halaman')
                    }
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
                
            }
        }
    }
});

//   $(document).ready(function() {
//       vm.setDatas();
//   });

//     $('#btn-tambah').click(function() {
//         $('#form_modal').modal('show');
//         vm.id = 0;
//     });

//     $('#btn-submit').click(function() {
//         vm.saveDatas();
//     });
</script>
@endsection