@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Daftar Surat Tugas</li>
</ul>
@endsection

@section('content')
    <div class="container">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div>
      @endif

      <div class="card">
        <div class="body">   
          <form action="{{url('surat_tugas')}}" method="get">
            <div class="input-group mb-3">
                    
                    @csrf
                    <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                    </div>
            </div>
          </form>
          <section class="datas">
            <div id="load" class="table-responsive">
                <table class="table-sm table-bordered m-b-0" style="min-width:100%">
                    @if (count($datas)==0)
                        <thead>
                            <tr><th>Tidak ditemukan data</th></tr>
                        </thead>
                    @else
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">Ket Surat</th>
                                <th class="text-center" rowspan="2">Pegawai</th>
                                <th class="text-center" colspan="2">Tanggal</th>
                                <th class="text-center" colspan="3">Status</th>
                            </tr>
                            
                            <tr>
                                <th class="text-center">Mulai</th>
                                <th class="text-center">Selesai</th>
                                <th class="text-center">LPD</th>
                                <th class="text-center">Kelengkapan Dok</th>
                                <th class="text-center">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                                @if ($data['status_aktif']==1)
                                <tr>
                                    <td class="text-center">
                                        <u>{{$data['nomor_st']}}</u><br/>
                                        {{$data['tujuan_tugas']}}
                                    </td>
                                    <td class="text-center">
                                        <u>{{$data['nip']}}</u><br/>
                                        {{$data['nama']}}
                                    </td>
                                    <td>{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                                    <td>{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                                    <td class="text-center">
                                        {!! $data->listStatus[$data['status_kumpul_lpd']] !!}<br/>
                                    </td>
                                    <td class="text-center">
                                        {!! $data->listStatus[$data['status_kumpul_kelengkapan']] !!}<br/>
                                    </td>
                                    <td class="text-center">
                                        {!! $data->listStatus[$data['status_pembayaran']] !!}<br/>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td class="text-center">
                                        <u>{{$data['nomor_st']}}</u><br/>
                                        {{$data['tujuan_tugas']}}
                                    </td>
                                    <td class="text-center">
                                        <u>{{$data['nip']}}</u><br/>
                                        {{$data['nama']}}
                                    </td>
                                    <td class="text-center" colspan="5">DIBATALKAN</td>
                                </tr>
                                @endif
                            @endforeach
                            
                        </tbody>
                    @endif
                </table>
                {{ $datas->links() }} 
            </div>

          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
