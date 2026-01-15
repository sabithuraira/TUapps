@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Curhat Anonim</li>
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
          <div class="row m-b-15">
            <div class="col-md-3">
              <label>Filter Status Verifikasi:</label>
              <select class="form-control" v-model="filter_status_verifikasi" @change="setDatas(1)">
                <option value="">Semua Status</option>
                @if(isset($list_status_verifikasi))
                  @foreach($list_status_verifikasi as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                  @endforeach
                @else
                  <option value="1">Belum Verifikasi</option>
                  <option value="2">Disetujui</option>
                  <option value="3">Tidak Disetujui</option>
                @endif
              </select>
            </div>
          </div>
          <section class="datas">
              @include('curhat_anon.list')
          </section>
          
          <!-- Pagination -->
          <div class="row m-t-15" v-if="pagination && pagination.last_page > 1">
            <div class="col-md-12">
              <nav>
                <ul class="pagination pagination-primary justify-content-center">
                  <li class="page-item" :class="{disabled: pagination.current_page == 1}">
                    <a class="page-link" href="javascript:void(0);" @click="changePage(1)" v-if="pagination.current_page > 1">
                      <span>«</span>
                    </a>
                    <span class="page-link" v-else>«</span>
                  </li>
                  <li class="page-item" :class="{disabled: pagination.current_page == 1}">
                    <a class="page-link" href="javascript:void(0);" @click="changePage(pagination.current_page - 1)" v-if="pagination.current_page > 1">
                      <span>‹</span>
                    </a>
                    <span class="page-link" v-else>‹</span>
                  </li>
                  <template v-for="page in getPageNumbers()">
                    <li class="page-item" v-if="page !== '...'" :key="page" :class="{active: page == pagination.current_page}">
                      <a class="page-link" href="javascript:void(0);" @click="changePage(page)">@{{ page }}</a>
                    </li>
                    <li class="page-item disabled" v-else :key="'dots-' + page">
                      <span class="page-link">...</span>
                    </li>
                  </template>
                  <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
                    <a class="page-link" href="javascript:void(0);" @click="changePage(pagination.current_page + 1)" v-if="pagination.current_page < pagination.last_page">
                      <span>›</span>
                    </a>
                    <span class="page-link" v-else>›</span>
                  </li>
                  <li class="page-item" :class="{disabled: pagination.current_page == pagination.last_page}">
                    <a class="page-link" href="javascript:void(0);" @click="changePage(pagination.last_page)" v-if="pagination.current_page < pagination.last_page">
                      <span>»</span>
                    </a>
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
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
  <style type="text/css">
      .modal-dialog{ overflow-y: initial !important }
      .modal-body{ height: 80vh; overflow-y: auto; }
  </style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      datas: [],
      pathname : window.location.pathname,
      form_id_data: '',
      form_content: '',
      form_status_verifikasi: 1,
      filter_status_verifikasi: '',
      pagination: null,
      current_page: 1,
      per_page: 10,
    },
    methods: {
        setDatas: function(page){
            var self = this;
            if (page) {
                self.current_page = page;
            }
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : self.pathname+"/load_data",
                method : 'post',
                dataType: 'json',
                data: {
                    filter_status_verifikasi: self.filter_status_verifikasi || '',
                    page: self.current_page,
                    per_page: self.per_page
                }
            }).done(function (data) {
                self.datas = data.datas;
                self.pagination = data.pagination;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        changePage: function(page) {
            var self = this;
            if (page >= 1 && page <= self.pagination.last_page) {
                self.setDatas(page);
            }
        },
        getPageNumbers: function() {
            var self = this;
            if (!self.pagination) return [];
            
            var current = self.pagination.current_page;
            var last = self.pagination.last_page;
            var delta = 2;
            var left = current - delta;
            var right = current + delta + 1;
            var range = [];
            var l;
            
            for (var i = 1; i <= last; i++) {
                if (i == 1 || i == last || (i >= left && i < right)) {
                    range.push(i);
                }
            }
            
            var rangeIncludingDots = [];
            l = null;
            for (var i = 0; i < range.length; i++) {
                if (l) {
                    if (range[i] - l === 2) {
                        rangeIncludingDots.push(l + 1);
                    } else if (range[i] - l !== 1) {
                        rangeIncludingDots.push('...');
                    }
                }
                rangeIncludingDots.push(range[i]);
                l = range[i];
            }
            
            return rangeIncludingDots;
        },
        updateData: function (event) {
            var self = this;
            if (event) {
                var target = event.currentTarget;
                self.form_id_data = target.getAttribute('data-id');
                self.form_content = target.getAttribute('data-content');
                self.form_status_verifikasi = target.getAttribute('data-status-verifikasi');
            }
        },
        saveData: function () {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : "{{ url('/curhat_anon') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.form_id_data,
                    form_content: self.form_content,
                    form_status_verifikasi: self.form_status_verifikasi
                },
            }).done(function (data) {
                $('#form_modal').modal('hide');
                self.setDatas();
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        formatDate: function(dateString) {
            if (!dateString) return '';
            var date = new Date(dateString);
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            return day + '/' + month + '/' + year;
        },
    }
});

$(document).ready(function() {
    vm.setDatas();
});

$( "#save-btn" ).click(function(e) {
    vm.saveData();
});
</script>
@endsection

