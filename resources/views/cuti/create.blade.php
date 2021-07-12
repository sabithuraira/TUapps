@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('cuti')}}">Cuti</a></li>
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Tambah Cuti</h2>
            </div>
            <div class="body">
                <form method="post" class="frep" action="{{url('cuti')}}" enctype="multipart/form-data">
                    @csrf
                    @include('cuti._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<meta name="csrf-token" content="@csrf">
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
<link rel="stylesheet"
    href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
<style>
    .table td,
    .table th {
        padding: 2px 20px;
    }
</style>
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
    var oneDay = 24 * 60 * 60 * 1000; 
   
    var vm = new Vue({
        el: "#app_vue",
        data:  {
            list_pegawai:  {!! json_encode($list_pegawai) !!},
            id_user:  {!! json_encode($model->id_user) !!},
            nama:  {!! json_encode($model->nama) !!},
            nip: {!! json_encode($model->nip) !!},
            catatan_cuti :{!! json_encode($catatan_cuti) !!},
        },
        methods: {
            setPegawai:function(event){
                var self = this;
                var selected_index = event.currentTarget.selectedIndex;
                $("#jabatan").val(self.list_pegawai[selected_index].nmjab)
                self.nama = self.list_pegawai[selected_index].name
                self.nip = self.list_pegawai[selected_index].nip_baru
                var tgl_hari_ini = new Date()
                var tgl_mulai_kerja = new Date( self.list_pegawai[selected_index].nip_baru.substring(8,12)+'-'+ self.list_pegawai[selected_index].nip_baru.substring(12,14)+'-'+self.list_pegawai[selected_index].nip_baru.substring(14,16)  )
                var harikerja = Math.round(Math.abs((tgl_mulai_kerja - tgl_hari_ini) / oneDay));
                $('#masa_kerja').val(self.calculateTimimg(harikerja)['years']+' Tahun '+self.calculateTimimg(harikerja)['months']+' Bulan')
            },
            setPejabat:function(event){
                var self = this;
                var selected_index = event.currentTarget.selectedIndex;
                $("#nip_pejabat").val(self.list_pegawai[selected_index].nip_baru)
            },
            calculateTimimg: function(d){
                var months = 0, years = 0, days = 0, weeks = 0;
                while(d){
                    if(d >= 365){
                        years++;
                        d -= 365;
                    }else if(d >= 30){
                        months++;
                        d -= 30;
                    }else if(d >= 7){
                        weeks++;
                        d -= 7;
                    }else{
                        days++;
                        d--;
                    }
                };
                return { years, months, weeks, days };
            }
        }
    });
    
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    });
</script>
@endsection