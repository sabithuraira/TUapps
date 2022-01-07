<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
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
                    <a href="#" role="button" v-on:click="updateRencanaKerja" data-toggle="modal" 
                            :data-id="data.id" :data-tanggal="data.real_tanggal" 
                            :data-waktu_mulai="data.waktu_mulai" :data-waktu_selesai="data.waktu_selesai" 
                            :data-isi="data.isi" :data-hasil="data.hasil" 
                            :data-volume="data.volume" :data-satuan="data.satuan" 
                            :data-pemberi_tugas="data.pemberi_tugas" 
                            data-target="#add_rencana_kerja"> <i class="icon-pencil"></i></a>
                    &nbsp;
                    <a :data-id="data.id" v-on:click="delRencanaKerja(data.id)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    &nbsp
                    @{{ index+1 }}
                </td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="setFormId" 
                            data-toggle="modal" :data-id="data.id" 
                            data-target="#send_ckp"> 
                        <i class="icon-arrow-up"></i>
                        <p class='text-muted small'>Jadikan Log Book</p>
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

@include('rencana_kerja.modal_form')
<div class="modal" id="send_ckp" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin menyatakan pekerjaan ini selesai dan menjadikan "Rencana Kerja" ini menjadi Log Book?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="sendRencanaKerja">Iya</button>
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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
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
        addRencanaKerja: function (event) {
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
                self.form_pemberi_tugas = {!! json_encode($pemberi_tugas) !!};
            }
        },
        updateRencanaKerja: function (event) {
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
        saveRencanaKerja: function () {
            var self = this;

            if(self.form_tanggal.length==0 || self.form_waktu_mulai.length==0 || self.form_waktu_mulai.length==0 || 
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
                        $('#add_rencana_kerja').modal('hide');
                        self.setDatas();
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                }  
            }
        },
        delRencanaKerja: function (idnya) {
            if (confirm('anda yakin mau menghapus data ini?')) {
                var self = this;

                $('#send_ckp').modal('hide');
                $('#wait_progres').modal('show');
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                $.ajax({
                    url :  self.pathname + '/destroy_rencana_kerja/' + idnya,
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
        setFormId: function (event) {
            var self = this;
            if (event) {
                self.form_id = event.currentTarget.getAttribute('data-id');
            }
        },
        sendRencanaKerja: function (jenis) {
            var self = this;

            $('#send_ckp').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + '/send_to_logbook',
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.form_id,
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : self.pathname+"/data_rencana_kerja",
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
    vm.setDatas();
    
    $('.datepicker').datepicker({
        // endDate: 'd',
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