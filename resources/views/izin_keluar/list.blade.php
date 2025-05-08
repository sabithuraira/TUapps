<div class="table-responsive">
    <table class="table-bordered m-b-0"  style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Waktu</th>
                <th class="text-center" style="width: 60%" >Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="px-2">
                    <a href="#" role="button" v-on:click="updateIzinKeluar" data-toggle="modal" 
                            :data-id="data.id" :data-tanggal="data.tanggal" 
                            :data-start="data.start" :data-end="data.end" 
                            :data-jenis_keperluan="data.jenis_keperluan" 
                            :data-keterangan="data.keterangan" :data-pegawai_nip="data.pegawai_nip" 
                            :data-total_minutes="data.total_minutes" 
                            data-target="#add_izin_keluars"> <i class="icon-pencil"></i></a>
                    
                    &nbsp;
                    @{{ index+1 }}
                </td>

                <td class="text-center pt-2">
                    @{{ data.tanggal }} pukul: @{{ data.start }} - @{{ data.end }}
                    <p class="text-muted">Durasi: @{{ data.total_minutes }} Menit</p>
                </td>
                
                <td class="px-2">
                    <span class="text-muted" v-if="data.jenis_keperluan==1">Keperluan Dinas</span>
                    <span class="text-muted" v-else>Keperluan Pribadi</span>
                    <br/>
                    @{{ data.keterangan }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

@include('izin_keluar.modal_form')
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

@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
    <style type="text/css">
        * {font-family: Segoe UI, Arial, sans-serif;}
        table{font-size: small;border-collapse: collapse;}
        tfoot tr td{font-weight: bold;font-size: small;}
    </style>
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script> <!-- Select2 Js -->
<script>
                
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        datas: [],
        month: {!! json_encode($month) !!},
        year: {!! json_encode($year) !!},
        pathname : window.location.pathname,
        form: {
            id: 0, pegawai_nip: '', keterangan: '',
            tanggal: '', start: '', end: '', jenis_keperluan: 2
        }
    },
    watch: {
        month: function (val) {
            this.setDatas();
        },
        year: function (val) {
            this.setDatas();
        },
    },
    methods: {
        addIzinKeluar: function (event) {
            var self = this;
            if (event) {
                self.form = {
                    id: 0, pegawai_nip: '', keterangan: '',
                    tanggal: '', start: '', end: '', jenis_keperluan: 2
                }
                $('#form_tanggal').val(self.form.tanggal);
                $('#form_start').removeAttr('disabled');
                $('#form_end').removeAttr('disabled');
            }
        },
        updateIzinKeluar: function (event) {
            var self = this;
            if (event) {
                self.form.id = event.currentTarget.getAttribute('data-id');
                self.form.keterangan = event.currentTarget.getAttribute('data-keterangan');
                self.form.pegawai_nip = event.currentTarget.getAttribute('data-pegawai_nip');
                self.form.jenis_keperluan = event.currentTarget.getAttribute('data-jenis_keperluan');
                self.form.tanggal = event.currentTarget.getAttribute('data-tanggal');
                $('#form_tanggal').val(self.form.tanggal);
                self.form.start = event.currentTarget.getAttribute('data-start');
                self.form.end = event.currentTarget.getAttribute('data-end');

                if(self.form.start!='...')  $('#form_start').attr('disabled','disabled');
                else $('#form_start').removeAttr('disabled');

                if(self.form.end!='...') $('#form_end').attr('disabled','disabled');
                else $('#form_end').removeAttr('disabled');
              }
        },
        saveIzinKeluar: function () {
            var self = this;

            if(self.form.tanggal.length==0 ||   
                self.form.keterangan.length==0 || self.form.start.length==0){
                alert("Pastikan isian tanggal, waktu mulai dan keterangan telah diisi");
            }
            else{
                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                $.ajax({
                    url :  self.pathname,
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.form.id,
                        tanggal: self.form.tanggal,
                        start: self.form.start,
                        end: self.form.end, 
                        keterangan: self.form.keterangan, 
                        jenis_keperluan: self.form.jenis_keperluan, 
                    },
                }).done(function (data) {
                    $('#add_izin_keluars').modal('hide');
                    self.setDatas();
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            }
        },
        delIzinKeluar: function (idnya) {
            if (confirm('anda yakin mau menghapus data ini?')) {
                var self = this;

                $('#send_ckp').modal('hide');
                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                $.ajax({
                    url :  self.pathname + '/destroy_izinkeluar/' + idnya,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    $('#wait_progress').modal('hide');
                    self.setDatas();
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            }
        },
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            })
            $.ajax({
                url : self.pathname+"/data_izin_keluar",
                method : 'post',
                dataType: 'json',
                data:{
                    start: self.month, 
                    end: self.year, 
                },
            }).done(function (data) {
                self.datas = data.datas;
                // console.log(self.datas)
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        }, 
    }
});

$(document).ready(function() {
    $('.time24').inputmask('hh:mm', { placeholder: '__:__', alias: 'time24', hourFormat: '24' });
    $('.select2').select2();
    vm.setDatas();
    
    $('.datepicker').datepicker({
        endDate: 'd',
    });
    
});

$('#form_tanggal').change(function() {
    vm.form.tanggal = this.value;
});

$('#form_start').change(function() {
    vm.form.start = this.value;
});

$('#form_end').change(function() {
    vm.form.end = this.value;
});
</script>
@endsection