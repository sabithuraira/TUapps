@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('cuti')}}">Cuti</a></li>
    <li class="breadcrumb-item">{!! json_encode($model->nama) !!}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Perbaharui Cuti</h2>
            </div>
            <div class="body">
                <form method="post" action="{{action('CutiController@update', $id)}}" enctype="multipart/form-data">
                    @csrf
                    <input name="_method" type="hidden" value="PATCH">
                    @include('cuti._form')
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200"
                        height="200" alt="Loading..."></div>
                <h4 class="text-center">Please wait...</h4>
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
    const calculateTimimg = d => {
        let months = 0, years = 0, days = 0, weeks = 0;
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
        return {
            years, months, weeks, days
        };
    };
    var vm = new Vue({
        el: "#app_vue",
        data:  {
            list_pegawai:  {!! json_encode($list_pegawai) !!},
            id_user:  {!! json_encode($model->id_user) !!},
            nama:  {!! json_encode($model->nama) !!},
            nip: {!! json_encode($model->nip) !!},
            jabatan : {!! json_encode($model->jabatan) !!},
            jenis_cuti: {!! json_encode($model->jenis_cuti) !!},
            lama_cuti : {!! json_encode($model->lama_cuti) !!},
            masa_kerja : {!! json_encode($model->masa_kerja) !!},
            tanggal_mulai : {!! json_encode($model->tanggal_mulai) !!},
            tanggal_selesai : {!! json_encode($model->tanggal_selesai) !!},
            catatan_cuti :{!! json_encode($catatan_cuti) !!},
        },
        methods: {
        },
       
    });

    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        $('#id_user').attr('disabled','disabled')
    });
</script>
@endsection