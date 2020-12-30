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
                <select class="form-control {{($errors->first('sumber_anggaran') ? ' parsley-error' : '')}}"  name="sumber_anggaran">
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
        <label>{{ $model->attributes()['kode_mak'] }}:</label>
        <select class="form-control {{($errors->first('kode_mak') ? ' parsley-error' : '')}}"  name="kode_mak">
            @foreach ($list_anggaran as $key=>$value)
                <option  value="{{ $value->id }}" 
                    @if ($value->id == old('kode_mak', $model->kode_mak))
                        selected="selected"
                    @endif>
                    {{ $value->kode_program.'.'.$value->kode_aktivitas.'.'.$value->kode_kro.'.'.$value->kode_ro.'.'.$value->kode_komponen.'.'.$value->kode_subkomponen }}
                    {{ $value->label_aktivitas.'-'.$value->label_ro }}
                </option>
            @endforeach
        </select>
        @foreach ($errors->get('kode_mak') as $msg)
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
            jenis_st: {!! json_encode($model->jenis_st) !!},
            sumber_anggaran:  {!! json_encode($model->sumber_anggaran) !!},
            mak: {!! json_encode($model->mak) !!},
            kode_mak:  {!! json_encode($model->kode_mak) !!}, 
            tugas:  {!! json_encode($model->tugas) !!}, 
            unit_kerja:  {!! json_encode($model->unit_kerja) !!},
            list_tingkat_biaya:  {!! json_encode($model_rincian->listTingkatBiaya) !!},
            list_kendaraan:  {!! json_encode($model_rincian->listKendaraan) !!},
            list_pegawai:  {!! json_encode($list_pegawai) !!},
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
                tingkat_biaya: '',
                kendaraan: '',
                id: '',
                index: ''
            },
        },
        computed: {
        },
        watch: {
            // nomor: function (val) {
            //     if(!this.id_induk){
            //         let year = new Date(this.form_tanggal).getFullYear();
            //         this.form_no_laporan = val + '/' + this.label_nomor + this.label_nomor_periode;
            //     }
            // },
            // form_periode_audit: function (val) {
            //     if(!this.id_induk){
            //         let year = new Date(this.form_tanggal).getFullYear();
            //         this.form_no_laporan = this.nomor + '/' + this.label_nomor + this.label_nomor_periode;
            //     }
            // },
            // form_tanggal: function (val) {
            //     if(!this.id_induk){
            //         let year = new Date(val).getFullYear();
            //         this.form_no_laporan = this.nomor + '/'+ this.label_nomor + this.label_nomor_periode;
            //     }
            // },
        },
        methods: {
            is_delete: function(params){
                if(isNaN(params)) return false;
                else return true;
            },
            setNamaJabatan: function(event){
                var self = this;
                $('#wait_progres').modal('show');
                var selected_index = event.currentTarget.selectedIndex;
                self.cur_rincian.nama = self.list_pegawai[selected_index].name;
                self.cur_rincian.jabatan = self.list_pegawai[selected_index].nmjab;
                $('#wait_progres').modal('hide');
            },
            setPejabat: function(event){
                var self = this;
                $('#wait_progres').modal('show');
                var selected_index = event.currentTarget.selectedIndex;
                self.cur_rincian.pejabat_ttd_nama = self.list_pegawai[selected_index].name;
                $('#wait_progres').modal('hide');
            },
            saveRincian: function(){
                var self = this;

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
                self.cur_rincian.tingkat_biaya = '';
                self.cur_rincian.kendaraan = '';
                self.cur_rincian.id = '';
                
                $('#form_rincian').modal('hide');
            },
            updateRincian: function (event) {
                var self = this;
                if (event) {
                    self.cur_rincian.id = event.currentTarget.getAttribute('data-id');
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
        // $('#isi').val($("#editarea").html());
        // return confirm("Anda yakin ingin menyimpan data ini?");
        // var is_error = 1;
        // var err_message = [];

        // var object_audit =  $('#object_audit').val();
        // var total_utama =  $('#total_utama').val();
        // var total_key =  $('#total_key').val();
        // var total_auditor =  $('#total_auditor').val();
        // var total_auditi =  $('#total_auditi').val();

        // if(object_audit.length==0) {
        //     if(vm.jenis==1)
        //         err_message.push("Tujuan Saran Tidak Boleh Kosong");
        //     else if(vm.jenis==4)
        //         err_message.push("Unit Kerja Tidak Boleh Kosong");
        //     else
        //         err_message.push("Object Audit Tidak Boleh Kosong");
            
        //     is_error = 0;
        // }

        // if(vm.jenis==1 || vm.jenis==2){
        //     var form_pejabat_badge =  $('#form_pejabat_badge').val();
        //     if(form_pejabat_badge.length==0){ 
        //         err_message.push("Pejabat Approval Tidak Boleh Kosong");
        //         is_error = 0;
        //     }
        // }

        // if(total_utama==1){
        //     err_message.push("Minimal harus terdapat 1 rincian");
        //     is_error = 0;
        // }
        
        // if(total_key==1){
        //     err_message.push("Minimal harus terdapat 1 key person");
        //     is_error = 0;
        // }

        // if(vm.jenis!=3 && vm.jenis!=5){
        //     if(total_auditor==1){ 
        //         err_message.push("Minimal harus terdapat 1 auditor/petugas K3/tim investigasi");
        //         is_error = 0;
        //     }
            
        //     if(total_auditi==1){ 
        //         err_message.push("Minimal harus terdapat 1 auditi/tembusan");
        //         is_error = 0;
        //     }
        // }

        // if(vm.jenis==1){
        //     vm.rincian.forEach(function(data_r){
        //         if(data_r.uraian.length>0 && data_r.file_path.length==0){
        //             err_message.push("Ada rincian yang tidak memiliki file/file belum selesai upload");
        //             is_error = 0;
        //         }
        //     });
        // }

        // if(is_error==0){
        //     alert(err_message.join('\r\n'));
        //     return false;
        // }
        // else{
        //     return true;
        // }
    });
</script>
@endsection
