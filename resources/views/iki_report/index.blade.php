@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">IKI Pegawai</li>
    </ul>
@endsection

@section('content')
    <div id="app_vue">
        <div class="container">
            <br />
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div><br />
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>
                </div><br />
            @endif

            <div class="card">
                <div class="body">
                    <form action="{{ url('iki_report') }}" method="get">
                        <div class="row px-2">
                            <div class="col-2">
                                <label for="" class="label">Tahun</label>
                                <select name="tahun" id="tahun_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    {{-- <option value="">Semua</option> --}}
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 2022; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}"
                                            @if ($request->tahun == $i) selected="selected" @endif>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Bulan</label>
                                <select name="bulan" id="bulan_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    <option value="" selected>Pilih Bulan</option>
                                    @foreach ($model->namaBulan as $g => $bln)
                                        <option value="{{ ++$g }}"
                                            @if ($request->bulan == $g) selected @endif>{{ $bln }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                @if (!$request->bulan)
                                    <i>*Silahkan Pilih Bulan untuk melihat</i>
                                @endif

                            </div>
                        </div>
                    </form>
                    <br>
                    @if ($request->bulan)
                        <h4>Iki Pegawai Di Bulan {{ $model->namaBulan[$request->bulan - 1] }} </h4>
                    @endif
                    <div class="row px-2">
                        <div class="col table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>IKI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_iki)
                                        @foreach ($data_iki as $i => $dt_iki)
                                            <tr>
                                                <td>
                                                    {{ ++$i }}
                                                </td>
                                                <td>
                                                    {{ $dt_iki->name }}
                                                </td>
                                                <td>
                                                    {{ sizeof($dt_iki->iki) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @if ($request->tahun && $request->bulan)
                                            <tr>
                                                <td colspan="4">
                                                    pegawai belum mengisi iki bulan
                                                </td>
                                            </tr>
                                        @else
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br>
                    @if ($request->bulan)
                        <h4>Pegawai Belum ada IKI Di Bulan {{ $model->namaBulan[$request->bulan - 1] }} </h4>
                    @endif
                    <div class="row px-2">
                        <div class="col table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_iki)
                                        @foreach ($data_tidak_iki as $i => $dt_tdk_iki)
                                            <tr>
                                                <td>
                                                    {{ ++$i }}
                                                </td>
                                                <td>
                                                    {{ $dt_tdk_iki->name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                Semua pegawai sudah ada iki
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('css')
        <meta name="_token" content="{{ csrf_token() }}" />
        <meta name="csrf-token" content="@csrf">
        <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
        <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
    @endsection

    @section('scripts')
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
        <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
        <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
        <script>
            var vm = new Vue({
                el: "#app_vue",
                data: {},
                methods: {}
            });
        </script>
    @endsection
