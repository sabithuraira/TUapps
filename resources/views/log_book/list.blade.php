<div class="table-responsive">
    <table class="table-bordered m-b-0">
        <thead>
            <tr>
                <th>No</th><th></th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Durasi & waktu</th>
                <th style="min-width:55%" class="text-center">Isi & Hasil</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td>
                    <a href="#" role="button" v-on:click="updateLogBook" data-toggle="modal" 
                            :data-id="data.id" :data-tanggal="data.real_tanggal" 
                            :data-waktu_mulai="data.waktu_mulai" :data-waktu_selesai="data.waktu_selesai" 
                            :data-isi="data.isi" :data-hasil="data.hasil" 
                            :data-volume="data.volume" :data-satuan="data.satuan" 
                            :data-pemberi_tugas="data.pemberi_tugas_id" 
                            data-target="#add_logbooks"> <i class="icon-pencil"></i></a>
                    &nbsp;
                    <a :data-id="data.id" v-on:click="delLogBook(data.id)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    &nbsp
                    @{{ index+1 }}
                </td>
                <td class="text-center">
                    <a v-if="data.ckp_id==null || data.ckp_id==''" href="#" role="button" v-on:click="sendCkpId" 
                            data-toggle="modal" :data-id="data.id" 
                            data-target="#send_ckp"> 
                        <i class="icon-arrow-up"></i>
                        <p class='text-muted small'>Jadikan CKP</p>
                    </a>
                </td>
                
                <td class="text-center">
                    Pemberi Tugas: @{{ data.pemberi_tugas }}
                    <p class="text-muted">Volume(satuan): @{{ data.volume }} (@{{ data.satuan }})</p>
                    <span class="text-muted">Progres: @{{ data.status_penyelesaian }} %</span>
                </td>

                <td class="text-center">
                    <span class="badge badge-pill badge-dark">@{{ durasi(data.waktu_selesai, data.waktu_mulai) }}</span>
                    <br/>
                    @{{ data.tanggal }}
                    <p class="text-muted">Pukul: @{{ data.waktu_mulai }} - @{{ data.waktu_selesai }}</p>
                </td>
                <td>
                    @{{ data.isi }}
                    <p class="text-muted">Hasil: @{{ data.hasil }}</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@include('log_book.modal_form')
<div class="modal" id="send_ckp" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Masukkan Log Book pada:</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="sendToCkp(1)">Kegiatan Utama</button>
                <button type="button" class="btn btn-primary" v-on:click="sendToCkp(2)">Kegiatan Tambahan</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

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
        start: {!! json_encode($start) !!},
        end: {!! json_encode($end) !!},
        pathname : window.location.pathname,
        form_id: 0, form_tanggal: '', form_waktu_mulai: '', form_waktu_selesai: '',
        form_isi: '', form_hasil: '', form_volume: '',  form_satuan: '',
        form_pemberi_tugas: '', 
        ckp_id: 0,
    },
    methods: {
        durasi: function(val1, val2){
            var timeStart = new Date("01/01/2007 " + val2);
            var timeEnd = new Date("01/01/2007 " + val1);

            var timeDiff = timeEnd - timeStart;   
            var minuteDiff = timeDiff/60/1000;

            var num = minuteDiff;
            var hours = (num / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);

            return rhours + " jam " + rminutes + " menit";
        },
        addLogBook: function (event) {
            var self = this;
            if (event) {
                self.form_id = 0;
                self.form_tanggal = '';
                $('#form_tanggal').val(self.form_tanggal);
                self.form_waktu_mulai = '';
                self.form_waktu_selesai = '';
                self.form_isi = '';
                self.form_hasil = '';
                self.form_volume = '';
                self.form_satuan = '';
                self.form_pemberi_tugas = '';
            }
        },
        updateLogBook: function (event) {
            var self = this;
            if (event) {
                self.form_id = event.currentTarget.getAttribute('data-id');
                self.form_tanggal = event.currentTarget.getAttribute('data-tanggal');
                $('#form_tanggal').val(self.form_tanggal);
                self.form_waktu_mulai = event.currentTarget.getAttribute('data-waktu_mulai');
                self.form_waktu_selesai = event.currentTarget.getAttribute('data-waktu_selesai');
                self.form_isi = event.currentTarget.getAttribute('data-isi');
                self.form_hasil = event.currentTarget.getAttribute('data-hasil');
                self.form_volume = event.currentTarget.getAttribute('data-volume');
                self.form_satuan = event.currentTarget.getAttribute('data-satuan');
                self.form_pemberi_tugas = event.currentTarget.getAttribute('data-pemberi_tugas');
            }
        },
        saveLogBook: function () {
            var self = this;

            if(self.form_tanggal.length==0 || self.form_waktu_mulai.length==0 || self.form_waktu_selesai.length==0 || 
                self.form_isi.length==0 || self.form_volume.length==0 || self.form_satuan.length==0 || 
                self.form_pemberi_tugas.length==0){
                alert("Pastikan isian tanggal, waku mulai - selesai, isi, volume, satuan dan pemberi tugas telah diisi");
            }
            else{
                if(isNaN(self.form_volume)){
                    alert("Isian 'Volume' harus angka");    
                }
                else{
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                    $.ajax({
                        url :  self.pathname,
                        method : 'post',
                        dataType: 'json',
                        data:{
                            id: self.form_id,
                            tanggal: self.form_tanggal,
                            waktu_mulai: self.form_waktu_mulai,
                            waktu_selesai: self.form_waktu_selesai, 
                            isi: self.form_isi, 
                            hasil: self.form_hasil,
                            volume: self.form_volume,
                            satuan: self.form_satuan,
                            pemberi_tugas: self.form_pemberi_tugas,
                        },
                    }).done(function (data) {
                        $('#add_logbooks').modal('hide');
                        self.setDatas();
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                }  
            }
        },
        delLogBook: function (idnya) {
            if (confirm('anda yakin mau menghapus data ini?')) {
                var self = this;

                $('#send_ckp').modal('hide');
                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                $.ajax({
                    url :  self.pathname + '/destroy_logbook/' + idnya,
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
        sendCkpId: function (event) {
            var self = this;
            if (event) {
                self.ckp_id = event.currentTarget.getAttribute('data-id');
            }
        },
        sendToCkp: function (jenis) {
            var self = this;

            $('#send_ckp').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + '/send_to_ckp',
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.ckp_id,
                    jenis: jenis,
                },
            }).done(function (data) {
                $('#wait_progress').modal('hide');
                self.setDatas();
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            })
            $.ajax({
                url : self.pathname+"/data_log_book",
                method : 'post',
                dataType: 'json',
                data:{
                    start: self.start, 
                    end: self.end, 
                },
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        }
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

$('#start').change(function() {
    vm.start = this.value;
    vm.setDatas();
});

$('#end').change(function() {
    vm.end = this.value;
    vm.setDatas();
});

$('#form_tanggal').change(function() {
    vm.form_tanggal = this.value;
});

$('#form_waktu_mulai').change(function() {
    vm.form_waktu_mulai = this.value;
});

$('#form_waktu_selesai').change(function() {
    vm.form_waktu_selesai = this.value;
});
</script>
@endsection