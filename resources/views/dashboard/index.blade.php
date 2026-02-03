@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
        <div class="col-lg-12 col-md-12">
            <!-- Dinding Bercerita Information -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header bg-info d-flex justify-content-between align-items-center">
                            <h2 class="text-light m-0"><strong>DINDING BERCERITA</strong></h2>
                            <a href="http://mading.farifam.com/" target="_blank" rel="noopener noreferrer" class="btn btn-light btn-sm">
                                <i class="fa fa-external-link"></i> Buka Dinding Bercerita
                            </a>
                        </div>
                        <div class="body">
                            <p class="m-b-0">
                                <i class="fa fa-quote-left text-info"></i> 
                                Ada kesah yang sunyi untuk diceritakan..<br/>
                                Tak semua beban menemukan telinga untuk mendengarkan..<br/>
                                Namun kamu tak harus memikulnya sendirian..<br/>
                                Di sini, semua hadir tanpa nama, tanpa penghakiman..<br/>
                                Hanya kata.. dan tautan perasaan kepedulian..
                                <i class="fa fa-quote-right text-info"></i>
                            </p>
                            <div class="m-t-15">
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#curhat_modal" v-on:click="addCurhat">
                                    <i class="fa fa-commenting-o"></i> Bercerita Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                @include('dashboard.congrats')
            </div>
            <div class="row clearfix">
                @include('dashboard.bulletin')
            </div>

            <div class="row clearfix">
                <div class="card p-4">
                    <b>MONITORING WILKERSTAT 2025 :</b> <br/><br/>
                    <template v-if="label=='prov'">
                    SUMATERA SELATAN
                    </template>
                    <template v-else-if="label=='kab'">
                        <u><a :href="curr_url">SUMATERA SELATAN</a></u>
                        - @{{ label_kab }}
                    </template>
                    <template v-else-if="label=='kec'">
                        <u><a :href="curr_url">SUMATERA SELATAN</a></u>
                        - <u><a :href="curr_url + '?kab=' + kab">@{{ label_kab }}</a></u>
                        - @{{ label_kec }}
                    </template>
                    <template v-else-if="label=='desa'">
                        <u><a :href="curr_url">SUMATERA SELATAN</a></u>
                        - <u><a :href="curr_url + '?kab=' + kab">@{{ label_kab }}</a></u>
                        - <u><a :href="curr_url + '?kab=' + kab + '&kec=' + kec">@{{ label_kec }}</a></u> 
                        - @{{ label_desa }}   
                    </template>
                    <br/><br/>
                    
                    <a :href="api_download_url+'?kab=' + kab + '&kec=' + kec + '&desa=' + desa" class="'btn btn-info btn-sm"><i class='fa fa-file-excel-o'></i> Download Data SLS</a>
                    <br /><br />

                    <div class="table-responsive">
                        <table class="table-bordered m-b-0"  style="min-width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Wilayah</th>
                                    <th colspan="4" class="text-center">SLS</th>
                                    <th colspan="7" class="text-center">Jumlah</th>
                                </tr>

                                <tr>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Selesai</th>
                                    <th class="text-center">Berubah<br/>Batas</th>
                                    <th class="text-center">% Selesai</th>
                                    <th class="text-center">KK</th>
                                    <th class="text-center">BTT</th>
                                    <th class="text-center">BTT<br/>Kosong</th>
                                    <th class="text-center">BKU</th>
                                    <th class="text-center">BBTTN<br/>Non</th>
                                    <th class="text-center">Perkiraan<br/>Muatan<br/>Usaha</th>
                                    <th class="text-center">Total Muatan<br/>(Maks(KK, BTT) + BTT Kosong +<br/>BBTT NonUsaha + Muatan Usaha)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in datas" :key="data.idw">
                                    <td>
                                        <template v-if="label=='prov'" >
                                            <a :href="curr_url + '?kab=' + data.idw">@{{ data.idw }} - @{{ data.nama }}</a>
                                        </template>
                                        <template v-else-if="label=='kab'" >
                                            <a :href="curr_url + '?kab=' + kab + '&kec=' + data.idw">@{{ data.idw }} - @{{ data.nama }}</a>
                                        </template>
                                        <template v-else-if="label=='kec'" >
                                            <a :href="curr_url + '?kab=' + kab + '&kec=' + kec + '&desa=' + data.idw">@{{ data.idw }} - @{{ data.nama }}</a>
                                        </template>
                                        <template v-else-if="label=='desa'" >
                                            @{{ data.idw }} - @{{ data.nama }}
                                        </template>
                                    </td>
                                    <td class="text-center">@{{ data.total }}</td>
                                    <td class="text-center">@{{ data.jumlah_selesai }}</td>
                                    <td class="text-center">@{{ data.jumlah_berubah_batas }}</td>
                                    <td class="text-center"><b>@{{ (data.jumlah_selesai/data.total*100).toFixed(2) }} %</b></td>
                                    <td class="text-center">@{{ data.laporan_jumlah_kk }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_btt }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_btt_kosong }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_bku }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_bbttn_non }}</td>
                                    <td class="text-center">@{{ data.laporan_perkiraan_jumlah }}</td>
                                    <td class="text-center">
                                        <b>
                                            @{{ parseInt(data.laporan_jumlah_maks)+parseInt(data.laporan_jumlah_btt_kosong)+parseInt(data.laporan_jumlah_bbttn_non)+parseInt(data.laporan_perkiraan_jumlah) }}
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    @include('dashboard.list_unit_kerja')
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

        <!-- Modal Form Curhat Anonim -->
        <div class="modal" id="curhat_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <b class="title" id="defaultModalLabel">Bercerita Anonim</b>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" v-model="curhat_form_id_data">
                        
                        <div class="form-group">
                            <label>Ceritakan apa yang ingin Anda sampaikan: <span class="text-danger">*</span></label>
                            <div class="form-line">
                                <textarea v-model="curhat_form_content" class="form-control" rows="8" placeholder="Tuliskan cerita Anda di sini... Identitas Anda tidak kami catat."></textarea>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Catatan:</strong> Semua curhat yang masuk akan melalui proses verifikasi terlebih dahulu sebelum ditampilkan.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save-curhat-btn">KIRIM</button>
                        <button type="button" class="btn btn-simple" data-dismiss="modal">TUTUP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
    var vm = new Vue({  
        el: "#app_vue",
        data:  {
            datas: [],
            kab: {!! json_encode($kab) !!},
            kec: {!! json_encode($kec) !!},
            desa: {!! json_encode($desa) !!},
            label: '',
            label_kab: '',
            label_kec: '',
            label_desa: '',
            api_url: 'https://st23.bpssumsel.com/api/dashboard/wilkerstat2025',
            curr_url: {!! json_encode(url('dashboard/data/wilker2025')) !!},
            curhat_form_id_data: '',
            curhat_form_content: '',
            curhat_form_status_verifikasi: 1,
        },
        methods: {
            setDatas: function(){
                var self = this;
                $('#wait_progres').modal('show');

                $.ajax({
                    url : self.api_url,
                    method : 'get',
                    dataType: 'json',
                    data:{
                        kab: self.kab, 
                        kec: self.kec, 
                        desa: self.desa, 
                    },
                }).done(function (data) {
                    self.datas = data.datas;
                    self.label = data.label;
                    self.label_kab = data.label_kab;
                    self.label_kec = data.label_kec;
                    self.label_desa = data.label_desa;
                    console.log(self.label)
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            addCurhat: function (event) {
                var self = this;
                if (event) {
                    self.curhat_form_id_data = '';
                    self.curhat_form_content = '';
                    self.curhat_form_status_verifikasi = 1;
                }
            },
            saveCurhat: function () {
                var self = this;
                
                // Validate content
                if (!self.curhat_form_content || self.curhat_form_content.trim() === '') {
                    alert('Mohon isi cerita Anda terlebih dahulu.');
                    return;
                }
                
                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    url : "{{ url('/curhat_anon') }}",
                    method : 'post',
                    dataType: 'json',
                    data: {
                        form_id_data: self.curhat_form_id_data || '',
                        form_content: self.curhat_form_content,
                        form_status_verifikasi: self.curhat_form_status_verifikasi || 1 // Default to 1 (Belum Verifikasi) for anonymous submissions
                    },
                }).done(function (data) {
                    $('#curhat_modal').modal('hide');
                    $('#wait_progres').modal('hide');
                    alert('Terima kasih! Curhat Anda telah terkirim dan akan melalui proses verifikasi.');
                    self.curhat_form_content = '';
                    self.curhat_form_id_data = '';
                    self.curhat_form_status_verifikasi = 1;
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                    alert('Maaf, terjadi kesalahan saat mengirim curhat. Silakan coba lagi.');
                });
            },
        }
    });

    $(document).ready(function() {
        vm.setDatas(); 
    });

    // Handle save curhat button click
    $( "#save-curhat-btn" ).click(function(e) {
        vm.saveCurhat();
    });
    </script>
@endsection
