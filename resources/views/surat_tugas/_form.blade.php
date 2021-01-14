<div id="app_vue">
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

    <div class="form-group">
        <label>{{ $model->attributes()['mak'] }}:</label>
        <select class="form-control {{($errors->first('mak') ? ' parsley-error' : '')}}" id="mak" name="mak" :disabled="sumber_anggaran==3">
            <option v-for="(value, index) in list_select_anggaran" :value="value.id">
                @{{ value.kode_program }}.@{{ value.kode_ro }}.@{{ value.kode_komponen }}.@{{ value.kode_subkomponen }}
            </option>
        </select>
        @foreach ($errors->get('mak') as $msg)
            <p class="text-danger">{{ $msg }}</p>
        @endforeach
    </div>

    <div class="form-group">
        <label>{{ $model->attributes()['tugas'] }}:</label>
        <textarea id="tugas" name="tugas" class="form-control form-control-sm {{($errors->first('tugas') ? ' parsley-error' : '')}}" rows="5">{{ old('tugas', $model->tugas) }}</textarea>
        @foreach ($errors->get('tugas') as $msg)
            <p class="text-danger">{{ $msg }}</p>
        @endforeach
    </div>

    @include('surat_tugas.rincian')
    @include('surat_tugas.modal_form_rincian')

    <br>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <input type="hidden" name="total_utama" id="total_utama" v-model="total_utama">

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
            pathname :(window.location.pathname).replace("/create", ""),
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
            cur_rincian: {
                nip: '',
                nama: '',
                jabatan: '',
                tujuan_tugas: '',
                tanggal_mulai: '',
                tanggal_selesai: '',
                pejabat_ttd_nip: '',
                pejabat_ttd_nama: '',
                pejabat_ttd_jabatan: '',
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
            setAllNamaAndPejabat(){
                var self = this;
                var dropdown_nip = $("#nip")[0].selectedIndex;
                var pejabat_ttd_nip = $("#pejabat_ttd_nip")[0].selectedIndex;
                
                self.cur_rincian.nama = self.list_pegawai[dropdown_nip].name;
                self.cur_rincian.jabatan = self.list_pegawai[dropdown_nip].nmjab;
                
                self.cur_rincian.pejabat_ttd_nama = self.list_pejabat[pejabat_ttd_nip].name;
                self.cur_rincian.pejabat_ttd_jabatan = self.list_pejabat[pejabat_ttd_nip].nmjab;
            },
            setSumberAnggaran: function(event){
                var self = this;
                var value =  event.currentTarget.value;
                if(value==1) self.list_select_anggaran = self.list_anggaran;
                else if(value==2) self.list_select_anggaran = self.list_anggaran_prov;
                else if(value==3) self.list_select_anggaran = null;
            },
            saveRincian: function(){
                var self = this;

                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                $.ajax({
                    url :  vm.pathname + "/is_available",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        nip: self.cur_rincian.nip,
                        t_start: self.cur_rincian.tanggal_mulai,
                        t_end: self.cur_rincian.tanggal_selesai,
                    },
                }).done(function (data) {
                    if(data.response==1){
                        // console.log(data.result[0].total)
                        if(data.result[0].total==0){
                            self.setAllNamaAndPejabat()
                            ////////
                            if(self.cur_rincian.id){
                                self.rincian[self.cur_rincian.index] = {
                                    'id': self.cur_rincian.id,
                                    'nip'   : self.cur_rincian.nip,
                                    'nama'   : self.cur_rincian.nama,
                                    'jabatan'   : self.cur_rincian.jabatan,
                                    'tujuan_tugas'   : self.cur_rincian.tujuan_tugas,
                                    'tanggal_mulai'   : self.cur_rincian.tanggal_mulai,
                                    'tanggal_selesai'   : self.cur_rincian.tanggal_selesai,
                                    'pejabat_ttd_nip'   : self.cur_rincian.pejabat_ttd_nip,
                                    'pejabat_ttd_nama'     : self.cur_rincian.pejabat_ttd_nama,
                                    'pejabat_ttd_jabatan'     : self.cur_rincian.pejabat_ttd_jabatan,
                                    'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                                    'kendaraan'     : self.cur_rincian.kendaraan,
                                };
                            }
                            else{
                                self.rincian.push({
                                    'id': 'au'+(self.total_utama),
                                    'nip'   : self.cur_rincian.nip,
                                    'nama'   : self.cur_rincian.nama,
                                    'jabatan'   : self.cur_rincian.jabatan,
                                    'tujuan_tugas'   : self.cur_rincian.tujuan_tugas,
                                    'tanggal_mulai'   : self.cur_rincian.tanggal_mulai,
                                    'tanggal_selesai'   : self.cur_rincian.tanggal_selesai,
                                    'pejabat_ttd_nip'   : self.cur_rincian.pejabat_ttd_nip,
                                    'pejabat_ttd_nama'     : self.cur_rincian.pejabat_ttd_nama,
                                    'pejabat_ttd_jabatan'     : self.cur_rincian.pejabat_ttd_jabatan,
                                    'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                                    'kendaraan'     : self.cur_rincian.kendaraan,
                                });
                                self.total_utama++;
                            }

                            self.cur_rincian.nip = '';
                            self.cur_rincian.nama = '';
                            self.cur_rincian.tujuan_tugas = '';
                            self.cur_rincian.tanggal_mulai = '';
                            self.cur_rincian.tanggal_selesai = '';
                            self.cur_rincian.pejabat_ttd_nip = '';
                            self.cur_rincian.pejabat_ttd_nama = '';
                            self.cur_rincian.pejabat_ttd_jabatan = '';
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
                        alert("Isian belum lengkap atau terjadi kesalahan, silahkan ulangi lagi!")
                    }
                    
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#form_rincian').modal('hide');
                });
            },
            updateRincian: function (event) {
                var self = this;
                if (event) {
                    self.cur_rincian.id = event.currentTarget.getAttribute('data-id');
                    self.cur_rincian.index = event.currentTarget.getAttribute('data-index');
                    self.cur_rincian.nip = event.currentTarget.getAttribute('data-nip');
                    self.cur_rincian.nama = event.currentTarget.getAttribute('data-nama');
                    self.cur_rincian.tujuan_tugas = event.currentTarget.getAttribute('data-tujuan_tugas');
                    
                    // self.cur_rincian.tanggal_mulai = event.currentTarget.getAttribute('data-tangga_mulai');
                    self.cur_rincian.tanggal_mulai = event.currentTarget.getAttribute('data-tanggal_mulai');
                    $('#rincian_tanggal_mulai').val(self.cur_rincian.tanggal_mulai);

                    self.cur_rincian.tanggal_selesai = event.currentTarget.getAttribute('data-tanggal_selesai');
                    $('#rincian_tanggal_selesai').val(self.cur_rincian.tanggal_selesai);

                    self.cur_rincian.tanggal_selesai = event.currentTarget.getAttribute('data-tanggal_selesai');
                    self.cur_rincian.pejabat_ttd_nip = event.currentTarget.getAttribute('data-pejabat_ttd_nip');
                    self.cur_rincian.pejabat_ttd_nama = event.currentTarget.getAttribute('data-pejabat_ttd_nama');
                    self.cur_rincian.pejabat_ttd_jabatan = event.currentTarget.getAttribute('data-pejabat_ttd_jabatan');
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
    
    $('#rincian_tanggal_mulai').change(function() {
        vm.cur_rincian.tanggal_mulai = this.value;
    });
    
    $('#rincian_tanggal_selesai').change(function() {
        vm.cur_rincian.tanggal_selesai = this.value;
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
        $('#wait_progres').modal('show');
        var is_error = 0;
        var err_message = [];

        var tugas =  $('#tugas').val();
        var jenis_st =  $('#jenis_st').val();
        var mak =  $('#mak').val();
        var sumber_anggaran =  $('#sumber_anggaran').val();
        var total_utama =  $('#total_utama').val();

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

        if(total_utama==1){
            err_message.push("Minimal harus terdapat 1 pegawai dalam SURAT TUGAS");
            is_error = 1;
        }

        vm.rincian.forEach(function(data_r){
            if(data_r.nip.length==0 || data_r.tujuan_tugas.length==0 
                || data_r.tanggal_mulai.length==0 || data_r.tanggal_selesai.length==0 || 
                data_r.pejabat_ttd_nip.length==0 || data_r.tingkat_biaya.length==0 ||
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
