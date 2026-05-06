@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('sertifikat_induk')}}">Sertifikat</a></li>
    <li class="breadcrumb-item">Detail: {{ $model->kegiatan }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Detail kegiatan</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Kegiatan:</strong> {{ $model->kegiatan }}</p>
                        <p><strong>Tanggal:</strong> {{ $model->tanggal ? $model->tanggal->format('d F Y') : '' }}</p>
                        <p><strong>Kode satker:</strong> {{ $model->kode_satker }}</p>
                        <p><strong>Klasifikasi arsip:</strong> {{ $model->klasifikasi_arsip }}</p>
                        <p><strong>No. urut (awal–akhir):</strong>
                            @if($model->nomor_urut_start !== null && $model->nomor_urut_end !== null)
                                {{ $model->nomor_urut_start }} – {{ $model->nomor_urut_end }}
                            @else
                                —
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Deskripsi:</strong></p>
                        <p>{!! nl2br(e($model->deskripsi)) !!}</p>
                    </div>
                </div>

                <hr>
                <h4>Daftar peserta</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No. urut</th>
                                <th>Nomor sertifikat</th>
                                <th>Nama peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($model->peserta as $p)
                            <tr>
                                <td class="text-center">{{ $p->nomor_urut }}</td>
                                <td>{{ $p->nomor_sertifikat }}</td>
                                <td>{{ $p->nama_peserta }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Belum ada peserta</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ action('SertifikatIndukController@edit', $id) }}" class="btn btn-info">Ubah</a>
                <a href="{{ url('sertifikat_induk') }}" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
