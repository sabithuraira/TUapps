@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('log_book')}}"> LOG BOOK</a></li>
    <li class="breadcrumb-item">Rekapitulasi Detail Per Tanggal</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <form action="{{url('log_book/rekap_detail')}}" method="get">
            <div class="row clearfix">
                    @if(auth()->user()->kdkab=='00')
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-12">
                                <label>Unit Kerja:</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control form-control-sm" v-model="uker" name="uker">
                                            @foreach (config('app.unit_kerjas') as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 left-box">
                                <div class="form-group">
                                    <label>Bulan:</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-sm" v-model="month" name="month">
                                            @foreach (config('app.months') as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 right-box">
                                <div class="form-group">
                                    <label>Tahun:</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-sm" v-model="year" name="year">
                                            @for ($i=2019;$i<=date('Y');$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-12 left-box">
                                <div class="form-group">
                                    <label>Bulan:</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-sm" v-model="month" name="month">
                                            @foreach (config('app.months') as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 right-box">
                                <div class="form-group">
                                    <label>Tahun:</label>
                                    <div class="input-group">
                                        <select class="form-control form-control-sm" v-model="year" name="year">
                                            @for ($i=2019;$i<=date('Y');$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-lg-1 col-md-12 right-box">
                        <div class="form-group">
                            <label> &nbsp </label>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <p class="text-muted small m-b-15">
                @if(auth()->user()->kdkab != '00')
                    Menampilkan pegawai dengan kdkab = <strong>{{ $uker }}</strong> (unit kerja Anda).
                @else
                    Menampilkan pegawai unit kerja: <strong>{{ config('app.unit_kerjas')[$uker] ?? 'Kode ' . $uker }}</strong> (kdkab = {{ $uker }}).
                @endif
            </p>

          <section class="datas">
                <div id="load">
                    <div class="table-responsive">
                        <table class="table table-bordered m-b-0" style="min-width:100%; font-size: 0.85rem;">
                            <thead>
                                <tr class="text-center">
                                    <th style="min-width: 40px;">No</th>
                                    <th style="min-width: 180px;">Nama / NIP</th>
                                    @foreach($dates as $day)
                                    <th style="min-width: 32px;">{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $user->name }} / {{ $user->nip_baru }}</td>
                                        @foreach($dates as $day)
                                        @php
                                            $cnt = $matrix[$key][$day] ?? 0;
                                            $bg = $cnt == 0 ? 'background-color: #fff3cd;' : 'background-color: #d4edda;';
                                        @endphp
                                        <td class="text-center" style="{{ $bg }}">{{ $cnt }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($users) == 0)
                    <p class="text-center text-muted m-t-15">Tidak ada data.</p>
                    @endif
                </div>
          </section>
      </div>

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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
    var vm = new Vue({
        el: "#app_vue",
        data: {
            month: {!! json_encode($month) !!},
            year: {!! json_encode($year) !!},
            uker: {!! json_encode($uker) !!},
        },
    });
</script>
@endsection
