@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Profile {{ $model->name }}</li>
    </ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12">
                <div class="card member-card">
                    <div class="header bg-info">
                        <h4 class="m-t-10 text-light">{{ $model->name }}</h4>
                    </div>
                    <div class="member-img">
                        <a href="javascript:void(0);"><img src="{{ $model->fotoUrl }}" class="rounded-circle"
                                alt="profile-image"></a>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-5 text-left">NIP</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nip_baru }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">NIP Lama</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->email }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Unit Kerja</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">BPS {{ $unit_kerja->nama }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Organisasi Unit Kerja</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nmorg }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Jabatan / Gol</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nmjab }} / {{ $model->nmgol }}</div>
                        </div>

                        <div class="row">
                            <div class="col-5 text-left">Wilayah</div>
                            <div class="col-1">:</div>
                            <div class="col-6 text-left">{{ $model->nmwil }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Tahun {{ date('Y') }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5>{{ $model->getJumlahDl() }}</h5>
                                <small>Hari DL</small>
                            </div>
                            <div class="col-4">
                                <h5>---</h5>
                                <small>Hari Cuti</small>
                            </div>
                            <div class="col-4">
                                <h5>---</h5>
                                <small>Hari Lembur</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Nilai CKP Bulanan 2021</h2>
                    </div>
                    <div class="body">
                        <div id="line-chart" class="ct-chart"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="body">
                        <b>Daftar Aktivitas Surat Tugas</b>
                        <table class="table-sm table-bordered" style="min-width:100%">
                            @if (count($data_st) == 0)
                                <thead>
                                    <tr>
                                        <th>Tidak ditemukan data</th>
                                    </tr>
                                </thead>
                            @else
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2"><small>Ket Surat</small></th>
                                        <th class="text-center" colspan="2"><small>Tanggal</small></th>
                                        <th class="text-center" rowspan="2"><small>Status</small></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center"><small>Mulai</small></th>
                                        <th class="text-center"><small>Selesai</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_st as $data)
                                        <tr>
                                            <td class="text-center">
                                                <small>
                                                    <u>{{ $data['nomor_st'] }}</u><br />
                                                    {{ $data->SuratIndukRel->tugas }}<br />
                                                    {{ $data['tujuan_tugas'] }}
                                                </small>
                                            </td>
                                            <td><small>{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</small></td>
                                            <td><small>{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</small>
                                            </td>
                                            <td class="text-center">
                                                <small>{!! $data->listStatus[$data['status_aktif']] !!}</small>
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
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="mt-3 text-center">
                        <h4 class="m-0">Riwayat Penugasan Pegawai</h4>
                    </div>
                    <div class="body">
                        <table class="table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SK</th>
                                    <th>TMT</th>
                                    <th>Jabatan</th>
                                    <th>Fungsi</th>
                                    <th>Satker</th>
                                    <th>Penugasan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat_sk as $i => $row)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td class="text-left">{{ $row->nosk }}</td>
                                        <td class="text-left" style="white-space: nowrap">{{ $row->tmt }}</td>
                                        <td class="text-left">{{ $row->nmstjab }}</td>
                                        <td class="text-left">{{ $row->nmorg }}</td>
                                        <td class="text-left">{{ $row->nmwil }}</td>
                                        <td class="text-left">{{ $row->penugasan }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist/css/chartist.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') !!}">
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
    <script src="{!! asset('assets/bundles/chartist.bundle.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/chartist/polar_area_chart.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {
                series_ckp: {!! json_encode($result_ckp) !!}
            },
            methods: {
                setChart() {
                    var self = this;
                    options = {
                        height: "300px",
                        axisX: {
                            showGrid: false
                        },
                        low: 0,
                        high: 100,
                        plugins: [
                            Chartist.plugins.tooltip(),
                        ]
                    };

                    var data_ckp = {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                            'Dec'
                        ],
                        series: [self.series_ckp, ]
                    };


                    new Chartist.Line('#line-chart', data_ckp, options);
                },
            }
        });


        $(document).ready(function() {
            vm.setChart();
        });
    </script>
@endsection
