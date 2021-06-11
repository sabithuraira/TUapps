@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('penugasan')}}">Matrik Tugas</a></li>                            
    <li class="breadcrumb-item">Tugas Data</li>
</ul>
@endsection

@section('content')
<div id="app_vue" class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Matrik Tugas Anda</h2>
            </div>
            <div class="body">
                @if(count($list_penugasan)==0)
                    <span>Belum ada matrik tugas untuk anda</span>
                @else
                    <div class="new_timeline">
                        @php 
                            $list_color = ['green', 'orange', 'yellow', 'green', 'red',  
                                'pink', 'blue', 'red', 'purple', 'cyan']
                        @endphp
                        <ul>
                            @foreach($list_penugasan as $key=>$value)
                                <li>
                                    <div class="bullet {{ $list_color[$key%10] }}"></div>
                                    <div class="time">
                                        {{ date('d M Y',strtotime($value->PenugasanIndukRel->tanggal_mulai)) }} -<br/> 
                                        {{ date('d M Y',strtotime($value->PenugasanIndukRel->tanggal_selesai)) }}
                                    </div>
                                    <div class="desc">
                                        <h3>{{ $value->PenugasanIndukRel->isi }}</h3>
                                        <small>{{ $value->jumlah_target }} {{ $value->PenugasanIndukRel->satuan }}, {{ $value->jumlah_lapor }} dilaporkan dan telah di-approve {{ $value->jumlah_selesai }} {{ $value->PenugasanIndukRel->satuan }}</small>
                                        <h4>Dibuat Oleh: {{ $value->PenugasanIndukRel->CreatedBy->name }}</h4>
                                        <a href="#" role="button" @click="updateProgres" data-toggle="modal" 
                                                data-id="{{ $value->id }}" data-user_nama="{{ $value->user_nama }}" data-keterangan="{{ $value->keterangan }}" 
                                                data-jumlah_target="{{ $value->jumlah_target }}" data-jumlah_selesai="{{ $value->jumlah_selesai }}" 
                                                data-tanggal_last_progress="{{ $value->tanggal_last_progress }}"
                                                data-jumlah_lapor="{{ $value->jumlah_lapor }}"
                                                data-tanggal_last_lapor="{{ $value->tanggal_last_lapor }}"
                                                data-target="#add_progres" class="btn btn-info btn-sm"> Tambah Progres </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @include('penugasan.modal_anda_progres')

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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                list_penugasan: {!! json_encode($list_penugasan) !!},
                detail_participant: {
                    penugasan_id: '',
                    user_id: '',
                    user_nip_lama: '',
                    user_nip_baru: '',
                    user_nama: '',
                    user_jabatan: '',
                    jumlah_target: '',
                    jumlah_selesai: '',
                    jumlah_lapora: '',
                    unit_kerja: '',
                    nilai_waktu: '',
                    nilai_penyelesaian: '',
                    tanggal_last_progress: '',
                    tanggal_last_lapor: '',
                    id: '',
                    index: ''
                },
            },
            computed: {
                pathname: function() {
                    return (window.location.pathname).replace("/anda", "");
                },
            },
            methods: {
                updateProgres: function (event) {
                    var self = this;
                    if (event) {
                        self.detail_participant.id = event.currentTarget.getAttribute('data-id');

                        self.detail_participant.tanggal_last_lapor = event.currentTarget.getAttribute('data-tanggal_last_lapor');
                        $('#tanggal_last_lapor').val(self.detail_participant.tanggal_last_lapor);

                        self.detail_participant.user_nama = event.currentTarget.getAttribute('data-user_nama');
                        self.detail_participant.keterangan = event.currentTarget.getAttribute('data-keterangan');
                        self.detail_participant.jumlah_target = event.currentTarget.getAttribute('data-jumlah_target');
                        self.detail_participant.jumlah_lapor = event.currentTarget.getAttribute('data-jumlah_lapor');
                    }
                },
                saveProgres: function(){
                    var self = this;
                    $('#wait_progres').modal('show');
                    //////////
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                    $.ajax({
                        url :  self.pathname + "/storeLapor",
                        method : 'post',
                        dataType: 'json',
                        data:{
                            id: self.detail_participant.id,
                            jumlah_lapor: self.detail_participant.jumlah_lapor,
                            tanggal_last_lapor: self.detail_participant.tanggal_last_lapor,
                        },
                    }).done(function (data) {
                        $('#add_progres').modal('hide');
                        $('#wait_progres').modal('hide');
                        if(data.result!='success'){
                            alert("Data gagal disimpan, mohon refresh halaman dan ulangi lagi!")
                        }
                        
                        window.location.href = self.pathname + "/anda"
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                    ///////////

                    self.detail_participant = {
                        penugasan_id: '',
                        user_id: '',
                        user_nip_lama: '',
                        user_nip_baru: '',
                        user_nama: '',
                        user_jabatan: '',
                        jumlah_target: '',
                        jumlah_selesai: '',
                        unit_kerja: '',
                        nilai_waktu: '',
                        nilai_penyelesaian: '',
                        tanggal_last_progress: '',
                        id: '',
                        index: ''
                    };
                    
                    $('#wait_progres').modal('hide');
                    $('#add_progres').modal('hide');
                },
            }
        });

        $('#tanggal_last_lapor').change(function() {
            vm.detail_participant.tanggal_last_lapor = this.value;
        });

        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });
        });
    </script>
@endsection