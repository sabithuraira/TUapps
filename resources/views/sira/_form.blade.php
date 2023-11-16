<div id="app_vue">
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['kode_mak'] }}:</label>
                <select class="form-control {{($errors->first('kode_mak') ? ' parsley-error' : '')}}" id="kode_mak" name="kode_mak" v-model="data_model.kode_mak"  @change="select_mak()">
                    @foreach($akun as $value)
                        <option  value="{{ $value->kode_mak }}" 
                            @if ($value->kode_mak == old('kode_mak', $model->kode_mak))
                                selected="selected"
                            @endif >
                            {{ $value->mak }}
                        </option>
                    @endforeach
                </select>
                @foreach ($errors->get('kode_mak') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['kode_akun'] }}:</label>
                <select class="form-control {{($errors->first('kode_akun') ? ' parsley-error' : '')}}" id="kode_akun" name="kode_akun" v-model="data_model.kode_akun">
                    <option v-for="(data, index) in list_akun" :value="data.kode_akun" :key="data.id">@{{ data.kode_akun }}</option>
                </select>
                @foreach ($errors->get('kode_akun') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['kode_fungsi'] }}:</label>
                <select class="form-control {{($errors->first('kode_fungsi') ? ' parsley-error' : '')}}" id="kode_fungsi" name="kode_fungsi" v-model="data_model.kode_fungsi">
                    @foreach ($model->listFungsi as $key=>$value)
                        <option  value="{{ $key }}" 
                            @if ($key == old('kode_fungsi', $model->kode_fungsi))
                                selected="selected"
                            @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @foreach ($errors->get('kode_fungsi') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_kak'] }}: </label>
                <input type="file" class="form-control" name="path_kak" id="path_kak" value="{{ old('path_kak', $model->path_kak) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_form_permintaan'] }}:</label>
                <input type="file" class="form-control" name="path_form_permintaan" id="path_form_permintaan" value="{{ old('path_form_permintaan', $model->path_form_permintaan) }}">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_undangan'] }}:</label>
                <input type="file" class="form-control" name="path_undangan" id="path_undangan" value="{{ old('path_undangan', $model->path_undangan) }}">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bukti_pembayaran'] }}:</label>
                <input type="file" class="form-control" name="path_bukti_pembayaran" id="path_bukti_pembayaran" value="{{ old('path_bukti_pembayaran', $model->path_bukti_pembayaran) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_kuitansi'] }}:</label>
                <input type="file" class="form-control" name="path_kuitansi" id="path_kuitansi" value="{{ old('path_kuitansi', $model->path_kuitansi) }}">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_notulen'] }}:</label>
                <input type="file" class="form-control" name="path_notulen" id="path_notulen" value="{{ old('path_notulen', $model->path_notulen) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_daftar_hadir'] }}:</label>
                <input type="file" class="form-control" name="path_daftar_hadir" id="path_daftar_hadir" value="{{ old('path_daftar_hadir', $model->path_daftar_hadir) }}">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_sk'] }}:</label>
                <input type="file" class="form-control" name="path_sk" id="path_sk" value="{{ old('path_sk', $model->path_sk) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_st'] }}:</label>
                <input type="file" class="form-control" name="path_st" id="path_st" value="{{ old('path_st', $model->path_st) }}">
            </div>
        </div>
    </div>

    <br>
    <button type="button" @click="saveData" class="btn btn-primary">Simpan</button>

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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                pathname : "https://st23.bpssumsel.com/api/",
                data_model: {
                    kode_mak: "",
                    kode_akun: "",
                    kode_fungsi: "",
                    path_kak: '',
                    path_form_permintaan: '',
                    path_notdin: '',
                    path_undangan: '',
                    path_bukti_pembayaran: '',
                    path_kuitansi: '',
                    path_notulen: '',
                    path_daftar_hadir: '',
                    path_sk: '',
                    path_st: '',
                }, 
                total_upload: 0, 
                list_akun: []
            },
            methods: {
                select_mak(){
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
                    })

                    $.ajax({
                        url : "{{ url('/sira/') }}" + '/' + self.data_model.kode_mak + '/get_akun',
                        method : 'get',
                        dataType: 'json',
                    }).done(function (data) {
                        self.list_akun = data.datas;
                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
                uploadData: function(){
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url : self.pathname + "/load_data",
                        method : 'post',
                        dataType: 'json',
                        data:{
                            month: self.month,
                            year: self.year,
                        },
                    }).done(function (data) {
                        self.datas = data.datas;

                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
                sbmt(){
                    var self = this;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })

                    if(self.total_upload>=10){
                        $.ajax({
                            url : "{{ url('/sira/') }}",
                            method : 'post',
                            dataType: 'json',
                            data: self.data_model ,
                        }).done(function (data) {
                            window.location.replace("{{ url('/sira/') }}");

                            $('#wait_progres').modal('hide');
                        }).fail(function (msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progres').modal('hide');
                        });
                    }

                    // if(self.kode_akun=="521211"){
                    //     //KAK, form permintaan, undangan, daftar hadir, notulen, komintmen,bukti prestasi pekerjaan, SSP PPh 22, SSP PPh 23
                    //     //daftar alokasi, faktur pajak
                    // }
                    // else if(self.kode_akun=="521213"){
                    //     //kak, form permintaan, SK KPA, laporan, daftar rincian honor output 
                    //     //rekap sesuai jabaatan, ssp PPh 21
                    // }
                    // else if(self.kode_akun=="521219"){
                    // }
                    // else if(self.kode_akun=="521811"){
                    //     //kak, form permintaan, komitmen, bukti prestasi,
                    //     //faktur pajak, SSP PPn, SSP PPh 22
                    //     //INNAS
                    //     //daftar hanir, laporan pengajar
                    //     //PETUGAS 
                    //     //surat kontrak, surat perjanjian , bast
                    // }
                    // else if(self.kode_akun=="522141"){
                    // }
                    // else if(self.kode_akun=="522151"){
                    //     //kak, form permintaan, sk KPA,
                    //     //undangan narsum, undangan peserta,
                    //     //jadwal, daftar hadir , paparan, kuitansi, salinan npwp, ssp pph 21
                    // }
                    // else if(self.kode_akun=="522191"){
                    // }
                    // else if(self.kode_akun=="522192"){
                    // }
                    // else if(self.kode_akun=="524111"){
                    //     //kaka, form permintaan, surat tugas, SPD dan visum
                    //     //bukti transport, DOP, tiket, penginapan, pengeluaran rill, kuitansi
                    // }
                    // else if(self.kode_akun=="524113"){
                    //     //kak, form permintaan, surat tugas, kwitansi transport, pengeluaran rill
                    //     //visum, surat penyataan tidak kendaran dinas, laporan perjalan dinas
                    // }
                    // else if(self.kode_akun=="524114"){
                    // }
                    // else if(self.kode_akun=="524119"){
                    // }
                }, 
                saveData(){
                    var self = this;
                    $('#wait_progres').modal('show');
                    var err_message = [];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })


                    // var url =  "https://st23.bpssumsel.com/api/file/";
                    var my_url = "http://localhost/mon_st2023/public/api/file/";

                    if(self.data_model.kode_mak.length==0) err_message.push("Kode MAK tidak boleh kosong");
                    if(self.data_model.kode_fungsi.length==0) err_message.push("Kode Fungsi tidak boleh kosong");
                    if(self.data_model.kode_akun.length==0) err_message.push("Kode Akun tidak boleh kosong");

                    if(err_message.length==0){
                        var pathKak = document.querySelector('#path_kak');
                        if(pathKak.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathKak.files[0]);

                            $.ajax({
                                url :  my_url + "kak/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_kak = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_kak = "";
                            vm.sbmt()
                        }

                        var pathFormPermintaan = document.querySelector('#path_form_permintaan');
                        if(pathFormPermintaan.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathFormPermintaan.files[0]);
                            $.ajax({
                                url :  my_url + "form_permintaan/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_form_permintaan = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_form_permintaan = "";
                            vm.sbmt()
                        }

                        // var pathNotdin = document.querySelector('#path_notdin');
                        // if(pathNotdin.files.length>0)
                        // {
                        //     var formData = new FormData();
                        //     formData.append("file_data", pathNotdin.files[0]);   
                        //     $.ajax({
                        //         url :  my_url + "notdin/upload",
                        //         type : 'POST',
                        //         data : formData,
                        //         processData: false,
                        //         contentType: false,
                        //         success : function(data) {
                        //             vm.total_upload += 1;
                        //             vm.data_model.path_notdin = data.datas;
                        //             vm.sbmt()
                        //         }
                        //     });
                        // }
                        // else{
                            vm.total_upload += 1;
                            vm.data_model.path_notdin = "";
                            vm.sbmt()
                        // }


                        var pathUndangan = document.querySelector('#path_undangan');
                        if(pathUndangan.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathUndangan.files[0]);
                            $.ajax({
                                url :  my_url + "undangan/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_undangan = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_undangan = "";
                            vm.sbmt()
                        }

                        var pathBuktiPembayaran = document.querySelector('#path_bukti_pembayaran');
                        if(pathBuktiPembayaran.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathBuktiPembayaran.files[0]); 
                            $.ajax({
                                url :  my_url + "bukti_pembayaran/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_bukti_pembayaran = data.datas;
                                    vm.sbmt()
                                }
                            });  
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_bukti_pembayaran = "";
                            vm.sbmt()
                        }


                        var pathKuitansi = document.querySelector('#path_kuitansi');
                        if(pathKuitansi.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathKuitansi.files[0]);
                            $.ajax({
                                url :  my_url + "kuitansi/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_kuitansi = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_kuitansi = "";
                            vm.sbmt()
                        }


                        var pathNotulen = document.querySelector('#path_notulen');
                        if(pathNotulen.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathNotulen.files[0]);
                            $.ajax({
                                url :  my_url + "notulen/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_notulen = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_notulen ="";
                            vm.sbmt()
                        }


                        var pathDaftarHadir = document.querySelector('#path_daftar_hadir');
                        if(pathDaftarHadir.files.length>0)
                        {   
                            var formData = new FormData();
                            formData.append("file_data", pathDaftarHadir.files[0]);   
                            $.ajax({
                                url :  my_url + "daftar_hadir/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_daftar_hadir = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_daftar_hadir = "";
                            vm.sbmt()
                        }


                        var pathSk = document.querySelector('#path_sk');
                        if(pathSk.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathSk.files[0]);  
                            $.ajax({
                                url :  my_url + "sk/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_sk = data.datas;
                                    vm.sbmt()
                                }
                            }); 
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_sk = "";
                            vm.sbmt()
                        }

                        var pathSt = document.querySelector('#path_st');
                        if(pathSt.files.length>0)
                        {
                            var formData = new FormData();
                            formData.append("file_data", pathSt.files[0]);   
                            $.ajax({
                                url :  my_url + "st/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    vm.total_upload += 1;
                                    vm.data_model.path_st = data.datas;
                                    vm.sbmt()
                                }
                            });
                        }
                        else{
                            vm.total_upload += 1;
                            vm.data_model.path_st = "";
                            vm.sbmt()
                        }

                        return false;
                    }
                    else{
                        alert(err_message.join());
                    $('#wait_progres').modal('hide');
                    }
                }
            }
        });

        $(document).ready(function() {
            // vm.setNomor();
            // vm.setDatas();

        });

        $(".frep").on("submit", function(){
            
        });
    </script>
@endsection
