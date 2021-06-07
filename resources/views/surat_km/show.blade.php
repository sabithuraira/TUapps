@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_km')}}">Surat</a></li>                            
    <li class="breadcrumb-item">Detail Surat - {{ $model->nomor }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix" id="app_vue">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ $model->attributes()['jenis_surat'] }}:</label>
                            <select disabled class="form-control {{($errors->first('jenis_surat') ? ' parsley-error' : '')}}" v-model="jenis_surat" name="jenis_surat" @change="setNomor">
                                <option value="">- Pilih Jenis Surat -</option>
                                @foreach ($model->listJenis as $key=>$value)
                                    <option value="{{ $key }}" 
                                        @if ($key == old('jenis_surat', $model->jenis_surat))
                                            selected="selected"
                                        @endif >{{ $value }}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('jenis_surat') as $msg)
                                <p class="text-danger">{{ $msg }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <template v-if="jenis_surat==1">
                    @include('surat_km._show_surat_masuk')
                </template>
                
                <template v-if="jenis_surat==2">
                    @include('surat_km._show_surat_keluar')
                </template>
                
                <template v-if="jenis_surat==3">
                    @include('surat_km._show_memorandum')
                </template>
                
                <template v-if="jenis_surat==4">
                    @include('surat_km._show_surat_pengantar')
                </template>
                
                <template v-if="jenis_surat==5">
                    @include('surat_km._show_disposisi')
                </template>
                
                <template v-if="jenis_surat==6">
                    @include('surat_km._show_surat_keputusan')
                </template>
                
                <template v-if="jenis_surat==7">
                    @include('surat_km._show_surat_keterangan')
                </template>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({
    el: "#app_vue",
    data:  {
        jenis_surat: {!! json_encode($model->jenis_surat) !!},
        kode_unit_kerja: '',
        klasifikasi_arsip: '',
        tingkat_keamanan: '',
        tanggal: {!! json_encode(date('m/d/Y', strtotime($model->tanggal))) !!},
        nomor_urut: {!! json_encode($model->nomor_urut) !!},
        tembusan: [],
        keputusan: [],
        pathname : (window.location.pathname).replace("/create", ""),
        list_angka_keputusan: [
            "KESATU", "KEDUA", "KETIGA", "KEEMPAT", "KELIMA", "KEENAM", "KETUJUH", "KEDELAPAN", 
            "KESEMBILAN", "KESEPULUH", "KESEBELAS", "KEDUA BELAS", "KETIGA BELAS", "KEEMPAT BELAS",
            "KELIMA BELAS", "KEENAM BELAS", "KETUJUH BELAS", "KEDELAPAN BELAS", "KESEMBILAN BELAS", "KEDUA PULUH"
        ]
    },
    computed: {
        bulan: function () {
            var split_tanggal = this.tanggal.split("/");
            if(split_tanggal.length==0) return "";
            else return split_tanggal[0]
        },
        tahun: function () {
            var split_tanggal = this.tanggal.split("/");
            if(split_tanggal.length==0) return "";
            else return split_tanggal[2]
        },
    },
    methods: {
    }
});

$(document).ready(function() {
});

</script>
@endsection
