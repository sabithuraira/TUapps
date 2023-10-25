<div id="app_vue">
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['kode_mak'] }}:</label>
                <select class="form-control {{($errors->first('kode_mak') ? ' parsley-error' : '')}}" id="kode_mak" name="kode_mak" v-model="kode_mak">
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
                <select class="form-control {{($errors->first('kode_akun') ? ' parsley-error' : '')}}" id="kode_akun" name="kode_akun" v-model="kode_akun" @change="setSumberAnggaran($event)">
                    
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
                <select class="form-control {{($errors->first('kode_fungsi') ? ' parsley-error' : '')}}" id="kode_fungsi" name="kode_fungsi" v-model="kode_fungsi">
                    @foreach ($model->listFungsi as $key=>$value)
                        <option  value="{{ $key }}" 
                            @if ($key == old('kode_akun', $model->kode_akun))
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
                <input type="file" class="form-control" name="path_kak" value="{{ old('path_kak', $model->path_kak) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_form_permintaan'] }}:</label>
                <input type="file" class="form-control" name="path_form_permintaan" value="{{ old('path_form_permintaan', $model->path_form_permintaan) }}">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_notdin'] }}:</label>
                <input type="file" class="form-control" name="path_notdin" value="{{ old('path_notdin', $model->path_notdin) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_undangan'] }}:</label>
                <input type="file" class="form-control" name="path_undangan" value="{{ old('path_undangan', $model->path_undangan) }}">
            </div>
        </div>
    </div>


    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_bukti_pembayaran'] }}:</label>
                <input type="file" class="form-control" name="path_bukti_pembayaran" value="{{ old('path_bukti_pembayaran', $model->path_bukti_pembayaran) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_kuitansi'] }}:</label>
                <input type="file" class="form-control" name="path_kuitansi" value="{{ old('path_kuitansi', $model->path_kuitansi) }}">
            </div>
        </div>
    </div>


    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_notulen'] }}:</label>
                <input type="file" class="form-control" name="path_notulen" value="{{ old('path_notulen', $model->path_notulen) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_daftar_hadir'] }}:</label>
                <input type="file" class="form-control" name="path_daftar_hadir" value="{{ old('path_daftar_hadir', $model->path_daftar_hadir) }}">
            </div>
        </div>
    </div>


    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['path_sk'] }}:</label>
                <input type="file" class="form-control" name="path_sk" value="{{ old('path_sk', $model->path_sk) }}">
            </div>
        </div>

        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['path_st'] }}:</label>
                <input type="file" class="form-control" name="path_st" value="{{ old('path_st', $model->path_st) }}">
            </div>
        </div>
    </div>


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
            jenis_st : 1,
            sumber_anggar
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
                unit_kerja_ttd: '',
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
        }
    });
    
    $('.rincian_tanggal_mulai').change(function() {
        vm.cur_rincian.tanggal_mulai = this.value;
    });
    
    $('.rincian_tanggal_selesai').change(function() {
        vm.cur_rincian.tanggal_selesai = this.value;
    });

    $(document).ready(function() {
        // vm.setNomor();
        // vm.setDatas();

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
            if(data_r.nama.length==0 || data_r.tanggal_mulai.length==0 || data_r.tanggal_selesai.length==0 || 
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
