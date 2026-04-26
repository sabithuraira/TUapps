@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Promoting Picture (Dopamin)</li>
</ul>
@endsection

@section('content')
<div id="app_vue">
    <div class="container">
        <div class="card">
            <div class="body">
                <a href="#" role="button" v-on:click="addData" class="btn btn-primary" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus-circle"></i> <span>Tambah Promoting Picture</span></a>
                <br/><br/>

                <section class="datas">
                    @include('dopamin_picture.list')
                </section>

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

    <div class="modal" id="form_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="title" id="defaultModalLabel">Form Promoting Picture</b>
                </div>
                <div class="modal-body">
                    <input type="hidden" v-model="form.id_data">
                    <div class="form-group">
                        Judul: <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="text" v-model="form.title" class="form-control" placeholder="Masukkan judul">
                        </div>
                    </div>
                    <div class="form-group">
                        Gambar <small>(maks 5MB)</small>:
                        <div class="form-line">
                            <input type="file" class="form-control" ref="pictureInput" accept="image/*" @change="onFileChange">
                        </div>
                        <small class="text-muted" v-if="form.id_data">Kosongkan jika tidak ingin mengubah gambar.</small>
                        <div class="m-t-10" v-if="form.picture_preview">
                            <img :src="form.picture_preview" alt="preview" style="max-width:200px; max-height:120px;">
                        </div>
                    </div>
                    <div class="form-group">
                        Start Date: <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="date" v-model="form.start_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        End Date: <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="date" v-model="form.end_date" class="form-control">
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
        apiBaseUrl: (window.API_CONFIG && window.API_CONFIG.MADING_PROMOTING_PICTURE_API) ? window.API_CONFIG.MADING_PROMOTING_PICTURE_API : 'https://mading.farifam.com/api/promoting-picture',
        form: {
            id_data: '',
            title: '',
            start_date: '',
            end_date: '',
            picture_file: null,
            picture_preview: '',
        },
        pagination: null,
        current_page: 1,
        per_page: 10,
    },
    methods: {
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
        getPictureUrl: function (data) {
            if (!data) return '';
            var baseUrl = (window.API_CONFIG ? window.API_CONFIG.MADING_BASE_URL : 'https://mading.farifam.com').replace(/\/$/, '');
            var path = '';
            if (typeof data.picture_path === 'string') {
                path = data.picture_path;
            } else if (data.picture_path && typeof data.picture_path === 'object') {
                path = data.picture_path.path || data.picture_path.url || data.picture_path.src || data.picture_path.value || '';
            }
            if (!path) return '';
            path = String(path).replace(/^\/+/, '');
            if (path.indexOf('http://') === 0 || path.indexOf('https://') === 0) return path;
            if (path.indexOf('storage/') === 0) return baseUrl + '/' + path;
            return baseUrl + '/storage/' + path;
            return '';
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
            this.form.title = '';
            this.form.start_date = '';
            this.form.end_date = '';
            this.form.picture_file = null;
            this.form.picture_preview = '';
            if (this.$refs.pictureInput) this.$refs.pictureInput.value = '';
        },
        updateData: function (id) {
            var self = this;
            self.addData();
            $('#wait_progres').modal('show');
            $.ajax({
                url: self.apiBaseUrl + '/' + id,
                method: 'get',
                dataType: 'json',
                crossDomain: true,
            }).done(function (response) {
                var data = response.data || response;
                self.form.id_data = data.id || '';
                self.form.title = data.title || '';
                self.form.start_date = data.start_date || '';
                self.form.end_date = data.end_date || '';
                self.form.picture_preview = self.getPictureUrl(data);
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
                alert('Gagal mengambil detail data.');
            });
        },
        onFileChange: function (event) {
            var self = this;
            var file = event.target.files && event.target.files.length ? event.target.files[0] : null;
            self.form.picture_file = file;
            if (!file) {
                self.form.picture_preview = '';
                return;
            }
            self.form.picture_preview = URL.createObjectURL(file);
        },
        saveData: function () {
            var self = this;
            if (!self.form.title || !self.form.title.trim()) {
                alert('Judul harus diisi');
                return;
            }
            if (!self.form.start_date || !self.form.end_date) {
                alert('Start Date dan End Date harus diisi');
                return;
            }
            if (self.form.end_date < self.form.start_date) {
                alert('End Date harus sama atau setelah Start Date');
                return;
            }
            if (!self.form.id_data && !self.form.picture_file) {
                alert('Gambar harus diisi untuk data baru');
                return;
            }

            var formData = new FormData();
            formData.append('title', self.form.title || '');
            formData.append('start_date', self.form.start_date || '');
            formData.append('end_date', self.form.end_date || '');
            if (self.form.picture_file) {
                formData.append('picture', self.form.picture_file);
            }
            if (self.form.id_data) {
                formData.append('_method', 'PUT');
            }

            $('#wait_progres').modal('show');
            $.ajax({
                url: self.form.id_data ? (self.apiBaseUrl + '/' + self.form.id_data) : self.apiBaseUrl,
                method: 'post',
                dataType: 'json',
                crossDomain: true,
                data: formData,
                processData: false,
                contentType: false,
            }).done(function (data) {
                if (data.success == '1') {
                    $('#form_modal').modal('hide');
                    self.setDatas(self.current_page);
                } else {
                    alert(data.message || 'Gagal menyimpan data');
                    $('#wait_progres').modal('hide');
                }
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
                else {
                    alert(data.message || 'Gagal menghapus data');
                    $('#wait_progres').modal('hide');
                }
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                alert('Terjadi kesalahan saat menghapus data');
                $('#wait_progres').modal('hide');
            });
        },
    },
});

$(document).ready(function () { vm.setDatas(); });
$("#save-btn").click(function () { vm.saveData(); });
</script>
@endsection
