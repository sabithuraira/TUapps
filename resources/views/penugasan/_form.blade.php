<div id="app_vue">
    <div class="form-group">
        <label>Judul:</label>
        <input type="text" class="form-control form-control-sm" v-model="form.isi" />
    </div>

    <div class="form-group">
        <label>Keterangan:</label>
        <textarea class="form-control form-control-sm" rows="5" v-model="form.keterangan"></textarea>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group"><label>Tanggal Mulai</label>
                <div class="form-line">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker form-control-sm" v-model="form.tanggal_mulai">
                        <div class="input-group-append">                                            
                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group"><label>Tanggal Selesai</label>
                <div class="form-line">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker form-control-sm" v-model="form.tanggal_selesai">
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
            <div class="form-group">
                <label>Satuan:</label>
                <input type="text" class="form-control form-control-sm" v-model="form.satuan" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Jenis Periode:</label>
                <select class="form-control form-control-sm" v-model="form.jenis_periode">
                    @foreach ($model->listJenisPeriode as $key=>$value)
                        <option  value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @include('penugasan.rincian_participant')
    <br/>
    <button type="submit" class="btn btn-primary">Simpan</button>

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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/multi-select/css/multi-select.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/multi-select/js/jquery.multi-select.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                pathname :(window.location.pathname).replace("/create", ""),
                participant: [],
                form: {
                    isi: '',
                    keterangan: '',
                    tanggal_mulai: '',
                    tanggal_selesai: '',
                    satuan: '',
                    jenis_periode: '',
                    unit_kerja: '',
                },
                detail_participant: {
                    penugasan_id: '',
                    user_id: '',
                    user_nip_lama: '',
                    user_nip_baru: '',
                    user_nama: '',
                    user_jabatan: '',
                    jumlah_target: '',
                    jumlah_selesai: '',
                    unit_kerja: '',
                    nilai_waktu: '',
                    nilai_penyelesaian: '',
                    id: '',
                    index: ''
                },
                list_pegawai: {!! json_encode($list_pegawai) !!}
            },
            methods: {
                is_delete: function(params){
                    if(isNaN(params)) return false;
                    else return true;
                },
                addParticipant: function(nip){
                    var current_pegawai = this.list_pegawai.find(x => x.email === nip);
                    this.participant.push({
                        penugasan_id: '',
                        user_id: current_pegawai.id,
                        user_nip_lama: current_pegawai.email,
                        user_nip_baru: current_pegawai.nip_baru,
                        user_nama: current_pegawai.name,
                        user_jabatan: current_pegawai.nmjab,
                        jumlah_target: '',
                        jumlah_selesai: '',
                        unit_kerja: '',
                        nilai_waktu: '',
                        nilai_penyelesaian: '',
                        id: '',
                        index: ''
                    });
                },
                deleteTempParticipant: function(nip){
                    this.participant.splice(this.participant.findIndex(x => x.user_nip_lama === nip), 1);
                },
                deleteParticipant: function(id){

                },
                // setAllNamaAndPejabat(){
                //     var self = this;
                //     var dropdown_nip = $("#nip")[0].selectedIndex;
                //     var pejabat_ttd_nip = $("#pejabat_ttd_nip")[0].selectedIndex;
                    
                //     self.cur_rincian.nama = self.list_pegawai[dropdown_nip].name;
                //     self.cur_rincian.jabatan = self.list_pegawai[dropdown_nip].nmjab;
                    
                //     self.cur_rincian.pejabat_ttd_nama = self.list_pejabat[pejabat_ttd_nip].name;
                //     self.cur_rincian.pejabat_ttd_jabatan = self.list_pejabat[pejabat_ttd_nip].nmjab;
                //     self.cur_rincian.unit_kerja_ttd = self.list_pejabat[pejabat_ttd_nip].kdprop+self.list_pejabat[pejabat_ttd_nip].kdkab;
                // },
                // setAllPejabat(){
                //     var self = this;
                //     var pejabat_ttd_nip = $("#pejabat_ttd_nip")[0].selectedIndex;
                    
                //     self.cur_rincian.pejabat_ttd_nama = self.list_pejabat[pejabat_ttd_nip].name;
                //     self.cur_rincian.pejabat_ttd_jabatan = self.list_pejabat[pejabat_ttd_nip].nmjab;
                //     self.cur_rincian.unit_kerja_ttd = self.list_pejabat[pejabat_ttd_nip].kdprop+self.list_pejabat[pejabat_ttd_nip].kdkab;
                // },
                // setSumberAnggaran: function(event){
                //     var self = this;
                //     var value =  event.currentTarget.value;
                //     if(value==1) self.list_select_anggaran = self.list_anggaran;
                //     else if(value==2) self.list_select_anggaran = self.list_anggaran_prov;
                //     else if(value==3) self.list_select_anggaran = null;
                // },
                // saveRincian: function(jenis_petugas){
                //     var self = this;

                //     $('#wait_progres').modal('show');
                //     $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                    
                //     if(jenis_petugas==1){
                //         $.ajax({
                //             url :  vm.pathname + "/is_available",
                //             method : 'post',
                //             dataType: 'json',
                //             data:{
                //                 nip: self.cur_rincian.nip,
                //                 t_start: self.cur_rincian.tanggal_mulai,
                //                 t_end: self.cur_rincian.tanggal_selesai,
                //             },
                //         }).done(function (data) {
                //             if(data.response==1){
                //                 // console.log(data.result[0].total)
                //                 if(data.result[0].total==0){
                //                     self.setAllNamaAndPejabat()
                //                     ////////
                //                     if(self.cur_rincian.id){
                //                         self.rincian[self.cur_rincian.index] = {
                //                             'id': self.cur_rincian.id,
                //                             'nip'   : self.cur_rincian.nip,
                //                             'nama'   : self.cur_rincian.nama,
                //                             'jabatan'   : self.cur_rincian.jabatan,
                //                             'tujuan_tugas'   : self.cur_rincian.tujuan_tugas,
                //                             'tanggal_mulai'   : self.cur_rincian.tanggal_mulai,
                //                             'tanggal_selesai'   : self.cur_rincian.tanggal_selesai,
                //                             'pejabat_ttd_nip'   : self.cur_rincian.pejabat_ttd_nip,
                //                             'pejabat_ttd_nama'     : self.cur_rincian.pejabat_ttd_nama,
                //                             'pejabat_ttd_jabatan'     : self.cur_rincian.pejabat_ttd_jabatan,
                //                             'unit_kerja_ttd'     : self.cur_rincian.unit_kerja_ttd,
                //                             'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                //                             'kendaraan'     : self.cur_rincian.kendaraan,
                //                             'jenis_petugas'     : jenis_petugas,
                //                         };
                //                     }
                //                     else{
                //                         self.rincian.push({
                //                             'id': 'au'+(self.total_utama),
                //                             'nip'   : self.cur_rincian.nip,
                //                             'nama'   : self.cur_rincian.nama,
                //                             'jabatan'   : self.cur_rincian.jabatan,
                //                             'tujuan_tugas'   : self.cur_rincian.tujuan_tugas,
                //                             'tanggal_mulai'   : self.cur_rincian.tanggal_mulai,
                //                             'tanggal_selesai'   : self.cur_rincian.tanggal_selesai,
                //                             'pejabat_ttd_nip'   : self.cur_rincian.pejabat_ttd_nip,
                //                             'pejabat_ttd_nama'     : self.cur_rincian.pejabat_ttd_nama,
                //                             'pejabat_ttd_jabatan'     : self.cur_rincian.pejabat_ttd_jabatan,
                //                             'unit_kerja_ttd'     : self.cur_rincian.unit_kerja_ttd,
                //                             'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                //                             'kendaraan'     : self.cur_rincian.kendaraan,
                //                             'jenis_petugas'     : jenis_petugas,
                //                         });
                //                         self.total_utama++;
                //                     }

                //                     self.cur_rincian.nip = '';
                //                     self.cur_rincian.nama = '';
                //                     self.cur_rincian.tujuan_tugas = '';
                //                     self.cur_rincian.tanggal_mulai = '';
                //                     self.cur_rincian.tanggal_selesai = '';
                //                     self.cur_rincian.pejabat_ttd_nip = '';
                //                     self.cur_rincian.pejabat_ttd_nama = '';
                //                     self.cur_rincian.pejabat_ttd_jabatan = '';
                //                     self.cur_rincian.unit_kerja_ttd = '';
                //                     self.cur_rincian.tingkat_biaya = '';
                //                     self.cur_rincian.kendaraan = '';
                //                     self.cur_rincian.id = '';
                //                     //////////
                //                     $('#form_rincian').modal('hide');
                //                 }
                //                 else{
                //                     alert(self.cur_rincian.nama + " tidak dapat DL pada tanggal tersebut karena telah melakukan DL atau CUTI")
                //                 }
                //             }
                //             else{
                //                 alert("Isian belum lengkap atau terjadi kesalahan, silahkan ulangi lagi!")
                //             }
                            
                //             $('#wait_progres').modal('hide');
                //         }).fail(function (msg) {
                //             console.log(JSON.stringify(msg));
                //             $('#form_rincian').modal('hide');
                //         });
                //     }
                //     else{
                //         self.setAllPejabat()
                //         if(self.cur_rincian.nama!='' && self.cur_rincian.tanggal_mulai!='' 
                //             && self.cur_rincian.pejabat_ttd_nip!=''
                //             && self.cur_rincian.tanggal_selesai!='' && self.cur_rincian.tujuan_tugas!='' 
                //             && self.cur_rincian.kendaraan!='' && self.cur_rincian.tingkat_biaya!=''){

                //             if(self.cur_rincian.id){
                //                 self.rincian[self.cur_rincian.index] = {
                //                     'id': self.cur_rincian.id,
                //                     'nip'   : '',
                //                     'nama'   : self.cur_rincian.nama,
                //                     'jabatan'   : '',
                //                     'tujuan_tugas'   : self.cur_rincian.tujuan_tugas,
                //                     'tanggal_mulai'   : self.cur_rincian.tanggal_mulai,
                //                     'tanggal_selesai'   : self.cur_rincian.tanggal_selesai,
                //                     'pejabat_ttd_nip'   : self.cur_rincian.pejabat_ttd_nip,
                //                     'pejabat_ttd_nama'     : self.cur_rincian.pejabat_ttd_nama,
                //                     'pejabat_ttd_jabatan'     : self.cur_rincian.pejabat_ttd_jabatan,
                //                     'unit_kerja_ttd'     : self.cur_rincian.unit_kerja_ttd,
                //                     'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                //                     'kendaraan'     : self.cur_rincian.kendaraan,
                //                     'jenis_petugas'     : jenis_petugas,
                //                 };
                //             }
                //             else{
                //                 self.rincian.push({
                //                     'id': 'au'+(self.total_utama),
                //                     'nip'   : '',
                //                     'nama'   : self.cur_rincian.nama,
                //                     'jabatan'   : '',
                //                     'tujuan_tugas'   : self.cur_rincian.tujuan_tugas,
                //                     'tanggal_mulai'   : self.cur_rincian.tanggal_mulai,
                //                     'tanggal_selesai'   : self.cur_rincian.tanggal_selesai,
                //                     'pejabat_ttd_nip'   : self.cur_rincian.pejabat_ttd_nip,
                //                     'pejabat_ttd_nama'     : self.cur_rincian.pejabat_ttd_nama,
                //                     'pejabat_ttd_jabatan'     : self.cur_rincian.pejabat_ttd_jabatan,
                //                     'unit_kerja_ttd'     : self.cur_rincian.unit_kerja_ttd,
                //                     'tingkat_biaya'     : self.cur_rincian.tingkat_biaya,
                //                     'kendaraan'     : self.cur_rincian.kendaraan,
                //                     'jenis_petugas'     : jenis_petugas,
                //                 });
                //                 self.total_utama++;
                //             }

                //             self.cur_rincian.nip = '';
                //             self.cur_rincian.nama = '';
                //             self.cur_rincian.tujuan_tugas = '';
                //             self.cur_rincian.tanggal_mulai = '';
                //             self.cur_rincian.tanggal_selesai = '';
                //             self.cur_rincian.pejabat_ttd_nip = '';
                //             self.cur_rincian.pejabat_ttd_nama = '';
                //             self.cur_rincian.pejabat_ttd_jabatan = '';
                //             self.cur_rincian.unit_kerja_ttd = '';
                //             self.cur_rincian.tingkat_biaya = '';
                //             self.cur_rincian.kendaraan = '';
                //             self.cur_rincian.id = '';
                //             //////////

                //             $('#wait_progres').modal('hide');    
                //             $('#form_rincian2').modal('hide');
                //         }
                //         else{
                //             $('#wait_progres').modal('hide');
                //             alert("Isian belum lengkap atau terjadi kesalahan, silahkan ulangi lagi!")
                //         }
                        
                //     }
                // },
                updateParticipant: function (event) {
                    var self = this;
                //     if (event) {
                //         self.cur_rincian.id = event.currentTarget.getAttribute('data-id');
                //         self.cur_rincian.index = event.currentTarget.getAttribute('data-index');
                //         self.cur_rincian.nip = event.currentTarget.getAttribute('data-nip');
                //         self.cur_rincian.nama = event.currentTarget.getAttribute('data-nama');
                //         self.cur_rincian.tujuan_tugas = event.currentTarget.getAttribute('data-tujuan_tugas');
                        
                //         // self.cur_rincian.tanggal_mulai = event.currentTarget.getAttribute('data-tangga_mulai');
                //         self.cur_rincian.tanggal_mulai = event.currentTarget.getAttribute('data-tanggal_mulai');
                //         $('#rincian_tanggal_mulai').val(self.cur_rincian.tanggal_mulai);

                //         self.cur_rincian.tanggal_selesai = event.currentTarget.getAttribute('data-tanggal_selesai');
                //         $('#rincian_tanggal_selesai').val(self.cur_rincian.tanggal_selesai);

                //         self.cur_rincian.pejabat_ttd_nip = event.currentTarget.getAttribute('data-pejabat_ttd_nip');
                //         self.cur_rincian.pejabat_ttd_nama = event.currentTarget.getAttribute('data-pejabat_ttd_nama');
                //         self.cur_rincian.pejabat_ttd_jabatan = event.currentTarget.getAttribute('data-pejabat_ttd_jabatan');
                //         self.cur_rincian.unit_kerja_ttd = event.currentTarget.getAttribute('data-unit_kerja_ttd');
                //         self.cur_rincian.tingkat_biaya = event.currentTarget.getAttribute('data-tingkat_biaya');
                //         self.cur_rincian.kendaraan = event.currentTarget.getAttribute('data-kendaraan');

                //     }
                },
            }
        });
        
        $('.tanggal_mulai').change(function() {
            vm.cur_rincian.tanggal_mulai = this.value;
        });
        
        $('.tanggal_selesai').change(function() {
            vm.cur_rincian.tanggal_selesai = this.value;
        });

        $(document).ready(function() {
            $('.datepicker').datepicker({
                // startDate: 'd',
                format: 'yyyy-mm-dd',
            });
        });
        
        $('#participant_select').multiSelect({
            afterSelect: function(values){
                vm.addParticipant(values[0])
            },
            afterDeselect: function(values){
                // alert("Deselect value: "+values);
                vm.deleteTempParticipant(values[0])
            }
        });
    </script>
@endsection
