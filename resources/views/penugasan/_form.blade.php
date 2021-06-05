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
                        <input type="text" id="tanggal_mulai" class="form-control datepicker form-control-sm">
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
                        <input type="text" id="tanggal_selesai" class="form-control datepicker form-control-sm">
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
    <button type="button" @click="saveData()" class="btn btn-primary">Simpan</button>

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
                participant_old: [],
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
                list_pegawai: {!! json_encode($list_pegawai) !!},
                id: {!! json_encode($id) !!},
            },
            computed: {
                pathname: function() {
                    if(this.id=='') return (window.location.pathname).replace("/create", "");
                    else return (window.location.pathname).replace("/"+this.id+"/edit", "");
                },
            },
            methods: {
                is_delete: function(params){
                    if(params=='' || isNaN(params)) return false;
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
                saveData: function(){
                    var self = this;

                    $('#wait_progres').modal('show');
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                    
                    var is_error = false;
                    var err_msg = []

                    if(self.form.isi==''){
                        is_error = true;
                        err_msg.push("Rincian 'Isi' Wajib Diisi");
                    }
                    
                    if(self.form.tanggal_mulai=='' || self.form.tanggal_selesai==''){
                        is_error = true;
                        err_msg.push("Rincian 'Tanggal Mulai' dan 'Tanggal Selesai' Wajib Diisi");
                    }
                    
                    if(self.form.satuan==''){
                        is_error = true;
                        err_msg.push("Rincian 'Satuan' Wajib Diisi");
                    }
                    
                    if(self.form.jenis_periode==''){
                        is_error = true;
                        err_msg.push("Rincian 'Jenis Periode' Wajib Diisi");
                    }
                    
                    if(self.participant.length==0){
                        is_error = true;
                        err_msg.push("Minimal ada 1 Participant Pada Penugasan");
                    }

                    for(var i=0;i<self.participant.length;i++){
                        if(self.participant[i].jumlah_target==''){
                            is_error = true;
                            err_msg.push("Ada Isian 'Jumlah Target' yang kosong");
                        }
                    }

                    if(!is_error){
                        var data_post = self.form
                        var rincian = { participant: self.participant }
                        data_post = { ...data_post, ...rincian }

                        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                        $.ajax({
                            url :  self.pathname,
                            method : 'post',
                            dataType: 'json',
                            data: data_post,
                        }).done(function (data) {
                            $('#wait_progres').modal('hide');
                            window.location.href = self.pathname
                        }).fail(function (msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progres').modal('hide');
                            window.location.href = self.pathname
                        });
                    }
                    else{
                        alert(err_msg.join("\r\n"));
                        $('#wait_progres').modal('hide');
                    }
                },
                loadData: function(){
                    var self = this;
                    $('#wait_progres').modal('show');

                    $.ajax({
                        url :  self.pathname + "/" + self.id,
                        method : 'get',
                        dataType: 'json',
                    }).done(function (data) {
                        $('#wait_progres').modal('hide');

                        if(data.form!=null){
                            self.form = data.form;

                            $('#tanggal_mulai').val(self.form.tanggal_mulai);
                            $('#tanggal_selesai').val(self.form.tanggal_selesai);

                            self.participant = data.participant;

                            self.participant_old = [];
                            for(var i=0;i<self.participant.length;i++){
                                self.participant_old.push(self.participant[i].user_nip_lama);
                            }

                            // console.log(temp_participant)
                            // temp_participant = ['340013929']
                            // $("#participant_select").val(temp_participant);
                            $("#participant_select").multiSelect('select', self.participant_old);
                        }
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                    
                },
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
        
        $('#tanggal_mulai').change(function() {
            vm.form.tanggal_mulai = this.value;
        });
        
        $('#tanggal_selesai').change(function() {
            vm.form.tanggal_selesai = this.value;
        });

        $(document).ready(function() {
            $('.datepicker').datepicker({
                // startDate: 'd',
                format: 'yyyy-mm-dd',
            });

            if(vm.id!=''){
                vm.loadData();
            }
        });
        
        $('#participant_select').multiSelect({
            afterSelect: function(values){
                if (vm.participant_old.indexOf(values[0]) === -1) {
                    vm.addParticipant(values[0])
                }
            },
            afterDeselect: function(values){
                // alert("Deselect value: "+values);
                vm.deleteTempParticipant(values[0])
            }
        });
    </script>
@endsection
