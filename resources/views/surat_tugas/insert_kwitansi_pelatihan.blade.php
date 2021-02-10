@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_tugas')}}">Surat Tugas</a></li>                            
    <li class="breadcrumb-item">Rincian Honor Pelatihan</li>
</ul>
@endsection

@section('content')
<div id="app_vue"> 
    <form method="post" action="{{action('SuratTugasController@store_kwitansi_pelatihan', $id)}}" enctype="multipart/form-data">
    @csrf   
        <div class="card">
            <div class="body">     
       
                <div class="row clearfix">                                
                    <div class="col-lg-12 col-md-12">
                        <h5>{{ $model_rincian->nama }}</h5>
                    </div>
                </div>                    
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="col-md-9">Nomor Surat Tugas</td>
                                <td class="col-md-3 text-right">{{ $model_rincian->nomor_st }}</td>
                            </tr>
                            <tr>
                                <td class="col-md-9">Nomor SPD</td>
                                <td class="col-md-3 text-right">{{ $model_rincian->nomor_spd }}</td>
                            </tr>
                            <tr>
                                <td class="col-md-9">Maksud Tujuan</td>
                                <td class="col-md-3 text-right">{{ $model->tugas }} ke {{ $model_rincian->tujuan_tugas }}</td>
                            </tr>
                            <tr>
                                <td class="col-md-9">Waktu</td>
                                <td class="col-md-3 text-right">
                                @if (date('n', strtotime($model_rincian->tanggal_mulai))==date('n', strtotime($model_rincian->tanggal_selesai)))
                                    {{ date('d', strtotime($model_rincian->tanggal_mulai)) }}
                                    s.d 
                                    {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                                @else
                                    {{ date('d', strtotime($model_rincian->tanggal_mulai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))] }} {{ date('Y', strtotime($model_rincian->tanggal_mulai)) }}
                                    s.d 
                                    {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}                
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-9">Lama Perjalanan</td>
                                <td class="col-md-3 text-right">
                                @php 
                                    $selisih = abs(strtotime($model_rincian->tanggal_mulai) - strtotime($model_rincian->tanggal_selesai));
                                    $selisih_hari = floor($selisih/(60*60*24));
                                @endphp
                                
                                {{ ($selisih_hari+1) }} ({{ $model_rincian->terbilang($selisih_hari+1) }}) hari<br/>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <b>Daftar Biaya</b> -
                    &nbsp <a href="#" id="add-biaya" data-toggle="modal" v-on:click="addRincian" data-target="#form_biaya">Tambah Rincian Biaya &nbsp &nbsp<i class="icon-plus text-info"></i></a>
                    <div class="table-responsive">
                        <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Rincian</th>
                                    <th class="text-center">Biaya</th>
                                    <th class="text-center">Apakah Pengeluaran Rill?</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(data, index) in rincian" :key="data.id">
                                    <td>
                                        <template v-if="is_delete(data.id)">
                                            <a :data-id="data.id" v-on:click="delData(data.id)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                                        </template>
                                        
                                        <template v-if="!is_delete(data.id)">
                                            <a :data-id="data.id" v-on:click="delDataTemp(index)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                                        </template>
                                        
                                        <a href="#" role="button" v-on:click="updateRincian" data-toggle="modal" 
                                                    :data-id="data.id" :data-index="index" :data-rincian="data.rincian" 
                                                    :data-anggaran="data.anggaran" :data-is_rill="data.is_rill"
                                                    data-target="#form_biaya"> <i class="icon-pencil"></i></a>
                                        @{{ index+1 }}
                                    </td>
                                    <td>@{{ data.rincian }}<input type="hidden" :name="'u_rincian'+data.id" v-model="data.rincian"></td>
                                    <td>@{{ data.anggaran }}<input type="hidden" :name="'u_anggaran'+data.id" v-model="data.anggaran"></td>
                                    <td>
                                    @{{ (data.is_rill==0) ? "Tidak" : "Ya" }}
                                    <input type="hidden" :name="'u_is_rill'+data.id" v-model="data.is_rill"></td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                        <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                        <input type="hidden" name="total_utama" id="total_utama" v-model="total_utama">
                    </div>
                </div>
            </div>
        </div>
    </form>                    

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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
    var vm = new Vue({
        el: "#app_vue",
        data:  {
            enc_id: {!! json_encode($id) !!},
            model_kwitansi:  {!! json_encode($model_kwitansi) !!},
            total_utama: 1,
            rincian: [],
            cur_rincian: {
                rincian: '',
                anggaran: '',
                is_rill: 0,
                id: '',
                index: ''
            },
        },
        computed: {
            pathname: function () {
                return (window.location.pathname).replace("/"+this.enc_id+"/insert_kwitansi", "");
            },
        },
        methods: {
        }
    });

    $(document).ready(function() {
    });
</script>
@endsection
