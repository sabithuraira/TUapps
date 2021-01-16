@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_tugas')}}">Surat Tugas</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div id="app_vue"> 
    <form method="post" action="{{action('SuratTugasController@store_kwitansi', $id)}}" enctype="multipart/form-data">
    @csrf   
        <div class="card">
            <div class="body">     
       
                <div class="row clearfix">                                
                    <div class="col-lg-12 col-md-12">
                        <h5>{{ $model_rincian->nama }}</h5>
                        <p>{{ $model_rincian->nip }}</p>
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
                    &nbsp <a href="#" id="add-biaya" data-toggle="modal" data-target="#form_biaya">Tambah Rincian Biaya &nbsp &nbsp<i class="icon-plus text-info"></i></a>
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
                                        
                                        <a href="#" role="button" v-on:click="updateRincian" data-toggle="modal" 
                                                    :data-id="data.id" :data-index="index" :data-rincian="data.rincian" 
                                                    :data-anggaran="data.anggaran" :data-is_rill="data.is_rill"
                                                    data-target="#form_rincian"> <i class="icon-pencil"></i></a>
                                        
                                        <template v-if="!is_delete(data.id)">
                                            <a :data-id="data.id" v-on:click="delDataTemp(index)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                                        </template>
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

    <div class="modal" id="form_biaya" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="title" id="defaultModalLabel">Rincian Biaya</b>
                </div>
                <div class="modal-body">
                    <div class="form-group">Rincian
                        <div class="form-line">
                            <input class="form-control form-control-sm" type="text" placeholder="contoh: Biaya Transport dari Kota Palembang Ke Kabupaten Lahat PP" v-model="cur_rincian.rincian">
                        </div>
                    </div>
                    
                    <div class="form-group">Anggaran
                        <div class="form-line">
                            <input class="form-control form-control-sm" type="text" placeholder="contoh: 120000 (tanpa koma atau titik)" v-model="cur_rincian.anggaran">
                        </div>
                    </div>
                    
                    <div class="form-group">Apakah pengeluaran rill?
                        <div class="form-line">
                            <select class="form-control" v-model="cur_rincian.is_rill">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="saveRincian" >SAVE</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
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
            pathname :(window.location.pathname).replace("/create", ""),
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
        methods: {
            is_delete: function(params){
                if(isNaN(params)) return false;
                else return true;
            },
            saveRincian: function(){
                var self = this;

                var is_error = 0
                var pesan_error = []

                if(self.cur_rincian.rincian==''){
                    is_error = 1
                    pesan_error.push("Isian rincian wajib diisi")
                }
                
                if(self.cur_rincian.anggaran==''){
                    is_error = 1
                    pesan_error.push("Anggaran rincian wajib diisi")
                }
                else{
                    if(isNaN(self.cur_rincian.anggaran)){
                        is_error = 1
                        pesan_error.push("Anggaran harus berupa angka")
                    }
                }
                
                if(is_error==0){
                    if(self.cur_rincian.id){
                        self.rincian[self.cur_rincian.index] = {
                            'id': self.cur_rincian.id,
                            'rincian'   : self.cur_rincian.rincian,
                            'anggaran'   : self.cur_rincian.anggaran,
                            'is_rill'   : self.cur_rincian.is_rill,
                        };
                    }
                    else{
                        self.rincian.push({
                            'id': 'au'+(self.total_utama),
                            'rincian'   : self.cur_rincian.rincian,
                            'anggaran'   : self.cur_rincian.anggaran,
                            'is_rill'   : self.cur_rincian.is_rill,
                        });
                        self.total_utama++;
                    }

                    self.cur_rincian.rincian = '';
                    self.cur_rincian.anggaran = '';
                    self.cur_rincian.is_rill = 0;
                    self.cur_rincian.id = '';                   
                    $('#form_biaya').modal('hide');
                }
                else{
                    alert(pesan_error.join("\n"))
                }
                
                //////////
            },
            updateRincian: function (event) {
                var self = this;
                if (event) {
                    self.cur_rincian.id = event.currentTarget.getAttribute('data-id');
                    self.cur_rincian.index = event.currentTarget.getAttribute('data-index');
                    self.cur_rincian.rincian = event.currentTarget.getAttribute('data-rincian');
                    self.cur_rincian.anggaran = event.currentTarget.getAttribute('data-anggaran');
                    self.cur_rincian.is_rill = event.currentTarget.getAttribute('data-is_rill');
                }
            },
            delDataTemp: function (index) {
                var self = this;
                $('#wait_progres').modal('show');
                self.rincian.splice(index, 1);
                self.total_utama--;
                $('#wait_progres').modal('hide');
            },
        }
    });

    $(document).ready(function() {
        // vm.setNomor();
        // vm.setDatas();
    });
</script>
@endsection
