@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Pertanyaan Spada (Dopamin)</li>
</ul>
@endsection

@section('content')
<div id="app_vue">
    <div class="container">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif

        <div class="card">
            <div class="body">
                <a href="#" role="button" v-on:click="addData" class="btn btn-primary" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus-circle"></i> <span>Tambah Pertanyaan Spada</span></a>
                <br/><br/>

                <div class="row m-b-15">
                    <div class="col-md-4">
                        <label>Pencarian:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="keyword" @keyup.enter="setDatas(1)" placeholder="Cari pertanyaan...">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" @click="setDatas(1)"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="datas">
                    @include('dopamin_spada.list')
                </section>

                <!-- Pagination -->
                <div class="row m-t-15" v-if="pagination && pagination.last_page > 1">
                    <div class="col-md-12">
                        <nav>
                            <ul class="pagination pagination-primary justify-content-center">
                                <li class="page-item" :class="{disabled: pagination.current_page == 1}">
                                    <a class="page-link" href="javascript:void(0);" @click="changePage(1)" v-if="pagination.current_page > 1"><span>«</span></a>
                                    <span class="page-link" v-else>«</span>
                                </li>
                                <li class="page-item" :class="{disabled: pagination.current_page == 1}">
                                    <a class="page-link" href="javascript:void(0);" @click="changePage(pagination.current_page - 1)" v-if="pagination.current_page > 1"><span>‹</span></a>
                                    <span class="page-link" v-else>‹</span>
                                </li>
                                <template v-for="page in getPageNumbers()">
                                    <li class="page-item" v-if="page !== '...'" :key="page" :class="{active: page == pagination.current_page}">
                                        <a class="page-link" href="javascript:void(0);" @click="changePage(page)">@{{ page }}</a>
                                    </li>
                                    <li class="page-item disabled" v-else :key="'dots-' + page"><span class="page-link">...</span></li>
                                </template>
                                <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
                                    <a class="page-link" href="javascript:void(0);" @click="changePage(pagination.current_page + 1)" v-if="pagination.current_page < pagination.last_page"><span>›</span></a>
                                    <span class="page-link" v-else>›</span>
                                </li>
                                <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
                                    <a class="page-link" href="javascript:void(0);" @click="changePage(pagination.last_page)" v-if="pagination.current_page < pagination.last_page"><span>»</span></a>
                                    <span class="page-link" v-else>»</span>
                                </li>
                            </ul>
                        </nav>
                        <div class="text-center m-t-10">
                            <small>Menampilkan @{{ pagination.from }} - @{{ pagination.to }} dari @{{ pagination.total }} data</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal" id="form_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="title" id="defaultModalLabel">Form Pertanyaan Spada</b>
                </div>
                <div class="modal-body">
                    <input type="hidden" v-model="form.id_data">
                    <div class="form-group">
                        Pertanyaan: <span class="text-danger">*</span>
                        <div class="form-line">
                            <textarea v-model="form.question" class="form-control" rows="4" placeholder="Masukkan pertanyaan..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        Jenis Pertanyaan:
                        <div class="form-line">
                            <select class="form-control" v-model="form.type_question">
                                <option value="1">Jawaban Bebas</option>
                                <option value="2">Jawaban Singkat (maksimal 15 karakter)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        Mulai Aktif:
                        <div class="form-line">
                            <input type="date" v-model="form.start_active" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        Berakhir Aktif:
                        <div class="form-line">
                            <input type="date" v-model="form.last_active" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        Aturan Validasi:
                        <div class="form-line">
                            <input type="text" v-model="form.validate_rule" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                    <div class="form-group">
                        Satuan Kerja:
                        <div class="form-line">
                            <select class="form-control" v-model="form.satker">
                                <option value="">-- Pilih Satuan Kerja --</option>
                                @foreach($satkerOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-btn">SIMPAN</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">TUTUP</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                    <h4 class="text-center">Mohon tunggu...</h4>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')
    <meta name="_token" content="{{ csrf_token() }}" />
    <style type="text/css">
        .modal-dialog { overflow-y: initial !important }
        .modal-body { height: 80vh; overflow-y: auto; }
    </style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({
    el: "#app_vue",
    data: {
        datas: [],
        apiBaseUrl: window.API_CONFIG ? window.API_CONFIG.MADING_SPADA_QUESTION_API : 'http://mading.farifam.com/api/spada-question',
        form: {
            id_data: '',
            question: '',
            type_question: '1',
            start_active: '',
            last_active: '',
            validate_rule: '',
            satker: '',
        },
        keyword: '',
        pagination: null,
        current_page: 1,
        per_page: 10,
    },
    methods: {
        formatDateId: function (dateStr) {
            if (!dateStr) return '-';
            var d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
        },
        setDatas: function (page) {
            var self = this;
            if (page) self.current_page = page;
            $('#wait_progres').modal('show');
            $.ajax({
                url: self.apiBaseUrl,
                method: 'get',
                dataType: 'json',
                crossDomain: true,
                data: {
                    keyword: self.keyword || '',
                    page: self.current_page,
                    per_page: self.per_page,
                },
            }).done(function (data) {
                var raw = data.datas;
                self.datas = Array.isArray(raw) ? raw : (raw && raw.data ? raw.data : []);
                self.pagination = data.pagination || null;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
                alert('Gagal memuat data. Silakan coba lagi.');
            });
        },
        changePage: function (page) {
            var self = this;
            if (self.pagination && page >= 1 && page <= self.pagination.last_page) self.setDatas(page);
        },
        getPageNumbers: function () {
            var self = this;
            if (!self.pagination) return [];
            var current = self.pagination.current_page;
            var last = self.pagination.last_page;
            var delta = 2;
            var left = current - delta;
            var right = current + delta + 1;
            var range = [];
            for (var i = 1; i <= last; i++) {
                if (i == 1 || i == last || (i >= left && i < right)) range.push(i);
            }
            var out = [], l = null;
            for (var i = 0; i < range.length; i++) {
                if (l !== null) {
                    if (range[i] - l === 2) out.push(l + 1);
                    else if (range[i] - l !== 1) out.push('...');
                }
                out.push(range[i]);
                l = range[i];
            }
            return out;
        },
        addData: function () {
            this.form.id_data = '';
            this.form.question = '';
            this.form.type_question = '1';
            this.form.start_active = '';
            this.form.last_active = '';
            this.form.validate_rule = '';
            this.form.satker = '';
        },
        getTypeQuestionLabel: function (val) {
            if (val == 1 || val == '1') return 'Jawaban Bebas';
            if (val == 2 || val == '2') return 'Jawaban Singkat (maks. 15 karakter)';
            return val;
        },
        updateData: function (event) {
            if (!event) return;
            var t = event.currentTarget;
            this.form.id_data = t.getAttribute('data-id') || '';
            this.form.question = t.getAttribute('data-question') || '';
            this.form.type_question = String(t.getAttribute('data-type-question') || '1');
            this.form.start_active = t.getAttribute('data-start-active') || '';
            this.form.last_active = t.getAttribute('data-last-active') || '';
            this.form.validate_rule = t.getAttribute('data-validate-rule') || '';
            this.form.satker = t.getAttribute('data-satker') || '';
        },
        saveData: function () {
            var self = this;
            if (!self.form.question || !self.form.question.trim()) {
                alert('Pertanyaan harus diisi');
                return;
            }
            $('#wait_progres').modal('show');
            var isUpdate = self.form.id_data && self.form.id_data != '' && self.form.id_data != '0';
            var apiUrl = isUpdate ? self.apiBaseUrl + '/' + self.form.id_data : self.apiBaseUrl;
            var method = isUpdate ? 'put' : 'post';
            var payload = {
                question: self.form.question,
                type_question: parseInt(self.form.type_question, 10) || 1,
                start_active: self.form.start_active || null,
                last_active: self.form.last_active || null,
                validate_rule: self.form.validate_rule || null,
                satker: self.form.satker || null,
            };
            $.ajax({
                url: apiUrl,
                method: method,
                dataType: 'json',
                crossDomain: true,
                contentType: 'application/json',
                data: JSON.stringify(payload),
            }).done(function (data) {
                if (data.success == '1') {
                    $('#form_modal').modal('hide');
                    self.setDatas(self.current_page);
                } else {
                    alert(data.message || 'Gagal menyimpan data');
                }
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                alert('Terjadi kesalahan saat menyimpan data');
                $('#wait_progres').modal('hide');
            });
        },
        deleteData: function (id) {
            if (!confirm('Anda yakin ingin menghapus data ini?')) return;
            var self = this;
            $('#wait_progres').modal('show');
            $.ajax({
                url: self.apiBaseUrl + '/' + id,
                method: 'delete',
                dataType: 'json',
                crossDomain: true,
            }).done(function (data) {
                if (data.success == '1') self.setDatas(self.current_page);
                else alert(data.message || 'Gagal menghapus data');
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                alert('Terjadi kesalahan saat menghapus data');
                $('#wait_progres').modal('hide');
            });
        },
        getHasilUrl: function (questionId) {
            var base = '{{ url("dopamin_spada") }}';
            return base + '/hasil/' + questionId;
        },
    },
});

$(document).ready(function () { vm.setDatas(); });
$("#save-btn").click(function (e) { vm.saveData(); });
</script>
@endsection
