<div id="app_vue">
    <div class="form-group">
        <label>Nama Tim:</label>
        <input type="text" class="form-control form-control-sm" v-model="form.nama_tim" />
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tahun:</label>
                <select class="form-control form-control-sm" v-model="form.tahun">
                    @for ($i=date('Y');$i>=2023;$i--)
                        <option  value="{{ $i }}">
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Jumlah Anggota:</label>
                <input type="text" disabled class="form-control form-control-sm" v-model="form.jumlah_anggota" />
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Ketua Tim:</label>
                <input type="text" disabled class="form-control form-control-sm" v-model="form.nama_ketua_tim" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>NIP Ketua Tim:</label>
                <input type="text" disabled class="form-control form-control-sm" v-model="form.nik_ketua_tim" />
            </div>
        </div>
    </div>

    @include('tim.rincian_participant')
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
                    nama_tim: '',
                    tahun: '',
                    nama_ketua_tim: '',
                    nik_ketua_tim: '',
                    jumlah_anggota: '',
                },
                detail_participant: {
                    id_tim: '',
                    nama_anggota: '',
                    nik_anggota: '',
                    status_keanggotaan: '',
                    is_active: '',
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
                addParticipant: function(nip){
                    var current_pegawai = this.list_pegawai.find(x => x.nip_baru === nip);
                    this.participant.push({
                        id_tim: '',
                        nik_anggota: current_pegawai.nip_baru,
                        nama_anggota: current_pegawai.name,
                        status_keanggotaan: 2,
                        is_active: 1,
                        id: '',
                        index: ''
                    });
                },
                addSelectedParticipant: function(nip){
                    $("#participant_select").multiSelect('select', [nip]);
                },
                deleteTempParticipant: function(nip){
                    this.participant.splice(this.participant.findIndex(x => x.user_nip_lama === nip), 1);
                    $("#participant_select").multiSelect('deselect', [nip]);
                },
                deleteData: function(id_participant){
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                    $.ajax({
                        url :  self.pathname + "/" + id_participant + "/destroy_participant",
                        method : 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        self.loadData()
                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                        self.loadData()
                    });
                },
                saveData: function(){
                    var self = this;

                    $('#wait_progres').modal('show');
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                    
                    var err_msg = []

                    if(self.form.nama_tim=='') err_msg.push("Rincian 'Nama Tim' Wajib Diisi");
                    if(self.form.tahun=='') err_msg.push("Rincian 'Tahun' Wajib Diisi");
                    if(self.participant.length==0) err_msg.push("Minimal ada 1 Anggota Tim Pada Sebuah Tim");

                    let jumlah_ketua = 0;
                    for(var i=0;i<self.participant.length;i++){
                        if(self.participant[i].status_keanggotaan==''){
                            err_msg.push("Ada Isian 'Status Keanggotaan' yang kosong");
                        }
                        else{
                            if(self.participant[i].status_keanggotaan=="1") jumlah_ketua++;
                        }
                    }

                    if(jumlah_ketua!=1) err_msg.push("Jumlah Ketua Tim Harus 1");

                    if(err_msg.length==0){
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
                        url :  self.pathname + "/" + self.id + "/detail",
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

                            $("#participant_select").multiSelect('select', self.participant_old);
                        }
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                    
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
                if (vm.participant.findIndex(x => x.user_nip_lama === values[0]) === -1) {
                    vm.addParticipant(values[0])
                }
            },
            afterDeselect: function(values){
                if (vm.participant_old.indexOf(values[0]) === -1) {
                    vm.deleteTempParticipant(values[0])
                }
                else{
                    var cur_index = vm.participant.findIndex(x => x.user_nip_lama === values[0]);
                    
                    if (cur_index != -1) {
                        var cur_data = vm.participant[cur_index]
                        var confirm_var = confirm("Apakah anda yakin ingin menghapus tim '"+ cur_data.user_nama +"'");
                        if (confirm_var == true) 
                            vm.deleteData(cur_data.id)
                        else
                            vm.addSelectedParticipant(values[0])
                    }
                }
            }
        });
    </script>
@endsection
