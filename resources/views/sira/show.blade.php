@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sira')}}">Kelengkapan Administrasi</a></li>                            
    <li class="breadcrumb-item">{{ $model->kode_mak }} - {{ $model->kode_akun }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix" id="app_vue">
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
                                        &nbsp;
                                        <a data-id="{{ $data_r['id'] }}"  v-on:click="delRealisasi"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                                        &nbsp
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

                                        @if($data->path_spk!='' && $data->path_spk!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_spk);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh SPK</a><br/>
                                        @endif

                                        @if($data->path_bast!='' && $data->path_bast!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_bast);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh BAST</a><br/>
                                        @endif

                                        @if($data->path_rekap_belanja!='' && $data->path_rekap_belanja!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_rekap_belanja);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Rekap Belanja</a><br/>
                                        @endif

                                        @if($data->path_laporan!='' && $data->path_laporan!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_laporan);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Laporan</a><br/>
                                        @endif

                                        @if($data->path_jadwal!='' && $data->path_jadwal!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_jadwal);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Jadwal</a><br/>
                                        @endif

                                        @if($data->path_drpp!='' && $data->path_drpp!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_drpp);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh DRPP</a><br/>
                                        @endif

                                        @if($data->path_invoice!='' && $data->path_invoice!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_invoice);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Invoice</a><br/>
                                        @endif

                                        @if($data->path_resi_pengiriman!='' && $data->path_resi_pengiriman!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_resi_pengiriman);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Resi Pengiriman</a><br/>
                                        @endif

                                        @if($data->path_npwp_rekkor!='' && $data->path_npwp_rekkor!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_npwp_rekkor);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh NPWP Rekkor</a><br/>
                                        @endif

                                        @if($data->path_tanda_terima!='' && $data->path_tanda_terima!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_tanda_terima);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Tanda Terima</a><br/>
                                        @endif

                                        @if($data->path_cv!='' && $data->path_cv!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_cv);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh CV</a><br/>
                                        @endif

                                        @if($data->path_bahan_paparan!='' && $data->path_bahan_paparan!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_bahan_paparan);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Bahan Paparan</a><br/>
                                        @endif

                                        @if($data->path_ba_pembayaran!='' && $data->path_ba_pembayaran!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_ba_pembayaran);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh BA Pembayaran</a><br/>
                                        @endif

                                        @if($data->path_spd_visum!='' && $data->path_spd_visum!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_spd_visum);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh SPD Visum</a><br/>
                                        @endif

                                        @if($data->path_presensi_uang_makan!='' && $data->path_presensi_uang_makan!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_presensi_uang_makan);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Presensi Uang Makan</a><br/>
                                        @endif

                                        @if($data->path_rincian_perjadin!='' && $data->path_rincian_perjadin!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_rincian_perjadin);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Rincian Perjadin</a><br/>
                                        @endif

                                        @if($data->path_bukti_transport!='' && $data->path_bukti_transport!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_bukti_transport);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Bukti Transport</a><br/>
                                        @endif

                                        @if($data->path_bukti_inap!='' && $data->path_bukti_inap!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_bukti_inap);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Bukti Inap</a><br/>
                                        @endif

                                        @if($data->path_lpd!='' && $data->path_lpd!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_lpd);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh LPD</a><br/>
                                        @endif

                                        @if($data->path_rekap_perjadin!='' && $data->path_rekap_perjadin!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_rekap_perjadin);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Rekap Perjadin</a><br/>
                                        @endif

                                        @if($data->path_sp_kendaraan_dinas!='' && $data->path_sp_kendaraan_dinas!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_sp_kendaraan_dinas);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh SP Kendaraan Dinas</a><br/>
                                        @endif

                                        @if($data->path_daftar_rill!='' && $data->path_daftar_rill!=null)
                                            @php 
                                                $explodeData = explode("/", $data->path_daftar_rill);
                                            @endphp 
                                            - <a href="{{ $myUrl.$explodeData[0].'/'.$explodeData[1].'/get_data' }}">Unduh Daftar Rill</a><br/>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($data->target_bukti==0)
                                            100 %
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
  <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script>
        var vm = new Vue({  
            el: "#app_vue",
            data:  {},
            methods: {
                delRealisasi: function (event) {
                    var self = this;
                    if (event) {
                        let idnya = event.currentTarget.getAttribute('data-id');
                        if (confirm('anda yakin mau menghapus data ini?')) {
                            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                            $.ajax({
                                url :  "{{ url('/sira') }}" + "/" + idnya + "/destroy_rincian",
                                method : 'post',
                                dataType: 'json',
                            }).done(function (data) {
                                window.location.reload(false); 
                            }).fail(function (msg) {
                                $('#wait_progres').modal('hide');
                            });
                        }
                    }
                },
            }
        });
    </script>
@endsection