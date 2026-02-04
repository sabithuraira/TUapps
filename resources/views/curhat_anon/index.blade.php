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
          <section class="datas" v-html="tableHtml">
          </section>
          
          <!-- Modal Form -->
          <div class="modal" id="form_modal" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <b class="title" id="defaultModalLabel">Form Curhat Anonim</b>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" v-model="form_id_data">
                          
                          <div class="form-group">
                              Content: <span class="text-danger">*</span>
                              <div class="form-line">
                                  <textarea v-model="form_content" class="form-control" rows="5" placeholder="Masukkan curhat..."></textarea>
                              </div>
                          </div>

                          <div class="form-group">
                              Status Verifikasi:
                              <div class="form-line">
                                  <select class="form-control" v-model="form_status_verifikasi">
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
      apiBaseUrl: window.API_CONFIG ? window.API_CONFIG.MADING_CURHAT_ANON_API : 'https://mading.farifam.com/api/curhat-anon',
      form_id_data: '',
      form_content: '',
      form_status_verifikasi: 1,
      filter_status_verifikasi: '',
      pagination: null,
      current_page: 1,
      per_page: 10,
      tableHtml: '',
    },
    methods: {
        setDatas: function(page){
            var self = this;
            if (page) {
                self.current_page = page;
            }
            $('#wait_progres').modal('show');
            // Note: External API calls don't need CSRF token
            $.ajax({
                url : self.apiBaseUrl,
                method : 'get',
                dataType: 'json',
                crossDomain: true,
                data: {
                    filter_status_verifikasi: self.filter_status_verifikasi || '',
                    page: self.current_page,
                    per_page: self.per_page
                }
            }).done(function (response) {
                console.log('API Response:', response); // Debug log
                if (response.success == '1' || response.datas) {
                    self.datas = response.datas || [];
                    self.pagination = response.pagination || null;
                    self.renderTable();
                } else {
                    self.datas = [];
                    self.pagination = null;
                    self.tableHtml = '<div class="alert alert-warning">Tidak ada data</div>';
                    console.error('API returned error:', response);
                }
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log('AJAX Error:', JSON.stringify(msg));
                self.datas = [];
                self.pagination = null;
                self.tableHtml = '<div class="alert alert-danger">Gagal memuat data</div>';
                $('#wait_progres').modal('hide');
                alert('Gagal memuat data. Silakan coba lagi.');
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
            // Note: External API calls don't need CSRF token
            var isUpdate = self.form_id_data && self.form_id_data != '' && self.form_id_data != '0';
            var apiUrl = self.apiBaseUrl;
            var method = 'post';
            
            // If updating, use PUT method with ID
            if (isUpdate) {
                apiUrl = self.apiBaseUrl + '/' + self.form_id_data;
                method = 'put';
            }
            
            // Note: External API calls don't need CSRF token
            $.ajax({
                url : apiUrl,
                method : method,
                dataType: 'json',
                crossDomain: true,
                data:{
                    form_id_data: self.form_id_data || 0,
                    form_content: self.form_content,
                    form_status_verifikasi: self.form_status_verifikasi
                },
            }).done(function (response) {
                console.log('Save Response:', response);
                if (response.success == '1') {
                    $('#form_modal').modal('hide');
                    self.setDatas(self.current_page);
                    alert('Data berhasil disimpan');
                } else {
                    alert('Gagal menyimpan data: ' + (response.message || 'Unknown error'));
                }
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log('Save Error:', JSON.stringify(msg));
                $('#wait_progres').modal('hide');
                alert('Gagal menyimpan data. Silakan coba lagi.');
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
        renderTable: function() {
            var self = this;
            var html = '<div class="table-responsive">';
            html += '<table class="table-bordered m-b-0" style="min-width:100%">';
            html += '<thead><tr>';
            html += '<th>No</th>';
            html += '<th class="text-center">Content</th>';
            html += '<th class="text-center">Status Verifikasi</th>';
            html += '<th class="text-center">Tanggal</th>';
            html += '<th class="text-center">Action</th>';
            html += '</tr></thead><tbody>';
            
            if (self.datas.length == 0) {
                html += '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
            } else {
                for (var i = 0; i < self.datas.length; i++) {
                    var data = self.datas[i];
                    var no = (self.pagination && self.pagination.from) ? (self.pagination.from + i) : (i + 1);
                    var statusBadge = '';
                    if (data.status_verifikasi == 1) {
                        statusBadge = '<span class="badge badge-warning">Belum Verifikasi</span>';
                    } else if (data.status_verifikasi == 2) {
                        statusBadge = '<span class="badge badge-success">Disetujui</span>';
                    } else if (data.status_verifikasi == 3) {
                        statusBadge = '<span class="badge badge-danger">Tidak Disetujui</span>';
                    }
                    
                    html += '<tr>';
                    html += '<td class="text-center">' + no + '</td>';
                    html += '<td>' + (data.content || '') + '</td>';
                    html += '<td class="text-center">' + statusBadge + '</td>';
                    html += '<td class="text-center">' + self.formatDate(data.created_at) + '</td>';
                    html += '<td class="text-center">';
                    var escapedContent = (data.content || '').replace(/'/g, "&#39;").replace(/"/g, "&quot;").replace(/\n/g, " ");
                    html += '<a href="#" role="button" onclick="event.preventDefault(); vm.updateDataFromTable(' + data.id + ', \'' + escapedContent + '\', ' + data.status_verifikasi + '); $(\'#form_modal\').modal(\'show\');">';
                    html += '<i class="icon-pencil text-info"></i>';
                    html += '</a>';
                    html += '</td>';
                    html += '</tr>';
                }
            }
            
            html += '</tbody></table></div>';
            self.tableHtml = html;
        },
        updateDataFromTable: function(id, content, statusVerifikasi) {
            var self = this;
            self.form_id_data = id;
            // Decode HTML entities
            self.form_content = content.replace(/&#39;/g, "'").replace(/&quot;/g, '"');
            self.form_status_verifikasi = parseInt(statusVerifikasi) || 1;
        },
    }
});

$(document).ready(function() {
    vm.setDatas();
    // Make updateDataFromTable accessible globally
    window.vm = vm;
});

$( "#save-btn" ).click(function(e) {
    vm.saveData();
});
</script>
@endsection

