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
                <a href="{{ action('SiraController@create_realisasi', $id) }}" class="btn btn-info">Tambah Realisasi</a>
                <br/><br/>
                <table class="table-bordered m-b-0" style="min-width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center">{{ $model->attributes()['mak'] }}</th>
                            <th class="text-center">{{ $model->attributes()['akun'] }}</th>
                            <th class="text-center">{{ $model->attributes()['tahun'] }}</th>
                            <th class="text-center">{{ $model->attributes()['pagu'] }}</th>
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
                            <td class="text-center">Rp. {{ number_format($model['pagu']) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>REALISASI</b></td>
                        </tr>

                        @if (count($realisasi)==0)
                            <tr><th>Tidak ditemukan data realisasi</th></tr>
                        @else
                            @php 
                                $sisa_pagu = $model->pagu;
                            @endphp 
                            @foreach($realisasi as $data_r)
                                @php 
                                    $sisa_pagu -= $data_r->realisasi;
                                @endphp 
                                <tr>
                                    <td>
                                        <a href="{{action('SiraController@edit_realisasi', $data_r['id'])}}"><i class="icon-pencil text-info"></i></a>
                                        &nbsp;&nbsp; {{ $data_r->listFungsi[$data_r->kode_fungsi] }}
                                    </td>
                                    <td colspan="2">{{ $data_r->keterangan }}</td>
                                    <td class="text-center">Rp. {{ number_format($data_r->realisasi) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="3">SISA PAGU</th>
                                <th class="text-center">Rp. {{ number_format($sisa_pagu) }}</th>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <br/>
                
                <table class="table-bordered m-b-0" style="min-width:100%;">
                    @if (count($rincian)==0)
                        <thead>
                            <tr><th>Tidak ditemukan data bukti administrasi</th></tr>
                        </thead>
                    @else
                        <thead>
                            <tr>
                                <th class="text-center">{{ $rincian[0]->attributes()['kode_fungsi'] }}</th>
                                <th class="text-center">Bukti Administrasi</th>
                                <th class="text-center">Persentase Kelengkapan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($rincian as $data)
                                <tr>
                                    <td>{{ $data->listFungsi[$data->kode_fungsi] }}</td>
                                    <td>
                                        @if($data->path_kak!='' && $data->path_kak!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_kak);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh KAK</a><br/>
                                        @endif 

                                        @if($data->path_form_permintaan!='' && $data->path_form_permintaan!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_form_permintaan);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Form Permintaan</a><br/>
                                        @endif 

                                        @if($data->path_notdin!='' && $data->path_notdin!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_notdin);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Nota Dinas</a><br/>
                                        @endif 

                                        @if($data->path_undangan!='' && $data->path_undangan!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_undangan);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Undangan</a><br/>
                                        @endif 

                                        @if($data->path_bukti_pembayaran!='' && $data->path_bukti_pembayaran!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_bukti_pembayaran);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Bukti Pembayaran</a><br/>
                                        @endif

                                        @if($data->path_kuitansi!='' && $data->path_kuitansi!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_kuitansi);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Kuitansi</a><br/>
                                        @endif

                                        @if($data->path_notulen!='' && $data->path_notulen!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_notulen);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Notulen</a><br/>
                                        @endif

                                        @if($data->path_daftar_hadir!='' && $data->path_daftar_hadir!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_daftar_hadir);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Daftar Hadir</a><br/>
                                        @endif

                                        @if($data->path_sk!='' && $data->path_sk!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_sk);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh SK</a><br/>
                                        @endif

                                        @if($data->path_st!='' && $data->path_st!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_st);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Surat Tugas</a><br/>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($data->target_bukti==0)
                                            0%
                                        @else 
                                            {{ round($data->realisasi_bukti/$data->target_bukti*100,2) }}%
                                        @endif
                                        ({{ $data->realisasi_bukti }} dari {{ $data->target_bukti }}) bukti
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