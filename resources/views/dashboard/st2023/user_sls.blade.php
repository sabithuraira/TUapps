@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    <style>
        .c3-axis-x text {
            font-size: 10px;
        }
    </style>
    <div class="container" id="app_vue">
        <div class="">
            <div class="card">
                <div class="body profilepage_2 blog-page pb-0">
                    <b>User/Petugas ST 2023 </b>
                    <div class="alert alert-info mt-1" role="alert">
                        List SLS Petugas {{ $id }}
                    </div>
                    {{-- <button class="btn btn-info float-right" data-toggle="modal" data-target="#modal_import">Import
                        Petugas</button> --}}
                </div>
                <br>
                <div class="m-1">
                    <table class="table table-bordered table-sm ">
                        <thead>
                            <tr class="text-center table-secondary">
                                <th>No</th>
                                <th>Kab</th>
                                <th>Kec</th>
                                <th>Desa</th>
                                <th>SLS</th>
                                <th>SubSLS</th>
                                <th>Status <br> Selesai</th>
                                <th>Perkiraan Ruta Regsosek</th>
                                <th>Ruta Pendataan</th>
                            </tr>
                        </thead>
                        @if ($data)
                            @foreach ($data as $index => $dt)
                                <tbody>
                                    <tr class="text-center">
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $dt['kode_kab'] }}</td>
                                        <td>{{ $dt['kode_kec'] }}</td>
                                        <td>{{ $dt['kode_desa'] }}</td>
                                        <td> <a
                                                href="{{ url('dashboard/index?kab_filter=' . $dt['kode_kab'] . '&kec_filter=' . $dt['kode_kec'] . '&desa_filter=' . $dt['kode_desa'] . '&sls_filter=' . $dt['id_sls']) }}">{{ $dt['id_sls'] }}</a>
                                        </td>
                                        <td>{{ $dt['id_sub_sls'] }}</td>
                                        <td>{{ $dt['status_selesai_pcl'] }}</td>
                                        <td>{{ $dt['jml_keluarga_tani'] }}</td>
                                        <td>{{ $dt['jumlah_ruta'] }}</td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="9">Belum Ada Data</td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                    <ul class="pagination pagination-primary">
                        @foreach ($links as $lk)
                            <li class="page-item @if ($lk['active']) active @endif">
                                <a class="page-link" href="{{ $lk['url'] }}"> {{ $lk['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>


    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script>
        var vm = new Vue({
            el: "#app_vue"
        });
    </script>
@endsection
