@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('meeting')}}">Rapat/Pertemuan</a></li>                            
    <li class="breadcrumb-item">{{ $model->judul }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
            @if($model->is_secret==1)
                <span v-if="e_is_secret==1" class="badge badge-danger mb-2">RAHASIA</span>
            @endif
          <div class="header">
              <h2>{{ $model->judul }} - <span class="badge badge-info mb-2">{{ date('d M Y H:i', strtotime($model->waktu_mulai)) }} s/d {{ date('d M Y H:i', strtotime($model->waktu_selesai)) }}</span></h2> 
          </div>
          <div id="app_vue">
            <ul class="nav nav-tabs-new2">
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#data">Data</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#peserta">Peserta</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane show active" id="data">
                    <div class="form-group">
                        <label>{{ $model->attributes()['deskripsi']}}:</label>
                        {!! $model->deskripsi !!}
                    </div>

                    <hr/>                        
                    <div class="form-group">
                        <label>{{ $model->attributes()['notulen']}}:</label>
                        {!! $model->notulen !!}
                    </div>

                    <hr/>
                    <div class="form-group">
                        <label>{{ $model->attributes()['keterangan']}}:</label>
                        {!! $model->keterangan !!}
                    </div>

                </div>
                <div class="tab-pane" id="peserta">
                    <label>Peserta Meeting</label>
                        
                    <table class="table table-sm m-b-0 table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in rincian_peserta" :key="data.id">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ data.name }}</td>
                                <td>@{{ data.nip_baru }}</td>
                                <td>@{{ data.nmjab }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        
</div>
      </div>
  </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                rincian_peserta: {!! json_encode($rincian_peserta) !!},
                kab_peserta:  {!! json_encode($kd_kab) !!},
            },
            methods: {
               
            }
        });
    </script>
@endsection