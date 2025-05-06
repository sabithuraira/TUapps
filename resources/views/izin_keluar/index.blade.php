@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Permohonan Izin Keluar</li>
</ul>
@endsection

@section('content')
    <div class="container">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card" id="app_vue">
        <div class="body">

          <div class="row clearfix">
            <div class="col-lg-6 col-md-12 left-box">
              <a href="#" role="button" v-on:click="addIzinKeluar"  class="btn btn-primary" data-toggle="modal" data-target="#add_izin_keluars"><i class="fa fa-plus-circle"></i> <span>Tambah Permohonan Izin Keluar</span></a>
            </div>

            <div class="col-lg-6 col-md-12 left-box">
              <a href="{{ url('izin_keluar/rekap') }}" class="btn btn-success float-right"><i class="fa fa-list"></i> <span>Rekap Bulanan</span></a> &nbsp;
              <a href="{{ url('izin_keluar/rekap_today') }}" class="btn btn-success float-right mx-1"><i class="fa fa-users"></i> <span>Pegawai Izin Hari Ini</span></a>
            </div>
          </div>
          <br/><br/>
          <div class="row clearfix">
                <div class="col-lg-6 col-md-12 left-box">
                    <div class="form-group">
                        <label>Bulan:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm"  v-model="month" name="month">
                                @foreach ( config('app.months') as $key=>$value)
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
                          <select class="form-control  form-control-sm" v-model="year" name="year">
                              @for ($i=2019;$i<=date('Y');$i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>

            </div>

          <section class="datas">
              @include('izin_keluar.list')
          </section>
      </div>
    </div>
  </div>
@endsection
