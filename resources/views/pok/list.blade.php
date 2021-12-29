<div id="app_vue" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas)==0)
        <thead>
            <tr><th>Tidak ditemukan data</th></tr>
        </thead>
        @else
            <thead>
                <tr class="text-center">
                    <th rowspan="2">KODE</th>
                    <th rowspan="2">PROGRAM/KEGIATAN/KRO/RO/KOMPONEN/SUB KOMPONEN/DETIL</th>
                    <th colspan="4">PERHITUNGAN TAHUN {{ $tahun }}</th>
                    <th rowspan="2">ESTIMASI</th>
                    <th rowspan="2">REALISASI</th>
                    <th rowspan="2">AKSI</th>
                </tr>
                
                <tr class="text-center">
                    <th>VOLUME</th><th>SATUAN</th><th>HARGA SATUAN</th><th>JUMLAH BIAYA</th>
                </tr>
            </thead>

            <tbody>
                @php 
                    $id_program = '';
                    $id_aktivitas = '';
                    $id_kro = '';
                    $id_ro = '';
                    $id_komponen = '';
                    $id_sub_komponen = '';
                    $id_mata_anggaran = '';
                @endphp
                @foreach($datas as $data)
                    @if($id_program!=$data->id_program)
                        @php 
                            $id_program = $data->id_program;
                            $program = \App\PokProgram::find($id_program);
                        @endphp
                        <tr>
                            <td class="text-center"><b>{{ $program->kode }}</b></td>
                            <td><b>{{ $program->label }}</b></td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    
                    @if($id_aktivitas!=$data->id_aktivitas)
                        @php 
                            $id_aktivitas = $data->id_aktivitas;
                            $aktivitas = \App\PokAktivitas::find($id_aktivitas);
                        @endphp
                        <tr>
                            <td class="text-center"><b class="text-primary">{{ $aktivitas->kode }}</b></td>
                            <td><b class="text-primary">{{ $aktivitas->label }}</b></td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    
                    @if($id_kro!=$data->id_kro)
                        @php 
                            $id_kro = $data->id_kro;
                            $kro = \App\PokKro::find($id_kro);
                        @endphp
                        <tr>
                            <td class="text-center"><b class="text-danger">{{ $kro->kode }}</b></td>
                            <td><b class="text-danger">{{ $kro->label }}</b></td>
                            <td><b class="text-danger">{{ $kro->volume }}</b></td>
                            <td class="text-center"><b class="text-danger">{{ $kro->satuan }}</b></td>
                            <td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    
                    @if($id_ro!=$data->id_ro)
                        @php 
                            $id_ro = $data->id_ro;
                            $ro = \App\PokRo::find($id_ro);
                        @endphp
                        <tr>
                            <td class="text-center"><b>{{ $ro->kode }}</b></td>
                            <td><b>{{ $ro->label }}</b></td>
                            <td><b class="text-danger">{{ $ro->volume }}</b></td>
                            <td class="text-center"><b class="text-danger">{{ $ro->satuan }}</b></td>
                            <td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    
                    @if($id_komponen!=$data->id_komponen)
                        @php 
                            $id_komponen = $data->id_komponen;
                        @endphp
                        <tr>
                            <td class="text-center"><b>{{ $data->kode_komponen }}</b></td>
                            <td><b>{{ $data->label_komponen }}</b></td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    
                    @if($id_sub_komponen!=$data->id_sub_komponen)
                        @php 
                            $id_sub_komponen = $data->id_sub_komponen;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $data->kode_sub_komponen }}</td>
                            <td>{{ $data->label_sub_komponen }}</td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    
                    @if($id_mata_anggaran!=$data->id_mata_anggaran)
                        @php 
                            $id_mata_anggaran = $data->id_mata_anggaran;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $data->kode_mata_anggaran }}</td>
                            <td>{{ $data->label_mata_anggaran }}</td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif

                    <tr>
                        <td></td>
                        <td>{{ $data->label }}</td>
                        <td>{{ $data->volume }}</td>
                        <td class="text-center">{{ $data->satuan }}</td>
                        <td class="text-right">{{ number_format($data->harga_satuan) }}</td>
                        <td class="text-right">{{ number_format($data->harga_jumlah) }}</td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#" role="button"  
                                    data-target="#set_aktif"> 
                                    <i class="icon-calendar text-info"></i>
                                    <p class='text-info small'>History</p>
                                </a>
                                &nbsp;&nbsp;
                                <a href="#">
                                    <i class="icon-user text-info"></i> 
                                    <p class='text-info small'>Set PJ</p>
                                </a>
                            </div>
                            
                            @hasanyrole('superadmin|kuasa_anggaran')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#">
                                    <i class="icon-note text-info"></i> 
                                    <p class='text-info small'>Estimasi</p>
                                </a>
                                &nbsp;&nbsp;
                                <a href="#">
                                    <i class="icon-note text-info"></i> 
                                    <p class='text-info small'>Realisasi</p>
                                </a>
                            </div>
                            @endhasanyrole

                            @hasanyrole('superadmin|kuasa_anggaran')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#">
                                    <i class="icon-pencil text-info"></i> 
                                    <p class='text-info small'>Edit</p>
                                </a>
                                &nbsp;&nbsp;
                                <a href="#">
                                    <i class="icon-magic-wand text-info"></i> 
                                    <p class='text-info small'>Revisi</p>
                                </a>
                            </div>
                            @endhasanyrole
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    
    @include('pok.modal_pj')

    <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200"
                            height="200" alt="Loading..."></div>
                    <h4 class="text-center">Please wait...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<meta name="csrf-token" content="@csrf">
<style type="text/css">
    * {
        font-family: Segoe UI, Arial, sans-serif;
    }

    table {
        font-size: small;
        border-collapse: collapse;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: small;
    }
</style>
<link rel="stylesheet"
    href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
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
            cur_pj_id: '',
            cur_pj_label: '',
            form_pj: {
                id_pegawai: '',
                id_rincian: '',
            },
        },
        methods: {
            setPj: function (jenis) {
                var self = this;
                
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
            // updateLogBook: function (event) {
            //     var self = this;
            //     if (event) {
            //         self.form_id = event.currentTarget.getAttribute('data-id');
            //         self.form_tanggal = event.currentTarget.getAttribute('data-tanggal');
            //         $('#form_tanggal').val(self.form_tanggal);
            //         self.form_waktu_mulai = event.currentTarget.getAttribute('data-waktu_mulai');
            //         self.form_waktu_selesai = event.currentTarget.getAttribute('data-waktu_selesai');
            //         self.form_isi = event.currentTarget.getAttribute('data-isi');
            //         self.form_hasil = event.currentTarget.getAttribute('data-hasil');
            //         self.form_volume = event.currentTarget.getAttribute('data-volume');
            //         self.form_satuan = event.currentTarget.getAttribute('data-satuan');
            //         self.form_pemberi_tugas = event.currentTarget.getAttribute('data-pemberi_tugas');
            //     }
            // },
            // addLogBook: function (event) {
            //     var self = this;
            //     if (event) {
            //         self.form_id = 0;
            //         self.form_tanggal = '';
            //         $('#form_tanggal').val(self.form_tanggal);
            //         self.form_waktu_mulai = '';
            //         self.form_waktu_selesai = '';
            //         self.form_isi = '';
            //         self.form_hasil = '';
            //         self.form_volume = '';
            //         self.form_satuan = '';
            //     }
            // },
            // updateLogBook: function (event) {
            //     var self = this;
            //     if (event) {
            //         self.form_id = event.currentTarget.getAttribute('data-id');
            //         self.form_tanggal = event.currentTarget.getAttribute('data-tanggal');
            //         $('#form_tanggal').val(self.form_tanggal);
            //         self.form_waktu_mulai = event.currentTarget.getAttribute('data-waktu_mulai');
            //         self.form_waktu_selesai = event.currentTarget.getAttribute('data-waktu_selesai');
            //         self.form_isi = event.currentTarget.getAttribute('data-isi');
            //         self.form_hasil = event.currentTarget.getAttribute('data-hasil');
            //         self.form_volume = event.currentTarget.getAttribute('data-volume');
            //         self.form_satuan = event.currentTarget.getAttribute('data-satuan');
            //         self.form_pemberi_tugas = event.currentTarget.getAttribute('data-pemberi_tugas');
            //     }
            // },
            // saveLogBook: function () {
            //     var self = this;

            //     if(self.form_tanggal.length==0 || self.form_waktu_mulai.length==0 || self.form_waktu_mulai.length==0 || 
            //         self.form_isi.length==0 || self.form_volume.length==0 || self.form_satuan.length==0 || 
            //         self.form_pemberi_tugas.length==0){
            //         alert("Pastikan isian tanggal, waku mulai - selesai, isi, volume, satuan dan pemberi tugas telah diisi");
            //     }
            //     else{
            //         if(isNaN(self.form_volume)){
            //             alert("Isian 'Volume' harus angka");    
            //         }
            //         else{
            //             $('#wait_progres').modal('show');
            //             $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            //             $.ajax({
            //                 url :  self.pathname,
            //                 method : 'post',
            //                 dataType: 'json',
            //                 data:{
            //                     id: self.form_id,
            //                     tanggal: self.form_tanggal,
            //                     waktu_mulai: self.form_waktu_mulai,
            //                     waktu_selesai: self.form_waktu_selesai, 
            //                     isi: self.form_isi, 
            //                     hasil: self.form_hasil,
            //                     volume: self.form_volume,
            //                     satuan: self.form_satuan,
            //                     pemberi_tugas: self.form_pemberi_tugas,
            //                 },
            //             }).done(function (data) {
            //                 $('#add_logbooks').modal('hide');
            //                 self.setDatas();
            //             }).fail(function (msg) {
            //                 console.log(JSON.stringify(msg));
            //                 $('#wait_progres').modal('hide');
            //             });
            //         }  
            //     }
            // },
            // delLogBook: function (idnya) {
            //     if (confirm('anda yakin mau menghapus data ini?')) {
            //         var self = this;

            //         $('#send_ckp').modal('hide');
            //         $('#wait_progres').modal('show');
            //         $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            //         $.ajax({
            //             url :  self.pathname + '/destroy_logbook/' + idnya,
            //             method : 'get',
            //             dataType: 'json',
            //         }).done(function (data) {
            //             $('#wait_progress').modal('hide');
            //             self.setDatas();
            //         }).fail(function (msg) {
            //             console.log(JSON.stringify(msg));
            //             $('#wait_progres').modal('hide');
            //         });
            //     }
            // },
            // sendCkpId: function (event) {
            //     var self = this;
            //     if (event) {
            //         self.ckp_id = event.currentTarget.getAttribute('data-id');
            //     }
            // },
            // setDatas: function(){
            //     var self = this;
            //     $('#wait_progres').modal('show');
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //         }
            //     })
            //     $.ajax({
            //         url : self.pathname+"/data_log_book",
            //         method : 'post',
            //         dataType: 'json',
            //         data:{
            //             start: self.start, 
            //             end: self.end, 
            //         },
            //     }).done(function (data) {
            //         self.datas = data.datas;
            //         $('#wait_progres').modal('hide');
            //     }).fail(function (msg) {
            //         console.log(JSON.stringify(msg));
            //         $('#wait_progres').modal('hide');
            //     });
            // }
        }
    });

    $(document).ready(function() {
        $('.time24').inputmask('hh:mm', { placeholder: '__:__', alias: 'time24', hourFormat: '24' });
        vm.setDatas();
        
        $('.datepicker').datepicker({
            endDate: 'd',
        });
    });
</script>
@endsection