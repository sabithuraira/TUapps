<div id="app_vue">
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ $model->attributes()['jenis_surat'] }}:</label>
                <select :disabled="id_data!=''" class="form-control {{($errors->first('jenis_surat') ? ' parsley-error' : '')}}" v-model="form.jenis_surat" name="jenis_surat" @change="setNomor">
                    <option value="">- Pilih Jenis Surat -</option>
                    @foreach ($model->listJenis as $key=>$value)
                        <option value="{{ $key }}" 
                            @if ($key == old('jenis_surat', $model->jenis_surat))
                                selected="selected"
                            @endif >{{ $value }}</option>
                    @endforeach
                </select>
                @foreach ($errors->get('jenis_surat') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>

    <div v-show="form.jenis_surat==1">
        @include('surat_km._form_surat_masuk')
    </div>
    
    <div v-show="form.jenis_surat==2">
        @include('surat_km._form_surat_keluar')
    </div>
    
    <div v-show="form.jenis_surat==3">
        @include('surat_km._form_memorandum')
    </div>
    
    <div v-show="form.jenis_surat==4">
        @include('surat_km._form_surat_pengantar')
    </div>
    
    <div v-show="form.jenis_surat==5">
        @include('surat_km._form_disposisi')
    </div>
    
    <div v-show="form.jenis_surat==6">
        @include('surat_km._form_surat_keputusan')
    </div>
    
    <div v-show="form.jenis_surat==7">
        @include('surat_km._form_surat_keterangan')
    </div>

    <div v-show="form.jenis_surat==8">
        @include('surat_km._form_surat_spk')
    </div>
    
    <div v-show="form.jenis_surat==9">
        @include('surat_km._form_surat_mou')
    </div>

    <br>
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
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({
    el: "#app_vue",
    data:  {
        id_data: {!! json_encode($id) !!},
        form: {
            id: '',
            nomor_urut: {!! json_encode($model->nomor_urut) !!},
            alamat: '',
            tanggal: {!! json_encode(date('m/d/Y', strtotime($model->tanggal))) !!},
            nomor: '',
            perihal: '',
            nomor_petunjuk: '',
            jenis_surat: {!! json_encode($model->jenis_surat) !!},
            kdprop: '',
            kdkab: '',
            penerima: '',
            ditetapkan_di: '',
            ditetapkan_tanggal: '',
            ditetapkan_oleh: '',
            ditetapkan_nama: '',
            ditetapkan_nip: '',
            kode_unit_kerja: '',
            klasifikasi_arsip: '',
            tingkat_keamanan: '',
        },
        form_disposisi: {
            id: '',
            induk_id: '',
            nomor_agenda: '',
            tanggal_penerimaan: '',
            tanggal_penyelesaian: '',
            dari: '',
            isi: '',
            lampiran: '',
            isi_disposisi: '',
            diteruskan_kepada: '',
        },
        form_memorandum: {
            id: '',
            induk_id: '',
            dari: '',
            isi: '',
            tembusan: '',
            kepada: '',
        },
        form_surat_keputusan: {
            id: '',
            induk_id: '',
            tentang: '',
            menimbang: '',
            mengingat: '',
            menetapkan: '',
            tembusan: '',
        },
        form_surat_keterangan: {
            id: '',
            induk_id: '',
            isi: '',
        },
        form_surat_keluar: {
            id: '',
            induk_id: '',
            isi: '',
            lampiran: '',
            kepada: '',
            kepada_di: '',
            dibuat_di: '',
        },
        form_surat_pengantar: {
            id: '',
            induk_id: '',
            isi: '',
            kepada: '',
            kepada_di: '',
            diterima_tanggal: '',
            diterima_jabatan: '',
            diterima_nama: '',
            diterima_nip: '',
            diterima_no_hp: '',
            dibuat_di: '',
        },
        tembusan: [],
        keputusan: [],
        pathname : (window.location.pathname).replace("/create", ""),
        list_angka_keputusan: [
            "KESATU", "KEDUA", "KETIGA", "KEEMPAT", "KELIMA", "KEENAM", "KETUJUH", "KEDELAPAN", 
            "KESEMBILAN", "KESEPULUH", "KESEBELAS", "KEDUA BELAS", "KETIGA BELAS", "KEEMPAT BELAS",
            "KELIMA BELAS", "KEENAM BELAS", "KETUJUH BELAS", "KEDELAPAN BELAS", "KESEMBILAN BELAS", "KEDUA PULUH"
        ]
    },
    computed: {
        bulan: function () {
            var split_tanggal = this.form.tanggal.split("/");
            if(split_tanggal.length==0) return "";
            else return split_tanggal[0]
        },
        tahun: function () {
            var split_tanggal = this.form.tanggal.split("/");
            if(split_tanggal.length==0) return "";
            else return split_tanggal[2]
        },
    },
    methods: {
        setNomor: function(){
            var self = this;
            $('#wait_progres').modal('show');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            })

            $.ajax({
                url :  "{{ url('/surat_km/nomor_urut/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    jenis_surat: self.form.jenis_surat, 
                    tanggal: self.form.tanggal,
                },
            }).done(function (data) {
                self.form.nomor_urut = data.total;

                if(self.form.jenis_surat==2) $('#isi2').summernote();
                if(self.form.jenis_surat==4) $('#isi4').summernote();
                if(self.form.jenis_surat==7) $('#isi7').summernote();
                
                if(self.form.jenis_surat==3){
                    $('#isi3').summernote();
                    $('#tembusan').summernote();
                }
                
                if(self.form.jenis_surat==6){
                    $('#tentang').summernote();
                    $('#menimbang').summernote();
                    $('#mengingat').summernote();
                    $('#menetapkan').summernote();
                    $('#tembusan').summernote();
                }

                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        addTembusan(){
            this.tembusan.push({
                'id' : 'a' + this.tembusan.length,
                'induk_id' : '',
                'isi' : '',
            });
        },
        addKeputusan(){
            this.keputusan.push({
                'id' : 'a' + this.keputusan.length,
                'induk_id' : '',
                'isi' : '',
            });
        },
        setDatas: function(){
            if(this.id_data!=''){
                this.form = {!! json_encode($model) !!};
                if(this.form.jenis_surat==2) {
                    var temp_data = {!! json_encode($model_rincian) !!}
                    if(temp_data!=null)
                        this.form_surat_keluar = {!! json_encode($model_rincian) !!};  
                    $('#isi2').summernote('code', this.form_surat_keluar.isi);   
                }
                else if(this.form.jenis_surat==3){
                    var temp_data = {!! json_encode($model_rincian) !!}
                    if(temp_data!=null)
                        this.form_memorandum = {!! json_encode($model_rincian) !!};   
                    $('#isi3').summernote('code', this.form_memorandum.isi);   
                    $('#tembusan').summernote('code', this.form_memorandum.tembusan);
                } 
                else if(this.form.jenis_surat==4){
                    var temp_data = {!! json_encode($model_rincian) !!}
                    if(temp_data!=null)
                        this.form_surat_pengantar = {!! json_encode($model_rincian) !!}; 
                    $('#isi4').summernote('code', this.form_surat_pengantar.isi);   
                } 
                else if(this.form.jenis_surat==5){
                    var temp_data = {!! json_encode($model_rincian) !!}
                    if(temp_data!=null){
                        this.form_disposisi = {!! json_encode($model_rincian) !!};
                        
                        $('#tanggal_penyelesaian').val(this.form_disposisi.tanggal_penyelesaian);
                        $('#tanggal_penerimaan').val(this.form_disposisi.tanggal_penerimaan);
                    }
                } 
                else if(this.form.jenis_surat==6){
                    var temp_data = {!! json_encode($model_rincian) !!}
                    if(temp_data!=null){
                        this.form_surat_keputusan = {!! json_encode($model_rincian) !!};
                        this.keputusan = {!! json_encode($list_keputusan) !!};
                        $('#ditetapkan_tanggal').val(this.form.ditetapkan_tanggal);
                    }
                    $('#tentang').summernote('code', this.form_surat_keputusan.tentang);
                    $('#menimbang').summernote('code', this.form_surat_keputusan.menimbang);
                    $('#mengingat').summernote('code', this.form_surat_keputusan.mengingat);
                    $('#menetapkan').summernote('code', this.form_surat_keputusan.menetapkan);
                    $('#tembusan').summernote('code', this.form_surat_keputusan.tembusan);
                }
                else if(this.form.jenis_surat==7){
                    var temp_data = {!! json_encode($model_rincian) !!}
                    if(temp_data!=null){
                        this.form_surat_keterangan = {!! json_encode($model_rincian) !!}; 
                        $('#ditetapkan_tanggal').val(this.form.ditetapkan_tanggal);
                    }
                    $('#isi7').summernote('code', this.form_surat_keterangan.isi); 
                } 

                // if((this.form.jenis_surat>=2 && this.form.jenis_surat<=4) || this.form.jenis_surat==7){
                //     $('#isi').summernote();
                // }
            }
        },
        // changeDate(){
        //     console.log("masuk sini")
        //     this.form.tanggal = $('#tanggal').val();
        //     this.setNomor();
        // },
    }
});

$(document).ready(function() {
    if(vm.id_data=='') vm.setNomor();
    // $("#tanggal").val(vm.form.tanggal);
    vm.setDatas();

    $('.datepicker').datepicker({
        endDate: 'd',
    });
});

$('.date').datepicker()
    .on('change', function(e) {
        vm.form.tanggal = e.target.value;
        vm.setNomor();
});
</script>
@endsection