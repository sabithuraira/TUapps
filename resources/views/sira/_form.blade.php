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
                    <option v-for="(data, index) in list_akun" :value="data.kode_akun" :key="data.id"> @{{ data.kode_akun }} </option>
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
        <div v-if="data_model.kode_akun=='522111' || data_model.kode_akun=='522112' || data_model.kode_akun=='522113' 
                || data_model.kode_akun=='522119'
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524113'
                || data_model.kode_akun=='524111'
                || data_model.kode_akun=='522141'
                || data_model.kode_akun=='522151' 
                || data_model.kode_akun=='521811' 
                || data_model.kode_akun=='521219' 
                || data_model.kode_akun=='521213' 
                || data_model.kode_akun=='521211'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bukti_pembayaran'] }}:</label>
                <input type="file" class="form-control" name="path_bukti_pembayaran" id="path_bukti_pembayaran" value="{{ old('path_bukti_pembayaran', $model->path_bukti_pembayaran) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521211' 
                || data_model.kode_akun=='522151' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_undangan'] }}:</label>
                <input type="file" class="form-control" name="path_undangan" id="path_undangan" value="{{ old('path_undangan', $model->path_undangan) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521211' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_notulen'] }}:</label>
                <input type="file" class="form-control" name="path_notulen" id="path_notulen" value="{{ old('path_notulen', $model->path_notulen) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521211' 
                || data_model.kode_akun=='521213' 
                || data_model.kode_akun=='522151'  
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_daftar_hadir'] }}:</label>
                <input type="file" class="form-control" name="path_daftar_hadir" id="path_daftar_hadir" value="{{ old('path_daftar_hadir', $model->path_daftar_hadir) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='522151'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_sk'] }}:</label>
                <input type="file" class="form-control" name="path_sk" id="path_sk" value="{{ old('path_sk', $model->path_sk) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='524111' 
                || data_model.kode_akun=='524113' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119' 
                || data_model.kode_akun=='522119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_st'] }}:</label>
                <input type="file" class="form-control" name="path_st" id="path_st" value="{{ old('path_st', $model->path_st) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='521811' 
                || data_model.kode_akun=='522141'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_spk'] }}:</label>
                <input type="file" class="form-control" name="path_spk" id="path_spk" value="{{ old('path_spk', $model->path_spk) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='522141' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bast'] }}:</label>
                <input type="file" class="form-control" name="path_bast" id="path_bast" value="{{ old('path_bast', $model->path_bast) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='522151'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_rekap_belanja'] }}:</label>
                <input type="file" class="form-control" name="path_rekap_belanja" id="path_rekap_belanja" value="{{ old('path_rekap_belanja', $model->path_rekap_belanja) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_laporan'] }}:</label>
                <input type="file" class="form-control" name="path_laporan" id="path_laporan" value="{{ old('path_laporan', $model->path_laporan) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521213' 
                || data_model.kode_akun=='522151' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_jadwal'] }}:</label>
                <input type="file" class="form-control" name="path_jadwal" id="path_jadwal" value="{{ old('path_jadwal', $model->path_jadwal) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521219' 
                || data_model.kode_akun=='524119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_drpp'] }}:</label>
                <input type="file" class="form-control" name="path_drpp" id="path_drpp" value="{{ old('path_drpp', $model->path_drpp) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521219' 
                || data_model.kode_akun=='522141' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_invoice'] }}:</label>
                <input type="file" class="form-control" name="path_invoice" id="path_invoice" value="{{ old('path_invoice', $model->path_invoice) }}">
            </div>
        </div>


        <div v-if="data_model.kode_akun=='521219'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_resi_pengiriman'] }}:</label>
                <input type="file" class="form-control" name="path_resi_pengiriman" id="path_resi_pengiriman" value="{{ old('path_resi_pengiriman', $model->path_resi_pengiriman) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521219' 
                || data_model.kode_akun=='522141'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_npwp_rekkor'] }}:</label>
                <input type="file" class="form-control" name="path_npwp_rekkor" id="path_npwp_rekkor" value="{{ old('path_npwp_rekkor', $model->path_npwp_rekkor) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='521811'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_tanda_terima'] }}:</label>
                <input type="file" class="form-control" name="path_tanda_terima" id="path_tanda_terima" value="{{ old('path_tanda_terima', $model->path_tanda_terima) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='522151'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_cv'] }}:</label>
                <input type="file" class="form-control" name="path_cv" id="path_cv" value="{{ old('path_cv', $model->path_cv) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='522151'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bahan_paparan'] }}:</label>
                <input type="file" class="form-control" name="path_bahan_paparan" id="path_bahan_paparan" value="{{ old('path_bahan_paparan', $model->path_bahan_paparan) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='522141'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_ba_pembayaran'] }}:</label>
                <input type="file" class="form-control" name="path_ba_pembayaran" id="path_ba_pembayaran" value="{{ old('path_ba_pembayaran', $model->path_ba_pembayaran) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111' 
                || data_model.kode_akun=='524113'  
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'  
                || data_model.kode_akun=='522119'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_spd_visum'] }}:</label>
                <input type="file" class="form-control" name="path_spd_visum" id="path_spd_visum" value="{{ old('path_spd_visum', $model->path_spd_visum) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111' 
                || data_model.kode_akun=='524113'  
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='524119'  
                || data_model.kode_akun=='522119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_presensi_uang_makan'] }}:</label>
                <input type="file" class="form-control" name="path_presensi_uang_makan" id="path_presensi_uang_makan" value="{{ old('path_presensi_uang_makan', $model->path_presensi_uang_makan) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_rincian_perjadin'] }}:</label>
                <input type="file" class="form-control" name="path_rincian_perjadin" id="path_rincian_perjadin" value="{{ old('path_rincian_perjadin', $model->path_rincian_perjadin) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111' 
                || data_model.kode_akun=='522119'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bukti_transport'] }}:</label>
                <input type="file" class="form-control" name="path_bukti_transport" id="path_bukti_transport" value="{{ old('path_bukti_transport', $model->path_bukti_transport) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bukti_inap'] }}:</label>
                <input type="file" class="form-control" name="path_bukti_inap" id="path_bukti_inap" value="{{ old('path_bukti_inap', $model->path_bukti_inap) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111' 
                || data_model.kode_akun=='524113'" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_lpd'] }}:</label>
                <input type="file" class="form-control" name="path_lpd" id="path_lpd" value="{{ old('path_lpd', $model->path_lpd) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524111' 
                || data_model.kode_akun=='524113' 
                || data_model.kode_akun=='524114' 
                || data_model.kode_akun=='522119'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_rekap_perjadin'] }}:</label>
                <input type="file" class="form-control" name="path_rekap_perjadin" id="path_rekap_perjadin" value="{{ old('path_rekap_perjadin', $model->path_rekap_perjadin) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524113' 
                || data_model.kode_akun=='524114'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_sp_kendaraan_dinas'] }}:</label>
                <input type="file" class="form-control" name="path_sp_kendaraan_dinas" id="path_sp_kendaraan_dinas" value="{{ old('path_sp_kendaraan_dinas', $model->path_sp_kendaraan_dinas) }}">
            </div>
        </div>

        <div v-if="data_model.kode_akun=='524113'" class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_daftar_rill'] }}:</label>
                <input type="file" class="form-control" name="path_daftar_rill" id="path_daftar_rill" value="{{ old('path_daftar_rill', $model->path_daftar_rill) }}">
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
                    path_spk: '',
                    path_bast: '',
                    path_rekap_belanja: '',
                    path_laporan: '',
                    path_jadwal: '',
                    path_drpp: '',
                    path_invoice: '',
                    path_resi_pengiriman: '',
                    path_npwp_rekkor: '',
                    path_tanda_terima: '',
                    path_cv: '',
                    path_bahan_paparan: '',
                    path_ba_pembayaran: '',
                    path_spd_visum: '',
                    path_presensi_uang_makan: '',
                    path_rincian_perjadin: '',
                    path_bukti_transport: '',
                    path_bukti_inap: '',
                    path_lpd: '',
                    path_rekap_perjadin: '',
                    path_sp_kendaraan_dinas: '',
                    path_daftar_rill: '',
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

                    var maks_upload = 0;

                    if(self.data_model.kode_akun=='522111' || self.data_model.kode_akun=='522112' || 
                        self.data_model.kode_akun=='522113'){
                        maks_upload = 3;
                    }

                    if(self.data_model.kode_akun=='521211'){
                        maks_upload = 6;
                    }

                    if(self.data_model.kode_akun=='521219'){
                        maks_upload = 7;
                    }

                    if(self.data_model.kode_akun=='521213'){
                        maks_upload = 9;
                    }

                    if(self.data_model.kode_akun=='521811'){
                        maks_upload = 5;
                    }

                    if(self.data_model.kode_akun=='522151' 
                        || self.data_model.kode_akun=='524113'){
                        maks_upload = 10;
                    }

                    if(self.data_model.kode_akun=='522141' 
                            || self.data_model.kode_akun=='522119' 
                            || self.data_model.kode_akun=='524114'){
                        maks_upload = 8;
                    }

                    if(self.data_model.kode_akun=='524111'){
                        maks_upload = 11;
                    }

                    if(self.total_upload>=maks_upload){
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


                    // var my_url =  "https://st23.bpssumsel.com/api/file/";
                    var my_url = "http://localhost/mon_st2023/public/api/file/";

                    if(self.data_model.kode_mak.length==0) err_message.push("Kode MAK tidak boleh kosong");
                    if(self.data_model.kode_fungsi.length==0) err_message.push("Kode Fungsi tidak boleh kosong");
                    if(self.data_model.kode_akun.length==0) err_message.push("Kode Akun tidak boleh kosong");

                    if(err_message.length==0){
                        var pathKak = document.querySelector('#path_kak');
                        if(pathKak.files.length>0){
                            var formData = new FormData();
                            formData.append("file_data", pathKak.files[0]);

                            $.ajax({
                                url :  my_url + "kak/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    self.total_upload += 1;
                                    self.data_model.path_kak = data.datas;
                                    self.sbmt()
                                }
                            });
                        }
                        else{
                            self.total_upload += 1;
                            self.data_model.path_kak = "";
                            self.sbmt()
                        }

                        var pathFormPermintaan = document.querySelector('#path_form_permintaan');
                        if(pathFormPermintaan.files.length>0){
                            var formData = new FormData();
                            formData.append("file_data", pathFormPermintaan.files[0]);
                            $.ajax({
                                url :  my_url + "form_permintaan/upload",
                                type : 'POST',
                                data : formData,
                                processData: false,
                                contentType: false,
                                success : function(data) {
                                    self.total_upload += 1;
                                    self.data_model.path_form_permintaan = data.datas;
                                    self.sbmt()
                                }
                            });
                        }
                        else{
                            self.total_upload += 1;
                            self.data_model.path_form_permintaan = "";
                            self.sbmt()
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
                            // vm.total_upload += 1;
                            // vm.data_model.path_notdin = "";
                            // vm.sbmt()
                        // }


                        if(self.data_model.kode_akun=='522111' || 
                            self.data_model.kode_akun=='522112' || 
                            self.data_model.kode_akun=='522113' 
                            || self.data_model.kode_akun=='522119'
                            || self.data_model.kode_akun=='524114' 
                            || self.data_model.kode_akun=='524113'
                            || self.data_model.kode_akun=='524111'
                            || self.data_model.kode_akun=='522141'
                            || self.data_model.kode_akun=='522151' 
                            || self.data_model.kode_akun=='521811' 
                            || self.data_model.kode_akun=='521219' 
                            || self.data_model.kode_akun=='521213' 
                            || self.data_model.kode_akun=='521211'){
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
                                        self.total_upload += 1;
                                        self.data_model.path_bukti_pembayaran = data.datas;
                                        self.sbmt()
                                    }
                                });  
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_bukti_pembayaran = "";
                                self.sbmt()
                            }
                        }
                        

                        // var pathKuitansi = document.querySelector('#path_kuitansi');
                        // if(pathKuitansi.files.length>0)
                        // {
                        //     var formData = new FormData();
                        //     formData.append("file_data", pathKuitansi.files[0]);
                        //     $.ajax({
                        //         url :  my_url + "kuitansi/upload",
                        //         type : 'POST',
                        //         data : formData,
                        //         processData: false,
                        //         contentType: false,
                        //         success : function(data) {
                        //             vm.total_upload += 1;
                        //             vm.data_model.path_kuitansi = data.datas;
                        //             vm.sbmt()
                        //         }
                        //     });
                        // }
                        // else{
                        //     vm.total_upload += 1;
                        //     vm.data_model.path_kuitansi = "";
                        //     vm.sbmt()
                        // }

                        if(self.data_model.kode_akun=='521211' 
                            || self.data_model.kode_akun=='522151' 
                            || self.data_model.kode_akun=='524114' 
                            || self.data_model.kode_akun=='524119'){
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
                                        self.total_upload += 1;
                                        self.data_model.path_undangan = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_undangan = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521211' 
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'){
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
                                        self.total_upload += 1;
                                        self.data_model.path_notulen = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_notulen ="";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521211' 
                                || self.data_model.kode_akun=='521213' 
                                || self.data_model.kode_akun=='522151'  
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'){
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
                                        self.total_upload += 1;
                                        self.data_model.path_daftar_hadir = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_daftar_hadir = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' || self.data_model.kode_akun=='522151'){
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
                                        self.total_upload += 1;
                                        self.data_model.path_sk = data.datas;
                                        self.sbmt()
                                    }
                                }); 
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_sk = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' 
                            || self.data_model.kode_akun=='524111' 
                            || self.data_model.kode_akun=='524113' 
                            || self.data_model.kode_akun=='524114' 
                            || self.data_model.kode_akun=='524119' 
                            || self.data_model.kode_akun=='522119'){
                      
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
                                        self.total_upload += 1;
                                        self.data_model.path_st = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_st = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' 
                                || self.data_model.kode_akun=='521811' 
                                || self.data_model.kode_akun=='522141'){
                      
                            var pathSpk = document.querySelector('#path_spk');
                            if(pathSpk.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathSpk.files[0]);   
                                $.ajax({
                                    url :  my_url + "spk/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_spk = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_spk = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' 
                                || self.data_model.kode_akun=='522141' 
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'){
                      
                            var pathBast = document.querySelector('#path_bast');
                            if(pathBast.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathBast.files[0]);   
                                $.ajax({
                                    url :  my_url + "bast/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_bast = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_bast = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' 
                                || self.data_model.kode_akun=='522151'){
                            var pathRekapBelanja = document.querySelector('#path_rekap_belanja');
                            if(pathRekapBelanja.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathRekapBelanja.files[0]);   
                                $.ajax({
                                    url :  my_url + "rekap_belanja/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_rekap_belanja = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_rekap_belanja = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' 
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'){
                            var pathLaporan = document.querySelector('#path_laporan');
                            if(pathLaporan.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathLaporan.files[0]);   
                                $.ajax({
                                    url :  my_url + "laporan/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_laporan = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_laporan = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521213' 
                                || self.data_model.kode_akun=='522151' 
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'){
                            var pathJadwal = document.querySelector('#path_jadwal');
                            if(pathJadwal.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathJadwal.files[0]);   
                                $.ajax({
                                    url :  my_url + "jadwal/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_jadwal = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_jadwal = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521219' 
                                || self.data_model.kode_akun=='524119'){
                            var pathDrpp = document.querySelector('#path_drpp');
                            if(pathDrpp.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathDrpp.files[0]);   
                                $.ajax({
                                    url :  my_url + "drpp/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_drpp = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_drpp = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521219' 
                                || self.data_model.kode_akun=='522141' 
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'){
                            var pathInvoice = document.querySelector('#path_invoice');
                            if(pathInvoice.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathInvoice.files[0]);   
                                $.ajax({
                                    url :  my_url + "invoice/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_invoice = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_invoice = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521219'){
                            var pathResiPengiriman = document.querySelector('#path_resi_pengiriman');
                            if(pathResiPengiriman.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathResiPengiriman.files[0]);   
                                $.ajax({
                                    url :  my_url + "resi_pengiriman/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_resi_pengiriman = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_resi_pengiriman = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521219' 
                                || self.data_model.kode_akun=='522141'){
                            var pathNpwpRekkor = document.querySelector('#path_npwp_rekkor');
                            if(pathNpwpRekkor.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathNpwpRekkor.files[0]);   
                                $.ajax({
                                    url :  my_url + "npwp_rekkor/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_npwp_rekkor = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_npwp_rekkor = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='521811'){
                            var pathTandaTerima = document.querySelector('#path_tanda_terima');
                            if(pathTandaTerima.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathTandaTerima.files[0]);   
                                $.ajax({
                                    url :  my_url + "tanda_terima/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_tanda_terima = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_tanda_terima = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='522151'){
                            var pathCv = document.querySelector('#path_cv');
                            if(pathCv.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathCv.files[0]);   
                                $.ajax({
                                    url :  my_url + "cv/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_cv = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_cv = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='522151'){
                            var pathBahanPaparan = document.querySelector('#path_bahan_paparan');
                            if(pathBahanPaparan.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathBahanPaparan.files[0]);   
                                $.ajax({
                                    url :  my_url + "bahan_paparan/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_bahan_paparan = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_bahan_paparan = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='522141'){
                            var pathBaPembayaran = document.querySelector('#path_ba_pembayaran');
                            if(pathBaPembayaran.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathBaPembayaran.files[0]);   
                                $.ajax({
                                    url :  my_url + "ba_pembayaran/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_ba_pembayaran = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_ba_pembayaran = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='524111' 
                                || self.data_model.kode_akun=='524113'  
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='524119'  
                                || self.data_model.kode_akun=='522119'){
                            var pathSpdVisum = document.querySelector('#path_spd_visum');
                            if(pathSpdVisum.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathSpdVisum.files[0]);   
                                $.ajax({
                                    url :  my_url + "spd_visum/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_spd_visum = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_spd_visum = "";
                                self.sbmt()
                            }

                            var pathPresensiUangMakan = document.querySelector('#path_presensi_uang_makan');
                            if(pathPresensiUangMakan.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathPresensiUangMakan.files[0]);   
                                $.ajax({
                                    url :  my_url + "presensi_uang_makan/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_presensi_uang_makan = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_presensi_uang_makan = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='524111'){
                            var pathRincianPerjadin = document.querySelector('#path_rincian_perjadin');
                            if(pathRincianPerjadin.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathRincianPerjadin.files[0]);   
                                $.ajax({
                                    url :  my_url + "rincian_perjadin/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_rincian_perjadin = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_rincian_perjadin = "";
                                self.sbmt()
                            }
                        }
                        
                        if(self.data_model.kode_akun=='524111' 
                                || self.data_model.kode_akun=='522119'){
                            var pathBuktiTransport = document.querySelector('#path_bukti_transport');
                            if(pathBuktiTransport.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathBuktiTransport.files[0]);   
                                $.ajax({
                                    url :  my_url + "bukti_transport/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_bukti_transport = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_bukti_transport = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='524111'){
                            var pathBuktiInap = document.querySelector('#path_bukti_inap');
                            if(pathBuktiInap.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathBuktiInap.files[0]);   
                                $.ajax({
                                    url :  my_url + "bukti_inap/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_bukti_inap = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_bukti_inap = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='524111' 
                                || self.data_model.kode_akun=='524113'){
                            var pathLpd = document.querySelector('#path_lpd');
                            if(pathLpd.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathLpd.files[0]);   
                                $.ajax({
                                    url :  my_url + "lpd/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_lpd = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_lpd = "";
                                self.sbmt()
                            }
                        }
                        
                        if(self.data_model.kode_akun=='524111' 
                                || self.data_model.kode_akun=='524113' 
                                || self.data_model.kode_akun=='524114' 
                                || self.data_model.kode_akun=='522119'){
                            var pathRekapPerjadin = document.querySelector('#path_rekap_perjadin');
                            if(pathRekapPerjadin.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathRekapPerjadin.files[0]);   
                                $.ajax({
                                    url :  my_url + "rekap_perjadin/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_rekap_perjadin = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_rekap_perjadin = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='524113' 
                                || self.data_model.kode_akun=='524114'){
                            var pathSpKendaraanDinas = document.querySelector('#path_sp_kendaraan_dinas');
                            if(pathSpKendaraanDinas.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathSpKendaraanDinas.files[0]);   
                                $.ajax({
                                    url :  my_url + "sp_kendaraan_dinas/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_sp_kendaraan_dinas = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_sp_kendaraan_dinas = "";
                                self.sbmt()
                            }
                        }

                        if(self.data_model.kode_akun=='524113'){
                            var pathDaftarRill = document.querySelector('#path_daftar_rill');
                            if(pathDaftarRill.files.length>0)
                            {
                                var formData = new FormData();
                                formData.append("file_data", pathDaftarRill.files[0]);   
                                $.ajax({
                                    url :  my_url + "daftar_rill/upload",
                                    type : 'POST',
                                    data : formData,
                                    processData: false,
                                    contentType: false,
                                    success : function(data) {
                                        self.total_upload += 1;
                                        self.data_model.path_daftar_rill = data.datas;
                                        self.sbmt()
                                    }
                                });
                            }
                            else{
                                self.total_upload += 1;
                                self.data_model.path_daftar_rill = "";
                                self.sbmt()
                            }
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
