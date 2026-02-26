@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Knowledge Info</li>
</ul>
@endsection

@section('content')
    <div class="container">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif

        <div class="card" id="app_vue">
            <div class="body">
                <a href="{{ url('knowledge_info/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <span>Tambah Knowledge Info</span></a>
                <br/><br/>

                <div class="row m-b-15">
                    <div class="col-md-4">
                        <label>Pencarian:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="keyword" @keyup.enter="setDatas(1)" placeholder="Cari judul, konten, kategori atau tag...">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" @click="setDatas(1)"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="datas">
                    @include('knowledge_info.list')
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
@endsection

@section('css')
    <meta name="_token" content="{{ csrf_token() }}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({
    el: "#app_vue",
    data: {
        datas: [],
        pathname: window.location.pathname,
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
                    keyword: self.keyword || '',
                    page: self.current_page,
                    per_page: self.per_page,
                },
            }).done(function (data) {
                self.datas = data.datas || [];
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
        deleteData: function (id) {
            if (!confirm('Anda yakin ingin menghapus data ini?')) return;
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } });
            $.ajax({
                url: "{{ url('knowledge_info') }}/" + id,
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
</script>
@endsection
