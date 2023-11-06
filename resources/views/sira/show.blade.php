@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sira')}}">Kelengkapan Administrasi</a></li>                            
    <li class="breadcrumb-item">{{ $model->kode_mak }} - {{ $model->kode_akun }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 left-box">
        <div class="card">
            <div class="body">
                <table class="table-bordered m-b-0" style="min-width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center">{{ $model->attributes()['mak'] }}</th>
                            <th class="text-center">{{ $model->attributes()['akun'] }}</th>
                            <th class="text-center">{{ $model->attributes()['tahun'] }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                {{ $model['kode_mak'] }}<br/>
                                <span class="text-muted">{{ $model['mak'] }}</span>
                            </td>
                            <td>
                                {{ $model['kode_akun'] }}<br/>
                                <span class="text-muted">{{ $model['akun'] }}</span>
                            </td>
                            <td class="text-center">{{$model['tahun']}}</td>
                        </tr>
                    </tbody>
                </table>

                <br/>
                
                <table class="table-bordered m-b-0" style="min-width:100%;">
                    @if (count($rincian)==0)
                        <thead>
                            <tr><th>Tidak ditemukan data</th></tr>
                        </thead>
                    @else
                        <thead>
                            <tr>
                                <th class="text-center">{{ $rincian[0]->attributes()['kode_fungsi'] }}</th>
                                <th class="text-center">Bukti Administrasi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($rincian as $data)
                                <tr>
                                    <td>{{ $data->listFungsi[$data->kode_fungsi] }}</td>
                                    <td>
                                        @if($data->path_kak!='' && $data->path_kak!=null)
                                            - <a href="{{ $myUrl.$data->path_kak }}">Unduh KAK</a><br/>
                                        @endif 

                                        @if($data->path_form_permintaan!='' && $data->path_form_permintaan!=null)
                                            - <a href="{{ $myUrl.$data->path_form_permintaan }}">Unduh Form Permintaan</a><br/>
                                        @endif 

                                        @if($data->path_notdin!='' && $data->path_notdin!=null)
                                            - <a href="{{ $myUrl.$data->path_notdin }}">Unduh Nota Dinas</a><br/>
                                        @endif 

                                        @if($data->path_undangan!='' && $data->path_undangan!=null)
                                            - <a href="{{ $myUrl.$data->path_undangan }}">Unduh Undangan</a><br/>
                                        @endif 

                                        @if($data->path_bukti_pembayaran!='' && $data->path_bukti_pembayaran!=null)
                                            - <a href="{{ $myUrl.$data->path_bukti_pembayaran }}">Unduh Bukti Pembayaran</a><br/>
                                        @endif

                                        @if($data->path_kuitansi!='' && $data->path_kuitansi!=null)
                                            - <a href="{{ $myUrl.$data->path_kuitansi }}">Unduh Kuitansi</a><br/>
                                        @endif

                                        @if($data->path_notulen!='' && $data->path_notulen!=null)
                                            - <a href="{{ $myUrl.$data->path_notulen }}">Unduh Notulen</a><br/>
                                        @endif

                                        @if($data->path_daftar_hadir!='' && $data->path_daftar_hadir!=null)
                                            - <a href="{{ $myUrl.$data->path_daftar_hadir }}">Unduh Daftar Hadir</a><br/>
                                        @endif

                                        @if($data->path_sk!='' && $data->path_sk!=null)
                                            - <a href="{{ $myUrl.$data->path_sk }}">Unduh SK</a><br/>
                                        @endif

                                        @if($data->path_st!='' && $data->path_st!=null)
                                            - <a href="{{ $myUrl.$data->path_st }}">Unduh Surat Tugas</a><br/>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')
        <meta name="_token" content="{{csrf_token()}}" />
@endsection

@section('scripts')

@endsection