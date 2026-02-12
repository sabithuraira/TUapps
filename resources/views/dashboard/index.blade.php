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
            <!-- Dinding Bercerita & SPADA - 50% / 50% -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6" :class="{ 'col-12': !spadaQuestion }">
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
                <div class="col-lg-6 col-md-6" v-if="spadaQuestion">
                    <div class="card">
                        <div class="header bg-primary d-flex justify-content-between align-items-center">
                            <h2 class="text-light m-0"><strong>SPADA, Satu Pertanyaan Aspirasi dan Afirmasi</strong></h2>
                        </div>
                        <div class="body">
                            <p class="spada-question-text font-weight-bold text-dark m-b-20" style="font-size: 1.1rem; line-height: 1.6;">
                                @{{ spadaQuestion.question }}
                            </p>
                            <div class="form-group">
                                <label class="control-label">Jawaban Anda:</label>
                                <textarea v-if="spadaQuestion.type_question == 1" v-model="spadaAnswer" class="form-control" rows="4" placeholder="Tulis jawaban Anda..."></textarea>
                                <input v-else type="text" v-model="spadaAnswer" class="form-control" placeholder="Tulis jawaban Anda (maks. 200 karakter)" maxlength="200">
                                <small v-if="spadaQuestion.type_question != 1" class="text-muted">@{{ (spadaAnswer || '').length }}/200 karakter</small>
                            </div>
                            <div class="m-t-15">
                                <button type="button" class="btn btn-primary" :disabled="spadaSubmitting" @click="submitSpadaAnswer">
                                    <span v-if="!spadaSubmitting"><i class="fa fa-paper-plane"></i> Kirim Jawaban</span>
                                    <span v-else><i class="fa fa-spinner fa-spin"></i> Mengirim...</span>
                                </button>
                            </div>
                            <div v-if="spadaSuccessMessage" class="alert alert-success m-t-15 m-b-0">
                                <i class="fa fa-check-circle"></i> @{{ spadaSuccessMessage }}
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
                        <button type="button" class="btn btn-primary" id="save-curhat-btn" :disabled="curhatSubmitting">
                            <span v-if="!curhatSubmitting"><i class="fa fa-send"></i> KIRIM</span>
                            <span v-else><i class="fa fa-spinner fa-spin"></i> Mengirim...</span>
                        </button>
                        <button type="button" class="btn btn-simple" data-dismiss="modal" :disabled="curhatSubmitting">TUTUP</button>
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
            curhatSubmitting: false,
            curhatApiUrl: window.API_CONFIG ? window.API_CONFIG.MADING_CURHAT_ANON_API : 'https://mading.farifam.com/api/curhat-anon',
            spadaQuestion: null,
            spadaAnswer: '',
            spadaSubmitting: false,
            spadaSuccessMessage: '',
            spadaActiveTodayUrl: (window.API_CONFIG && window.API_CONFIG.MADING_SPADA_QUESTION_API) ? (window.API_CONFIG.MADING_SPADA_QUESTION_API + '/active-today') : 'http://mading.farifam.com/api/spada-question/active-today',
            spadaAnswerUrl: (window.API_CONFIG && window.API_CONFIG.MADING_API_URL) ? (window.API_CONFIG.MADING_API_URL + '/spada-answer') : 'http://mading.farifam.com/api/spada-answer',
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
                
                self.curhatSubmitting = true;
                $('#wait_progres').modal('show');
                
                $.ajax({
                    url: self.curhatApiUrl,
                    method: 'post',
                    dataType: 'json',
                    crossDomain: true,
                    data: {
                        form_id_data: self.curhat_form_id_data || 0,
                        form_content: self.curhat_form_content,
                        form_status_verifikasi: self.curhat_form_status_verifikasi || 1
                    },
                }).done(function (data) {
                    $('#wait_progres').modal('hide');
                    self.curhatSubmitting = false;
                    $('#curhat_modal').modal('hide');
                    alert('Terima kasih! Curhat Anda telah terkirim dan akan melalui proses verifikasi.');
                    self.curhat_form_content = '';
                    self.curhat_form_id_data = '';
                    self.curhat_form_status_verifikasi = 1;
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                    self.curhatSubmitting = false;
                    alert('Maaf, terjadi kesalahan saat mengirim curhat. Silakan coba lagi.');
                });
            },
            loadSpadaActiveToday: function () {
                var self = this;
                $.ajax({
                    url: self.spadaActiveTodayUrl,
                    method: 'GET',
                    dataType: 'json',
                    crossDomain: true,
                }).done(function (data) {
                    var q = (data && data.data) ? data.data : (data && (data.id || data.question) ? data : null);
                    self.spadaQuestion = q;
                }).fail(function () {
                    self.spadaQuestion = null;
                });
            },
            submitSpadaAnswer: function () {
                var self = this;
                if (!self.spadaQuestion || !self.spadaQuestion.id) return;
                var answer = (self.spadaAnswer || '').trim();
                if (!answer) {
                    alert('Mohon isi jawaban Anda.');
                    return;
                }
                if (self.spadaQuestion.type_question != 1 && answer.length > 200) {
                    alert('Jawaban maksimal 200 karakter.');
                    return;
                }
                self.spadaSubmitting = true;
                self.spadaSuccessMessage = '';
                $.ajax({
                    url: self.spadaAnswerUrl,
                    method: 'POST',
                    dataType: 'json',
                    crossDomain: true,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        question_id: self.spadaQuestion.id,
                        answer: answer,
                        status_approve: 2,
                    }),
                }).done(function (data) {
                    self.spadaSubmitting = false;
                    self.spadaSuccessMessage = 'Terima kasih! Jawaban Anda telah berhasil dikirim.';
                    self.spadaAnswer = '';
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    self.spadaSubmitting = false;
                    alert('Gagal mengirim jawaban. Silakan coba lagi.');
                });
            },
        }
    });

    $(document).ready(function() {
        vm.setDatas();
        vm.loadSpadaActiveToday();
    });

    // Handle save curhat button click
    $( "#save-curhat-btn" ).click(function(e) {
        vm.saveCurhat();
    });
    </script>
@endsection
