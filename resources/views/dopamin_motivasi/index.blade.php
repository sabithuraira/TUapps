@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Kata Motivasi (Dopamin)</li>
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
                <a href="#" role="button" v-on:click="addData" class="btn btn-primary" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus-circle"></i> <span>Tambah Kata Motivasi</span></a>
                <br/><br/>

                <div class="row m-b-15">
                    <div class="col-md-3">
                        <label>Filter Status:</label>
                        <select class="form-control" v-model="filter_is_active" @change="setDatas(1)">
                            <option value="">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Pencarian:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="keyword" @keyup.enter="setDatas(1)" placeholder="Cari kata motivasi atau dikutip dari...">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" @click="setDatas(1)"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="datas">
                    @include('dopamin_motivasi.list')
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
                    <b class="title" id="defaultModalLabel">Form Kata Motivasi</b>
                </div>
                <div class="modal-body">
                    <input type="hidden" v-model="form.id_data">
                    <div class="form-group">
                        Kata Motivasi: <span class="text-danger">*</span>
                        <div class="form-line">
                            <textarea v-model="form.kata_motivasi" class="form-control" rows="4" placeholder="Masukkan kata motivasi..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        Dikutip Dari:
                        <div class="form-line">
                            <input type="text" v-model="form.dikutip_dari" class="form-control" placeholder="Nama sumber / penulis (opsional)">
                        </div>
                    </div>
                    <div class="form-group">
                        Status:
                        <div class="form-line">
                            <select class="form-control" v-model="form.is_active">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted small">Created NIP akan diisi otomatis dari email login Anda.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-btn">SAVE</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
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
        pathname: window.location.pathname,
        form: {
            id_data: '',
            kata_motivasi: '',
            dikutip_dari: '',
            is_active: '1',
        },
        filter_is_active: '',
        keyword: '',
        pagination: null,
        current_page: 1,
        per_page: 10,
    },
    methods: {
        setDatas: function (page) {
            var self = this;
            if (page) self.current_page = page;
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } });
            $.ajax({
                url: self.pathname + "/load_data",
                method: 'post',
                dataType: 'json',
                data: {
                    filter_is_active: self.filter_is_active || '',
                    keyword: self.keyword || '',
                    page: self.current_page,
                    per_page: self.per_page,
                },
            }).done(function (data) {
                // API may return datas as array or { data: [] } (Laravel Resource collection)
                var raw = data.datas;
                self.datas = Array.isArray(raw) ? raw : (raw && raw.data ? raw.data : []);
                self.pagination = data.pagination || null;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
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
            this.form.kata_motivasi = '';
            this.form.dikutip_dari = '';
            this.form.is_active = '1';
        },
        updateData: function (event) {
            if (!event) return;
            var t = event.currentTarget;
            this.form.id_data = t.getAttribute('data-id');
            this.form.kata_motivasi = t.getAttribute('data-kata-motivasi') || '';
            this.form.dikutip_dari = t.getAttribute('data-dikutip-dari') || '';
            this.form.is_active = String(t.getAttribute('data-is-active') ?? '1');
        },
        saveData: function () {
            var self = this;
            console.log(self.form)
            if (!self.form.kata_motivasi || !self.form.kata_motivasi.trim()) {
                alert('Kata motivasi harus diisi');
                return;
            }
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } });
            $.ajax({
                url: "{{ url('dopamin_motivasi') }}",
                method: 'post',
                dataType: 'json',
                data: {
                    form_id_data: self.form.id_data || 0,
                    form_kata_motivasi: self.form.kata_motivasi,
                    form_dikutip_dari: self.form.dikutip_dari,
                    form_is_active: self.form.is_active,
                },
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
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } });
            $.ajax({
                url: "{{ url('dopamin_motivasi') }}/" + id,
                method: 'delete',
                dataType: 'json',
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
    },
});

$(document).ready(function () { vm.setDatas(); });
$("#save-btn").click(function (e) { vm.saveData(); });
</script>
@endsection
