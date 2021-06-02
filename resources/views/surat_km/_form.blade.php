<div id="app_vue">
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ $model->attributes()['jenis_surat'] }}:</label>
                <select class="form-control {{($errors->first('jenis_surat') ? ' parsley-error' : '')}}" v-model="jenis_surat" name="jenis_surat" @change="setNomor">
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

    <template v-if="jenis_surat==1">
        @include('surat_km._form_surat_masuk')
    </template>
    
    <template v-if="jenis_surat==2">
        @include('surat_km._form_surat_keluar')
    </template>
    
    <template v-if="jenis_surat==3">
        @include('surat_km._form_memorandum')
    </template>
    
    <template v-if="jenis_surat==4">
        @include('surat_km._form_surat_pengantar')
    </template>
    
    <template v-if="jenis_surat==5">
        @include('surat_km._form_disposisi')
    </template>
    
    <template v-if="jenis_surat==6">
        @include('surat_km._form_surat_keputusan')
    </template>
    
    <template v-if="jenis_surat==7">
        @include('surat_km._form_surat_keterangan')
    </template>

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
        jenis_surat: {!! json_encode($model->jenis_surat) !!},
        kode_unit_kerja: '',
        klasifikasi_arsip: '',
        tingkat_keamanan: '',
        tanggal: {!! json_encode(date('m/d/Y', strtotime($model->tanggal))) !!},
        nomor_urut: {!! json_encode($model->nomor_urut) !!},
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
            var split_tanggal = this.tanggal.split("/");
            if(split_tanggal.length==0) return "";
            else return split_tanggal[0]
        },
        tahun: function () {
            var split_tanggal = this.tanggal.split("/");
            if(split_tanggal.length==0) return "";
            else return split_tanggal[2]
        },
    },
    methods: {
        setNomor: function(){
            var self = this;
            $('#wait_progres').modal('show');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                url :  "{{ url('/surat_km/nomor_urut/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    jenis_surat: self.jenis_surat, 
                    tanggal: self.tanggal,
                },
            }).done(function (data) {
                self.nomor_urut = data.total;
             
                if((self.jenis_surat>=2 && self.jenis_surat<=4) || self.jenis_surat==7){
                    $('#isi').summernote();
                }
                
                if(self.jenis_surat==3){
                    $('#tembusan').summernote();
                }
                
                
                if(self.jenis_surat==6){
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
    }
});

$(document).ready(function() {
    vm.setNomor();
    
});

$('.date').datepicker()
    .on('changeDate', function(e) {
        vm.tanggal = $('#tanggal').val();
        vm.setNomor();
});
</script>
@endsection