@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('surat_tugas')}}">Surat Tugas</a></li>                            
    <li class="breadcrumb-item">Tambah Data Tim</li>
</ul>
@endsection

@section('content')
<div class="row clearfix" id="app_vue">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Surat Tugas Tim</h2>
          </div>
          <div class="body">
              <form method="post" class="frep" action="{{url('surat_tugas/create_tim')}}" enctype="multipart/form-data">
              @csrf
                <div>
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['jenis_st'] }}:</label>
                                <select class="form-control {{($errors->first('jenis_st') ? ' parsley-error' : '')}}" id="jenis_st" name="jenis_st">
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
                                <select class="form-control {{($errors->first('sumber_anggaran') ? ' parsley-error' : '')}}" id="sumber_anggaran" name="sumber_anggaran" v-model="sumber_anggaran" @change="setSumberAnggaran($event)">
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

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['mak'] }}:</label>
                                <select class="form-control {{($errors->first('mak') ? ' parsley-error' : '')}}" id="mak" name="mak" :disabled="sumber_anggaran==3">
                                    <option v-for="(value, index) in list_select_anggaran" :value="value.id">
                                        @{{ value.kode_program }}.@{{ value.kode_ro }}.@{{ value.kode_komponen }}.@{{ value.kode_subkomponen }} - @{{ value.label_ro }}
                                    </option>
                                </select>
                                @foreach ($errors->get('mak') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model_rincian->attributes()['pejabat_ttd_nip'] }}:</label>
                                <div class="form-line">
                                    <select class="form-control" id="pejabat_ttd_nip" name="pejabat_ttd_nip">
                                        @foreach ($list_pejabat as $value)
                                            <option value="{{ $value->nip_baru }}">{{ $value->name }} - {{ $value->nip_baru }} </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="pejabat_ttd_nama" v-model="pejabat_ttd_nama">
                                    <input type="hidden" name="pejabat_ttd_jabatan" v-model="pejabat_ttd_jabatan">
                                    <input type="hidden" name="unit_kerja_ttd" v-model="unit_kerja_ttd">
                                </div>
                            </div>
                        </div>
                    </div>    

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model->attributes()['tugas'] }}:</label>
                                <textarea id="tugas" name="tugas" class="form-control form-control-sm {{($errors->first('tugas') ? ' parsley-error' : '')}}" rows="3">{{ old('tugas', $model->tugas) }}</textarea>
                                @foreach ($errors->get('tugas') as $msg)
                                    <p class="text-danger">{{ $msg }}</p>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ $model_rincian->attributes()['tujuan_tugas'] }}  <small class="text-muted">Isikan '-' jika tidak ada tujuan tugas</small>:</label>
                                <div class="form-line">
                                    <textarea id="tujuan_tugas" name="tujuan_tugas" class="form-control form-control-sm {{($errors->first('tujuan_tugas') ? ' parsley-error' : '')}}" rows="3">{{ old('tujuan_tugas') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">{{ $model_rincian->attributes()['tanggal_mulai'] }}
                                <div class="form-line">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker form-control-sm tanggal_mulai" name="tanggal_mulai" v-model="tanggal_mulai">
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
                                        <input type="text" class="form-control datepicker form-control-sm tanggal_selesai" name="tanggal_selesai" v-model="tanggal_selesai">
                                        <div class="input-group-append">                                            
                                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('surat_tugas.rincian_tim')
                    @include('surat_tugas.modal_form_rincian_tim')
                    @include('surat_tugas.modal_form_rincian_mitra_tim')

                    <br>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <input type="hidden" name="total_utama" id="total_utama" v-model="total_utama">
                </div>

              </form>
          </div>
      </div>
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
            pathname :(window.location.pathname).replace("/create_tim", ""),
            sumber_anggaran:  1,
            mak: {!! json_encode($model->mak) !!},
            list_tingkat_biaya:  {!! json_encode($model_rincian->listTingkatBiaya) !!},
            list_kendaraan:  {!! json_encode($model_rincian->listKendaraan) !!},
            list_pegawai:  {!! json_encode($list_pegawai) !!},
            list_pejabat:  {!! json_encode($list_pejabat) !!},
            list_anggaran:  {!! json_encode($list_anggaran) !!},
            list_anggaran_prov:  {!! json_encode($list_anggaran_prov) !!},
            list_select_anggaran: {!! json_encode($list_anggaran) !!},
            total_utama: 1,
            rincian: [],
            tanggal_mulai: '',
            tanggal_selesai: '',
            pejabat_ttd_nama: '',
            pejabat_ttd_jabatan: '',
            unit_kerja_ttd: '',
            cur_rincian: {
                nip: '',
                nama: '',
                jabatan: '',
                tingkat_biaya: '',
                kendaraan: '',
                id: '',
                index: ''
            },
        },
        methods: {
            is_delete: function(params){
                if(isNaN(params)) return false;
                else return true;
            },
            setAllNama(){
                var self = this;
                var dropdown_nip = $("#nip")[0].selectedIndex;
                
                self.cur_rincian.nama = self.list_pegawai[dropdown_nip].name;
                self.cur_rincian.jabatan = self.list_pegawai[dropdown_nip].nmjab;
            },
            setAllPejabat(){
                var self = this;
                var pejabat_ttd_nip = $("#pejabat_ttd_nip")[0].selectedIndex;
                
                self.pejabat_ttd_nama = self.list_pejabat[pejabat_ttd_nip].name;
                self.pejabat_ttd_jabatan = self.list_pejabat[pejabat_ttd_nip].nmjab;
                self.unit_kerja_ttd = self.list_pejabat[pejabat_ttd_nip].kdprop+self.list_pejabat[pejabat_ttd_nip].kdkab;
            },
            setSumberAnggaran: function(event){
                var self = this;
                var value =  event.currentTarget.value;
                if(value==1) self.list_select_anggaran = self.list_anggaran;
                else if(value==2) self.list_select_anggaran = self.list_anggaran_prov;
                else if(value==3) self.list_select_anggaran = null;
            },
            saveRincian: function(jenis_petugas){
                var self = this;

                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                
                if(jenis_petugas==1){
                    $.ajax({
                        url :  vm.pathname + "/is_available",
                        method : 'post',
                        dataType: 'json',
                        data:{
                            nip: self.cur_rincian.nip,
                            t_start: self.tanggal_mulai,
                            t_end: self.tanggal_selesai,
                            cur_id: 0,
                        },
                    }).done(function (data) {
                        if(data.response==1){
                            // console.log(data.result[0].total)
                            if(data.result[0].total==0){
                                self.setAllNama()
                                self.setAllPejabat()
                                ////////
                                if(self.cur_rincian.id){
                                    self.rincian[self.cur_rincian.index] = {
                                        'id': self.cur_rincian.id,
                                        'nip'   : self.cur_rincian.nip,
                                        'nama'   : self.cur_rincian.nama,
                                        'jabatan'   : self.cur_rincian.jabatan,
                                        'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                                        'kendaraan'     : self.cur_rincian.kendaraan,
                                        'jenis_petugas'     : jenis_petugas,
                                    };
                                }
                                else{
                                    self.rincian.push({
                                        'id': 'au'+(self.total_utama),
                                        'nip'   : self.cur_rincian.nip,
                                        'nama'   : self.cur_rincian.nama,
                                        'jabatan'   : self.cur_rincian.jabatan,
                                        'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                                        'kendaraan'     : self.cur_rincian.kendaraan,
                                        'jenis_petugas'     : jenis_petugas,
                                    });
                                    self.total_utama++;
                                }

                                self.cur_rincian.nip = '';
                                self.cur_rincian.nama = '';
                                self.cur_rincian.jabatan = '';
                                self.cur_rincian.tingkat_biaya = '';
                                self.cur_rincian.kendaraan = '';
                                self.cur_rincian.id = '';
                                //////////
                                $('#form_rincian').modal('hide');
                            }
                            else{
                                alert(self.cur_rincian.nama + " tidak dapat DL pada tanggal tersebut karena telah melakukan DL atau CUTI")
                            }
                        }
                        else{
                            alert("Isian tanggal atau form belum lengkap atau terjadi kesalahan, silahkan ulangi lagi!")
                        }
                        
                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#form_rincian').modal('hide');
                    });
                }
                else{
                    self.setAllPejabat()
                    if(self.cur_rincian.nama!='' && self.cur_rincian.kendaraan!='' && self.cur_rincian.tingkat_biaya!=''){

                        if(self.cur_rincian.id){
                            self.rincian[self.cur_rincian.index] = {
                                'id': self.cur_rincian.id,
                                'nip'   : '',
                                'nama'   : self.cur_rincian.nama,
                                'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                                'kendaraan'     : self.cur_rincian.kendaraan,
                                'jenis_petugas'     : jenis_petugas,
                            };
                        }
                        else{
                            self.rincian.push({
                                'id': 'au'+(self.total_utama),
                                'nip'   : '',
                                'nama'   : self.cur_rincian.nama,
                                'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                                'kendaraan'     : self.cur_rincian.kendaraan,
                                'jenis_petugas'     : jenis_petugas,
                            });
                            self.total_utama++;
                        }

                        self.cur_rincian.nip = '';
                        self.cur_rincian.nama = '';
                        self.cur_rincian.jabatan = '';
                        self.cur_rincian.tingkat_biaya = '';
                        self.cur_rincian.kendaraan = '';
                        self.cur_rincian.id = '';
                        //////////

                        $('#wait_progres').modal('hide');    
                        $('#form_rincian2').modal('hide');
                    }
                    else{
                        $('#wait_progres').modal('hide');
                        alert("Isian belum lengkap atau terjadi kesalahan, silahkan ulangi lagi!")
                    }
                    
                }
            },
            updateRincian: function (event) {
                var self = this;
                if (event) {
                    self.cur_rincian.id = event.currentTarget.getAttribute('data-id');
                    self.cur_rincian.index = event.currentTarget.getAttribute('data-index');
                    self.cur_rincian.nip = event.currentTarget.getAttribute('data-nip');
                    self.cur_rincian.nama = event.currentTarget.getAttribute('data-nama');
                    self.cur_rincian.tingkat_biaya = event.currentTarget.getAttribute('data-tingkat_biaya');
                    self.cur_rincian.kendaraan = event.currentTarget.getAttribute('data-kendaraan');
                }
            },
            delDataTemp: function (index) {
                var self = this;
                $('#wait_progres').modal('show');
                self.rincian.splice(index, 1);
                self.total_utama--;
                $('#wait_progres').modal('hide');
            },
        }
    });
    
    $('.tanggal_mulai').change(function() {
        vm.tanggal_mulai = this.value;
    });
    
    $('.tanggal_selesai').change(function() {
        vm.tanggal_selesai = this.value;
    });

    $(document).ready(function() {
        $('.datepicker').datepicker({
            // startDate: 'd',
            format: 'yyyy-mm-dd',
        });
    });

    $(".frep").on("submit", function(){
        $('#wait_progres').modal('show');
        var is_error = 0;
        var err_message = [];

        var tugas =  $('#tugas').val();
        var jenis_st =  $('#jenis_st').val();
        var mak =  $('#mak').val();
        var sumber_anggaran =  $('#sumber_anggaran').val();
        var total_utama =  $('#total_utama').val();
        var tujuan_tugas =  $('#tujuan_tugas').val();
        var pejabat_ttd_nip =  $('#pejabat_ttd_nip').val();

        if(jenis_st.length==0){
            err_message.push("JENIS SURAT TUGAS tidak boleh kosong");
            is_error = 1;
        }
        
        if(sumber_anggaran==null || sumber_anggaran.length==0){
            err_message.push("SUMBER ANGGARAN tidak boleh kosong");
            is_error = 1;
        }

        if(mak==null) {
            if(sumber_anggaran!=3){
                err_message.push("MAK tidak boleh kosong");
                is_error = 1;
            }
        }
        
        if(tugas==null || tugas.length==0){
            err_message.push("TUGAS tidak boleh kosong");
            is_error = 1;
        }

        if(vm.tanggal_mulai==null || vm.tanggal_mulai.length==0 || vm.tanggal_selesai==null || vm.tanggal_selesai.length==0){
            err_message.push("Tanggal Pelaksanaan tidak boleh kosong");
            is_error = 1;
        }

        if(tujuan_tugas==null || tujuan_tugas.length==0){
            err_message.push("TUJUAN tidak boleh kosong");
            is_error = 1;
        }
        
        if(pejabat_ttd_nip==null || pejabat_ttd_nip.length==0){
            err_message.push("PEJABAT YANG MENANDATANGANI tidak boleh kosong");
            is_error = 1;
        }

        if(total_utama==1){
            err_message.push("Minimal harus terdapat 1 pegawai dalam SURAT TUGAS");
            is_error = 1;
        }

        vm.rincian.forEach(function(data_r){
            if(data_r.nama.length==0 || data_r.tingkat_biaya.length==0 ||
                data_r.kendaraan.length==0){
                err_message.push("Ada rincian pegawai yang belum lengkap");
                is_error = 1;
            }
        });
        
        $('#wait_progres').modal('hide');

        if(is_error==1){
            alert(err_message.join('\n'));
            return false;
        }
        else{
            return true;
        }
    });
</script>
@endsection
