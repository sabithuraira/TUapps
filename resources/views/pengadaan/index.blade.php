@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Daftar Pengadaan</li>
    </ul>
@endsection

@section('content')
    <div class="container">

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif

        <div class="card" id="app_vue">
            <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon text-info"><i class="fa fa-user"></i> </div>
                                <div class="content">
                                    <div class="text">Total pengajuan</div>
                                    <h5 class="number">{{ $jumlah_pengajuan }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon text-warning"><i class="fa fa-tags"></i> </div>
                                <div class="content">
                                    <div class="text">Selesai</div>
                                    <h5 class="number">{{ $jumlah_selesai }}</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon text-danger"><i class="fa fa-frown-o"></i> </div>
                                <div class="content">
                                    <div class="text">Ditolak</div>
                                    <h5 class="number" style="font-size: 1rem">{{ $jumlah_ditolak_ppk }} PPK,
                                        {{ $jumlah_ditolak_pbj }} PBJ</h5>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <form action="{{ url('pengadaan') }}" method="get">
                    @if ($auth->hasrole('superadmin|skf'))
                        <a href="{{ url('pengadaan/create') }}" class="'btn btn-info btn-sm"><i class='fa fa-plus'></i>
                            Ajukan Pengadaan</a>
                        <button hidden name="action" type="submit" value="1"></button>
                        <br />
                        <br>
                    @endif
                    {{-- <button name="action" class="btn btn-success btn-sm float-right" type="submit" value="2"><i
                            class="fa fa-file-excel-o"></i> Unduh Excel</button>

                    <br /><br />
                    <span class="float-right small"><i>Data unduhan sesuai filter pencarian</i></span> --}}

                    @csrf

                    @if (Auth::user()->kdkab == '00')
                        <div class="row clearfix">
                            <div class="col-md-12 left">
                                <select class="form-control  form-control-sm" name="unit_kerja"
                                    onchange="this.form.submit()">
                                    @foreach (config('app.unit_kerjas') as $key => $value)
                                        <option @if ($key == old('unit_kerja', substr($unit_kerja, 2))) selected="selected" @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br />
                    @endif

                    <div class="row clearfix">
                        <div class="col-md-8 left">
                            <input type="text" class="form-control form-control-sm" name="keyword" id="keyword"
                                value="{{ $keyword }}" placeholder="Search..">
                        </div>

                        <div class="col-md-2 left">
                            <select class="form-control  form-control-sm" name="month" onchange="this.form.submit()">
                                <option value="">- Pilih Bulan -</option>
                                @foreach (config('app.months') as $key => $value)
                                    <option value="{{ $key }}"
                                        @if ($month == $key) selected="selected" @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 left">
                            <select class="form-control  form-control-sm" name="year" onchange="this.form.submit()">
                                <option value="">- Pilih Tahun -</option>
                                @for ($i = 2021; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}"
                                        @if ($year == $i) selected="selected" @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
                <br />
                <section class="datas">
                    @include('pengadaan.list')
                </section>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
