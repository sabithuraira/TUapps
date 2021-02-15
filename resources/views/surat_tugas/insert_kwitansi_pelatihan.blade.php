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
                    <div class="table-responsive">
                        <table class="m-b-0 table-bordered" style="min-width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nama Pelaksana</th>
                                    <th rowspan="2" class="text-center">Asal Penugasan</th>
                                    <th rowspan="2" class="text-center">Biaya Uang Harian Perjadin</th>
                                    <th rowspan="2" class="text-center">Biaya Uang Harian Fullboard</th>
                                    <th colspan="2" class="text-center">Transport (PP)</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Asal (Rp)</th>
                                    <th class="text-center">Tujuan (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_anggota as $key=>$value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->nama }}</td>
                                        @php 
                                            $uker = \App\UnitKerja::where('kode', '=', $value->unit_kerja)->first();
                                        @endphp
                                        <td>
                                            @if($uker!=null)
                                                {{ $uker->nama }}
                                            @endif
                                        </td>
                                        <td><input type="number" class="form-control form-control-sm" name="{{ 'biaya_perjadin'.$value->id }}" value="{{ $value->biaya_perjadin }}"></td>
                                        <td><input type="number" class="form-control form-control-sm" name="{{ 'biaya_fullboard'.$value->id }}" value="{{ $value->biaya_fullboard }}"></td>
                                        <td><input type="number" class="form-control form-control-sm" name="{{ 'transport_pergi'.$value->id }}" value="{{ $value->transport_pergi }}"></td>
                                        <td><input type="number" class="form-control form-control-sm" name="{{ 'tranposrt_pulang'.$value->id }}" value="{{ $value->transport_pulang }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br/>
                        <button type="submit" class="btn btn-primary pull-right">Simpan</button>
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
