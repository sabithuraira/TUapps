@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_tugas')}}">Informasi Unit Kerja</a></li>                            
    <li class="breadcrumb-item">{{ $model->nama }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Informasi Unit Kerja</h2>
          </div>

          <div class="body">
              <form method="post" action="{{ action('SuratTugasController@update_unit_kerja') }}" enctype="multipart/form-data">
              @csrf
                <div id="app_vue">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['kepala_nip'] }}:</label>
                                <select class="form-control {{($errors->first('kepala_nip') ? ' parsley-error' : '')}}"  name="kepala_nip" @change="setNamaKepala($event)">
                                    @foreach ($list_pegawai as $value)
                                        <option  value="{{ $value->nip_baru }}" 
                                            @if ($value->nip_baru == old('kepala_nip', $model->kepala_nip))
                                                selected="selected"
                                            @endif>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('kepala_nip') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['ppk_nip'] }}:</label>
                                <select class="form-control {{($errors->first('ppk_nip') ? ' parsley-error' : '')}}"  name="ppk_nip" @change="setNamaPpk($event)">
                                    @foreach ($list_pegawai as $value)
                                        <option  value="{{ $value->nip_baru }}" 
                                            @if ($value->nip_baru == old('ppk_nip', $model->ppk_nip))
                                                selected="selected"
                                            @endif>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('ppk_nip') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['bendahara_nip'] }}:</label>
                                <select class="form-control {{($errors->first('bendahara_nip') ? ' parsley-error' : '')}}"  name="bendahara_nip" @change="setNamaBendahara($event)">
                                    @foreach ($list_pegawai as $value)
                                        <option  value="{{ $value->nip_baru }}" 
                                            @if ($value->nip_baru == old('bendahara_nip', $model->bendahara_nip))
                                                selected="selected"
                                            @endif>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('bendahara_nip') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['ppspm_nip'] }}:</label>
                                <select class="form-control {{($errors->first('ppspm_nip') ? ' parsley-error' : '')}}"  name="ppspm_nip" @change="setNamaPpspm($event)">
                                    @foreach ($list_pegawai as $value)
                                        <option  value="{{ $value->nip_baru }}" 
                                            @if ($value->nip_baru == old('ppspm_nip', $model->ppspm_nip))
                                                selected="selected"
                                            @endif>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('ppspm_nip') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">{{ $model->attributes()['ibu_kota'] }}
                        <div class="form-line">
                            <input class="form-control form-control-sm" type="text" name="ibu_kota" value="{{ old('ibu_kota', $model->ibu_kota) }}" placeholder="contoh: Indralaya">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ $model->attributes()['alamat_kantor'] }}:</label>
                        <textarea name="alamat_kantor" class="form-control form-control-sm {{($errors->first('alamat_kantor') ? ' parsley-error' : '')}}" rows="3" placeholder="contoh: Jl. Palembang - Prabumulih Km 33 Desa Tanjung Pering 30813 Indralaya">{{ old('alamat_kantor', $model->alamat_kantor) }}</textarea>
                        @foreach ($errors->get('alamat_kantor') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                    
                    <div class="form-group">
                        <label>{{ $model->attributes()['kontak_kantor'] }}:</label>
                        <textarea name="kontak_kantor" class="form-control form-control-sm {{($errors->first('kontak_kantor') ? ' parsley-error' : '')}}" rows="3" placeholder="contoh: Telp (0711) 581713, Faks (0711) 581713, Mailbox : bps1610@bps.go.id">{{ old('kontak_kantor', $model->kontak_kantor) }}</textarea>
                        @foreach ($errors->get('kontak_kantor') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    
                    <input type="hidden" name="kepala_nama" v-model="kepala_nama">
                    <input type="hidden" name="ppk_nama" v-model="ppk_nama">
                    <input type="hidden" name="bendahara_nama" v-model="bendahara_nama">
                    <input type="hidden" name="ppspm_nama" v-model="ppspm_nama">
                    <br>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
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
        data:  {
            list_pegawai:  {!! json_encode($list_pegawai) !!},
            kepala_nama: '', ppk_nama: '', bendahara_nama: '', ppspm_nama: ''
        },
        methods: {
            setNamaKepala: function(event){
                var self = this;
                var selected_index = event.currentTarget.selectedIndex;
                self.kepala_nama = self.list_pegawai[selected_index].name;
            },
            setNamaPpk: function(event){
                var self = this;
                var selected_index = event.currentTarget.selectedIndex;
                self.ppk_nama = self.list_pegawai[selected_index].name;
            },
            setNamaBendahara: function(event){
                var self = this;
                var selected_index = event.currentTarget.selectedIndex;
                self.bendahara_nama = self.list_pegawai[selected_index].name;
            },
            setNamaPpspm: function(event){
                var self = this;
                var selected_index = event.currentTarget.selectedIndex;
                self.ppspm_nama = self.list_pegawai[selected_index].name;
            },
        }
    });

    $(document).ready(function() {
        // vm.setNomor();
        // vm.setDatas();

        $('.datepicker').datepicker({
            startDate: 'd',
            format: 'yyyy-mm-dd',
        });
    });
    

    $(".frep").on("submit", function(){
    });
</script>
@endsection
