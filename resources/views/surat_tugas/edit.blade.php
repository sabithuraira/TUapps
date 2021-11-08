@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_tugas')}}">Surat Tugas</a></li>                            
    <li class="breadcrumb-item">{{ $model_rincian->nomor_st }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Perbaharui Surat Tugas</h2>
          </div>

          <div class="body">
              <form method="post" id="form_data" action="{{action('SuratTugasController@update', $id)}}" enctype="multipart/form-data">
              @csrf
                <input name="_method" type="hidden" value="PATCH">
                <div id="app_vue">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['jenis_st'] }}:</label>
                                <select class="form-control {{($errors->first('jenis_st') ? ' parsley-error' : '')}}"  name="jenis_st">
                                    @foreach ($model->listJenis as $key=>$value)
                                        <option  value="{{ $key }}" 
                                            @if ($key == old('jenis_st', $model->jenis_st))
                                                selected="selected"
                                            @endif>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('jenis_st') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['sumber_anggaran'] }}:</label>
                                <select class="form-control {{($errors->first('sumber_anggaran') ? ' parsley-error' : '')}}"  name="sumber_anggaran" v-model="sumber_anggaran" @change="setSumberAnggaran($event)">
                                    @foreach ($model->listSumberAnggaran as $key=>$value)
                                        <option  value="{{ $key }}" 
                                            @if ($key == old('sumber_anggaran', $model->sumber_anggaran))
                                                selected="selected"
                                            @endif>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach ($errors->get('sumber_anggaran') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ $model->attributes()['mak'] }}:</label>
                        <select class="form-control {{($errors->first('mak') ? ' parsley-error' : '')}}" id="mak" name="mak" v-model="mak" :disabled="sumber_anggaran==3">
                            <option v-for="(value, index) in list_select_anggaran" :value="value.id">
                                @{{ value.kode_program }}.@{{ value.kode_ro }}.@{{ value.kode_komponen }}.@{{ value.kode_subkomponen }} - @{{ value.label_ro }}
                            </option>
                        </select>
                        @foreach ($errors->get('mak') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label>{{ $model->attributes()['tugas'] }}:</label>
                        <textarea name="tugas" class="form-control form-control-sm {{($errors->first('tugas') ? ' parsley-error' : '')}}" rows="5">{{ old('tugas', $model->tugas) }}</textarea>
                        @foreach ($errors->get('tugas') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    <hr/>
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">Pegawai:
                                <div class="form-line">
                                    @if($model_rincian->jenis_petugas==1)
                                    <select disabled  class="form-control" name="nip" @change="setNamaJabatan($event)">
                                        @foreach ($list_pegawai as $value)
                                            <option value="{{ $value->nip_baru }}" 
                                                @if ($value->nip_baru == old('nip', $model_rincian->nip))
                                                    selected="selected"
                                                @endif>
                                            {{ $value->name }} - {{ $value->nip_baru }} </option>
                                        @endforeach
                                    </select>
                                    @else
                                        <input disabled class="form-control form-control-sm" type="text" name="nama" value="{{ old('nama', $model_rincian->nama) }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">{{ $model_rincian->attributes()['pejabat_ttd_nip'] }}
                                <div class="form-line">
                                    <select disabled class="form-control" name="pejabat_ttd_nip" @change="setPejabat($event)">
                                        @foreach ($list_pejabat as $value)
                                            <option value="{{ $value->nip_baru }}"
                                                @if ($value->nip_baru == old('pejabat_ttd_nip', $model_rincian->pejabat_ttd_nip))
                                                        selected="selected"
                                                    @endif>
                                            {{ $value->name }} - {{ $value->nip_baru }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">{{ $model_rincian->attributes()['tujuan_tugas'] }}
                        <div class="form-line">
                            <input  class="form-control form-control-sm" type="text" name="tujuan_tugas" value="{{ old('tujuan_tugas', $model_rincian->tujuan_tugas) }}">
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">{{ $model_rincian->attributes()['tanggal_mulai'] }}
                                <div class="form-line">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker form-control-sm" name="tanggal_mulai" id="rincian_tanggal_mulai" value="{{ old('tanggal_mulai', $model_rincian->tanggal_mulai) }}">
                                        <div class="input-group-append">                                            
                                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">{{ $model_rincian->attributes()['tanggal_selesai'] }}
                                <div class="form-line">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker form-control-sm" name="tanggal_selesai" id="rincian_tanggal_selesai" value="{{ old('tanggal_selesai', $model_rincian->tanggal_selesai) }}">
                                        <div class="input-group-append">                                            
                                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-6">
                            {{ $model_rincian->attributes()['tingkat_biaya'] }}
                            <div class="form-line">
                                <select class="form-control" name="tingkat_biaya">
                                    @foreach ($model_rincian->listTingkatBiaya as $key=>$value)
                                        <option value="{{ $key }}" 
                                            @if ($key == old('tingkat_biaya', $model_rincian->tingkat_biaya))
                                                        selected="selected"
                                                    @endif>
                                        {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            {{ $model_rincian->attributes()['kendaraan'] }}
                            <div class="form-line">
                                <select class="form-control" name="kendaraan">
                                    @foreach ($model_rincian->listKendaraan as $key=>$value)
                                        <option value="{{ $key }}"
                                            @if ($key == old('kendaraan', $model_rincian->kendaraan))
                                                        selected="selected"
                                                    @endif>
                                        {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group">Tanggal Pembuatan/Tanda Tangan
                                <div class="form-line">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker form-control-sm" name="created_at" id="created_at" value="{{ old('created_at', date('Y-m-d',strtotime($model_rincian->created_at))) }}">
                                        <div class="input-group-append">                                            
                                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="nama" v-model="nama">
                    <input type="hidden" name="jabatan" v-model="jabatan">
                    <input type="hidden" name="pejabat_ttd_nama" v-model="pejabat_ttd_nama">
                    <input type="hidden" name="pejabat_ttd_jabatan" v-model="pejabat_ttd_jabatan">
                    <input type="hidden" name="unit_kerja_ttd" v-model="unit_kerja_ttd">

                    <br>
                    <button type="button" class="btn btn-primary" @click="simpan">Simpan</button>

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

              </form>
          </div>
      </div>
  </div>
</div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
    var vm = new Vue({
        el: "#app_vue",
        data:  {
            enc_id: {!! json_encode($id) !!},
            real_id: {!! json_encode($model_rincian->id) !!},
            jenis_st: {!! json_encode($model->jenis_st) !!},
            sumber_anggaran:  {!! json_encode($model->sumber_anggaran) !!},
            jenis_petugas:  {!! json_encode($model_rincian->jenis_petugas) !!},
            mak: {!! json_encode($model->mak) !!},
            kode_mak:  {!! json_encode($model->kode_mak) !!}, 
            tugas:  {!! json_encode($model->tugas) !!}, 
            unit_kerja:  {!! json_encode($model->unit_kerja) !!},
            list_tingkat_biaya:  {!! json_encode($model_rincian->listTingkatBiaya) !!},
            list_kendaraan:  {!! json_encode($model_rincian->listKendaraan) !!},
            list_select_anggaran: {!! json_encode($list_anggaran) !!},
            list_pegawai:  {!! json_encode($list_pegawai) !!},
            list_pejabat:  {!! json_encode($list_pejabat) !!},
            list_anggaran:  {!! json_encode($list_anggaran) !!},
            list_anggaran_prov:  {!! json_encode($list_anggaran_prov) !!},
            nama: '', jabatan: '', pejabat_ttd_nama: '',
            pejabat_ttd_jabatan: '', unit_kerja_ttd: '',
            rincian_nip: {!! json_encode($model_rincian->nip) !!},
        },
        computed: {
            pathname: function () {
                return (window.location.pathname).replace("/"+ this.enc_id + "/edit", "")
            }
        },
        methods: {
            setNamaJabatan: function(event){
                var self = this;
                $('#wait_progres').modal('show');
                var selected_index = event.currentTarget.selectedIndex;
                self.nama = self.list_pegawai[selected_index].name;
                self.jabatan = self.list_pegawai[selected_index].nmjab;
                $('#wait_progres').modal('hide');
            },
            setPejabat: function(event){
                var self = this;
                $('#wait_progres').modal('show');
                var selected_index = event.currentTarget.selectedIndex;
                self.pejabat_ttd_nama = self.list_pejabat[selected_index].name;
                self.pejabat_ttd_jabatan = self.list_pejabat[selected_index].nmjab;
                self.unit_kerja_ttd = self.list_pejabat[selected_index].kdprop+self.list_pejabat[selected_index].kdkab;
                $('#wait_progres').modal('hide');
            },
            setSumberAnggaran: function(event){
                var self = this;
                var value =  event.currentTarget.value;
                if(value==1) self.list_select_anggaran = self.list_anggaran;
                else if(value==2) self.list_select_anggaran = self.list_anggaran_prov;
                else if(value==3) self.list_select_anggaran = null;
            },
            simpan(){
                var self = this;
                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                if(self.jenis_petugas==1){
                    if(self.jenis_st!=4){
                        var tanggal_mulai = $("#rincian_tanggal_mulai").val();
                        var tanggal_selesai = $("#rincian_tanggal_selesai").val();
                        $.ajax({
                            url :  self.pathname + "/is_available",
                            method : 'post',
                            dataType: 'json',
                            data:{
                                nip: self.rincian_nip,
                                t_start: tanggal_mulai,
                                t_end: tanggal_selesai,
                                cur_id: self.real_id,
                            },
                        }).done(function (data) {
                            if(data.response==1){
                                if(data.result[0].total==0) $("#form_data").submit()
                                else alert("Tidak dapat DL pada tanggal tersebut karena telah melakukan DL atau CUTI")
                            }
                            else{
                                alert("Isian belum lengkap atau terjadi kesalahan, silahkan ulangi lagi!")
                            }
                            
                            $('#wait_progres').modal('hide');
                        }).fail(function (msg) {
                            console.log(JSON.stringify(msg));
                            $('#form_rincian').modal('hide');
                        });
                    }
                    else{  $("#form_data").submit() }
                }
                else{  $("#form_data").submit() }
                
                ///////////////////////
            },
        }
    });

    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    });
    
</script>
@endsection
