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
                <div :class="spadaQuestion ? 'col-lg-6 col-md-6' : 'col-lg-12 col-md-12'">
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
                                <label class="control-label">Jawaban Anda (maks. @{{ spadaMaxLength }} karakter):</label>
                                <input v-if="spadaMaxLength <= 200" type="text" v-model="spadaAnswer" class="form-control" :maxlength="spadaMaxLength" :placeholder="'Ketik jawaban di sini (maks. ' + spadaMaxLength + ' karakter)...'">
                                <textarea v-else v-model="spadaAnswer" class="form-control" :maxlength="spadaMaxLength" rows="4" placeholder="Ketik jawaban di sini..."></textarea>
                                <small class="text-muted">@{{ (spadaAnswer || '').length }} / @{{ spadaMaxLength }} karakter</small>
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
                @include('dashboard.logbook_rekap_pimpinan')
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
    @if (!empty($show_logbook_rekap))
    <script src="{!! asset('assets/bundles/c3.bundle.js') !!}"></script>
    @endif

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
        computed: {
            spadaMaxLength: function () {
                var q = this.spadaQuestion;
                if (!q) return 1000;
                var rule = q.validate_rule;
                if (rule !== null && rule !== undefined && rule !== '') {
                    try {
                        var decoded = JSON.parse(rule);
                        if (typeof decoded === 'object') {
                            var arr = Array.isArray(decoded) ? decoded : Object.keys(decoded).map(function(k) { return decoded[k]; });
                            for (var i = 0; i < arr.length; i++) {
                                var v = arr[i];
                                if (typeof v === 'number' && v > 0) return v;
                                if (typeof v === 'string' && /^\d+$/.test(v)) return parseInt(v, 10);
                            }
                        }
                    } catch (e) {}
                    var m = String(rule).match(/\d+/);
                    if (m) return parseInt(m[0], 10);
                }
                if (q.type_question == 2 || q.type_question === '2') return 200;
                return 1000;
            },
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
                var maxLen = self.spadaMaxLength;
                if (answer.length > maxLen) {
                    alert('Jawaban maksimal ' + maxLen + ' karakter.');
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

    @if (!empty($show_logbook_rekap))
    <script>
    (function () {
        var lbBarChart = null;
        var lbLineChart = null;
        var apiUrl = {!! json_encode(url('dashboard/api/logbook_rekap_pimpinan')) !!};

        function percentColor(pct) {
            if (pct > 75) return '#28a745';
            if (pct >= 25) return '#ffc107';
            return '#dc3545';
        }

        function toggleFilters() {
            var mode = $('#lb_rekap_mode').val();
            if (mode === 'month') {
                $('#lb_rekap_day_filter').hide();
                $('#lb_rekap_month_filter, #lb_rekap_year_filter').show();
                $('#lb_rekap_side_title').text('Tren Pegawai Isi Logbook (Harian)');
                $('#lb_rekap_percent_list').hide();
                $('#lb_rekap_chart_line, #lb_rekap_line_hint').show();
            } else {
                $('#lb_rekap_day_filter').show();
                $('#lb_rekap_month_filter, #lb_rekap_year_filter').hide();
                $('#lb_rekap_side_title').text('Ringkasan Persentase');
                $('#lb_rekap_percent_list').show();
                $('#lb_rekap_chart_line, #lb_rekap_line_hint').hide();
            }
        }

        function renderPercentList(datas) {
            var html = '';
            if (!datas || !datas.length) {
                html = '<div class="text-muted text-center" style="padding-top:120px;">Tidak ada data</div>';
            } else {
                for (var i = 0; i < datas.length; i++) {
                    var row = datas[i];
                    var pct = Number(row.persentase || 0);
                    var color = percentColor(pct);
                    var name = row.leader_name || row.leader_nip || ('Ketua Tim ' + (i + 1));
                    html += '<div class="m-b-15">' +
                        '<div class="d-flex justify-content-between">' +
                            '<span><strong>' + name + '</strong></span>' +
                            '<span class="font-weight-bold" style="color:' + color + ';">' + pct.toFixed(1) + '%</span>' +
                        '</div>' +
                        '<div class="progress" style="height:12px; border-radius:8px; background:#e9ecef;">' +
                            '<div class="progress-bar" role="progressbar" style="width:' + pct + '%; background:' + color + '; border-radius:8px;" ' +
                                'aria-valuenow="' + pct + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '<small class="text-muted">' + row.user_isi_logbook + ' / ' + row.total_anggota + ' pegawai isi logbook</small>' +
                    '</div>';
                }
            }
            $('#lb_rekap_percent_list').html(html);
        }

        function renderTable(datas) {
            var html = '';
            if (!datas || !datas.length) {
                html = '<tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>';
            } else {
                for (var i = 0; i < datas.length; i++) {
                    var row = datas[i];
                    var pct = Number(row.persentase || 0);
                    var color = percentColor(pct);
                    html += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td>' + (row.leader_name || '-') + '</td>' +
                        '<td>' + (row.leader_jabatan || '-') + '</td>' +
                        '<td>' + (row.leader_nip || '-') + '</td>' +
                        '<td class="text-center">' + row.total_anggota + '</td>' +
                        '<td class="text-center"><strong>' + row.user_isi_logbook + '</strong></td>' +
                        '<td class="text-center">' +
                            '<div style="min-width:140px;">' +
                                '<div class="d-flex justify-content-between m-b-5">' +
                                    '<small class="text-muted">' + row.user_isi_logbook + '/' + row.total_anggota + '</small>' +
                                    '<strong style="color:' + color + ';">' + pct.toFixed(1) + '%</strong>' +
                                '</div>' +
                                '<div class="progress m-b-0" style="height:14px; border-radius:10px; background:#e9ecef; overflow:hidden;">' +
                                    '<div class="progress-bar" role="progressbar" ' +
                                        'style="width:' + Math.max(pct, pct > 0 ? 2 : 0) + '%; background-color:' + color + '; border-radius:10px;" ' +
                                        'aria-valuenow="' + pct + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                        '</tr>';
                }
            }
            $('#lb_rekap_table_body').html(html);
        }

        function renderBarChart(datas) {
            var labels = [];
            var values = ['Persentase'];
            for (var i = 0; i < datas.length; i++) {
                var name = datas[i].leader_name || datas[i].leader_nip || ('Ketua Tim ' + (i + 1));
                if (name.length > 22) {
                    name = name.substring(0, 20) + '..';
                }
                labels.push(name);
                values.push(Number(datas[i].persentase || 0));
            }

            if (!labels.length) {
                labels = ['Tidak ada data'];
                values = ['Persentase', 0];
            }

            if (lbBarChart) {
                lbBarChart.destroy();
            }

            lbBarChart = c3.generate({
                bindto: '#lb_rekap_chart_bar',
                data: {
                    columns: [values],
                    type: 'bar',
                    color: function (color, d) {
                        if (d && typeof d.value !== 'undefined') {
                            return percentColor(Number(d.value));
                        }
                        return color;
                    },
                    labels: {
                        format: function (v) {
                            return Number(v).toFixed(1) + '%';
                        }
                    }
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        categories: labels
                    },
                    y: {
                        min: 0,
                        max: 100,
                        padding: { top: 0, bottom: 0 },
                        label: {
                            text: '% Pegawai Isi Logbook',
                            position: 'outer-middle'
                        },
                        tick: {
                            format: function (v) {
                                return v + '%';
                            }
                        }
                    }
                },
                bar: {
                    width: { ratio: 0.6 }
                },
                grid: {
                    y: { show: true }
                },
                legend: { show: false },
                padding: { bottom: 10, right: 30 }
            });
        }

        function renderLineChart(daily, mode) {
            if (mode !== 'month') {
                if (lbLineChart) {
                    lbLineChart.destroy();
                    lbLineChart = null;
                }
                return;
            }

            var labels = [];
            var values = ['Pegawai Isi Logbook'];
            for (var i = 0; i < daily.length; i++) {
                var d = daily[i].date || '';
                labels.push(d.length >= 10 ? d.substring(8, 10) : d);
                values.push(daily[i].total);
            }

            if (!labels.length) {
                labels = ['-'];
                values = ['Pegawai Isi Logbook', 0];
            }

            if (lbLineChart) {
                lbLineChart.destroy();
            }

            lbLineChart = c3.generate({
                bindto: '#lb_rekap_chart_line',
                data: {
                    columns: [values],
                    type: 'area',
                    colors: {
                        'Pegawai Isi Logbook': '#28a745'
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: labels,
                        label: { text: 'Tanggal', position: 'outer-center' }
                    },
                    y: {
                        min: 0,
                        padding: { bottom: 0 },
                        label: { text: 'Jumlah Pegawai', position: 'outer-middle' }
                    }
                },
                legend: { show: false },
                point: { r: 3 },
                padding: { bottom: 10, right: 20 }
            });
        }

        function loadRekap() {
            var mode = $('#lb_rekap_mode').val();
            var params = {
                mode: mode,
                tanggal: $('#lb_rekap_tanggal').val(),
                month: $('#lb_rekap_month').val(),
                year: $('#lb_rekap_year').val()
            };

            $('#lb_rekap_table_body').html('<tr><td colspan="7" class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');

            $.ajax({
                url: apiUrl,
                method: 'GET',
                dataType: 'json',
                data: params
            }).done(function (res) {
                var datas = res.datas || [];
                renderTable(datas);
                renderBarChart(datas);
                renderPercentList(datas);
                renderLineChart(res.daily || [], res.mode || mode);
            }).fail(function (xhr) {
                var msg = 'Gagal memuat rekap logbook.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#lb_rekap_table_body').html('<tr><td colspan="7" class="text-center text-danger">' + msg + '</td></tr>');
            });
        }

        $(document).ready(function () {
            if (!$('#logbook_rekap_section').length) {
                return;
            }

            toggleFilters();
            loadRekap();

            $('#lb_rekap_mode').on('change', function () {
                toggleFilters();
                loadRekap();
            });
            $('#lb_rekap_refresh').on('click', loadRekap);
            $('#lb_rekap_month, #lb_rekap_year').on('change', function () {
                if ($('#lb_rekap_mode').val() === 'month') {
                    loadRekap();
                }
            });
            $('#lb_rekap_tanggal').on('change', function () {
                if ($('#lb_rekap_mode').val() === 'day') {
                    loadRekap();
                }
            });
            $('#lb_rekap_day_filter .date').on('changeDate', function () {
                if ($('#lb_rekap_mode').val() === 'day') {
                    loadRekap();
                }
            });
        });
    })();
    </script>
    @endif
@endsection
