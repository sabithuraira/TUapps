@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">PROSES PERMINTAAN BARANG</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <div class="row m-b-15">
            <div class="col-md-3">
              <label>Filter Status:</label>
              <select class="form-control" v-model="filter_status_aktif" @change="setDatas">
                <option value="">Semua Status</option>
                @if(isset($list_status_aktif))
                  @foreach($list_status_aktif as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                  @endforeach
                @else
                  <option value="1">Diajukan</option>
                  <option value="2">Disetujui</option>
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <label>Filter Unit Kerja:</label>
              <select class="form-control" v-model="filter_unit_kerja4" @change="setDatas">
                <option value="">Semua Unit Kerja</option>
                @foreach ($unit_kerja4 ?? [] as $key=>$value)
                  <option value="{{ $value->id }}">{{ $value->nama }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <section class="datas">
            @include('opname_permintaan.list_proses')
          </section>
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
    
    <div class="modal" id="form_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="title" id="defaultModalLabel">Proses Permintaan Barang</b>
                </div>
                <div class="modal-body">
                    <input type="hidden" v-model="form_id_data">
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Read-only fields -->
                            <div class="form-group">
                                <label>Barang:</label>
                                <div class="form-line">
                                    <input type="text" :value="form_barang_nama" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Permintaan:</label>
                                <div class="form-line">
                                    <input type="text" :value="form_tanggal_permintaan_display" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Diminta:</label>
                                <div class="form-line">
                                    <input type="text" :value="form_jumlah_diminta" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Editable fields -->
                            <div class="form-group">
                                <label>Tanggal Penyerahan: <span class="text-danger">*</span></label>
                                <div class="form-line">
                                    <input type="date" v-model="form_tanggal_penyerahan" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit Kerja:</label>
                                <div class="form-line">
                                    <input type="text" :value="form_unit_kerja_nama" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Disetujui: <span class="text-danger">*</span></label>
                                <div class="form-line">
                                    <input type="number" v-model="form_jumlah_disetujui" class="form-control" placeholder="Jumlah disetujui" min="0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Status Aktif: <span class="text-danger">*</span></label>
                                <div class="form-line">
                                    <select class="form-control" v-model="form_status_aktif">
                                        @if(isset($list_status_aktif))
                                            @foreach($list_status_aktif as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        @else
                                            <option value="1">Diajukan</option>
                                            <option value="2">Disetujui</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" v-if="form_status_aktif == 2">
                                <label>Barang untuk Pengurangan: <span class="text-danger">*</span></label>
                                <div class="form-line">
                                    <select class="form-control show-tick ms select2" v-model="form_id_barang_pengurangan" id="form_id_barang_pengurangan">
                                        <option value="">- Pilih Barang -</option>
                                        @foreach ($master_barang ?? [] as $key=>$value)
                                            <option value="{{ $value->id }}">{{ $value->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-muted">Pilih barang yang akan dikurangi dari stok</small>
                            </div>
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
</div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <style type="text/css">
        .modal-dialog{ overflow-y: initial !important }
        .modal-body{ height: 80vh; overflow-y: auto; }
    </style>
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script>

<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      datas: [],
      pathname : window.location.pathname,
      filter_status_aktif: '',
      filter_unit_kerja4: '',
      form_id_data: '',
      form_barang_nama: '',
      form_tanggal_permintaan: '',
      form_tanggal_permintaan_display: '',
      form_tanggal_penyerahan: '',
      form_jumlah_diminta: '',
      form_jumlah_disetujui: '',
      form_unit_kerja_nama: '',
      form_status_aktif: 1,
      form_id_barang_pengurangan: '',
    },
    methods: {
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : "{{ url('/opname_permintaan/load_data_proses') }}",
                method : 'post',
                dataType: 'json',
                data: {
                    filter_status_aktif: self.filter_status_aktif || '',
                    filter_unit_kerja4: self.filter_unit_kerja4 || ''
                }
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        updateData: function (event) {
            var self = this;
            if (event) {
                var target = event.currentTarget;
                var dataId = target.getAttribute('data-id');
                var dataObj = self.datas.find(function(item) { return item.id == dataId; });
                
                if (dataObj) {
                    self.form_id_data = dataObj.id;
                    self.form_barang_nama = dataObj.master_barang ? dataObj.master_barang.nama_barang : '-';
                    self.form_tanggal_permintaan = dataObj.tanggal_permintaan;
                    self.form_tanggal_permintaan_display = self.formatDate(dataObj.tanggal_permintaan);
                    self.form_tanggal_penyerahan = dataObj.tanggal_penyerahan || '';
                    self.form_jumlah_diminta = dataObj.jumlah_diminta;
                    self.form_jumlah_disetujui = dataObj.jumlah_disetujui || '';
                    self.form_unit_kerja_nama = dataObj.unit_kerja4 ? dataObj.unit_kerja4.nama : '-';
                    self.form_status_aktif = dataObj.status_aktif || 1;
                    self.form_id_barang_pengurangan = ''; // Reset barang pengurangan
                }
            }
        },
        saveData: function () {
            var self = this;
            
            // Validate if status is "Disetujui" (2), barang pengurangan must be selected
            if (self.form_status_aktif == 2 && !self.form_id_barang_pengurangan) {
                alert('Mohon pilih barang untuk pengurangan ketika status disetujui.');
                return;
            }
            
            // Validate tanggal_penyerahan and jumlah_disetujui when status is "Disetujui"
            if (self.form_status_aktif == 2) {
                if (!self.form_tanggal_penyerahan) {
                    alert('Mohon isi tanggal penyerahan.');
                    return;
                }
                if (!self.form_jumlah_disetujui || self.form_jumlah_disetujui <= 0) {
                    alert('Mohon isi jumlah disetujui dengan nilai yang valid.');
                    return;
                }
            }
            
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : "{{ url('/opname_permintaan/update_proses') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.form_id_data,
                    form_tanggal_penyerahan: self.form_tanggal_penyerahan || null,
                    form_jumlah_disetujui: self.form_jumlah_disetujui || null,
                    form_status_aktif: self.form_status_aktif || 1,
                    form_id_barang_pengurangan: self.form_id_barang_pengurangan || null
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
        getStatusLabel: function(status) {
            if (status == 1) return 'Diajukan';
            if (status == 2) return 'Disetujui';
            return '';
        }
    },
    watch: {
        form_status_aktif: function(newVal) {
            var self = this;
            if (newVal == 2) {
                // Initialize select2 when status changes to "Disetujui"
                setTimeout(function() {
                    if ($('#form_id_barang_pengurangan').length) {
                        $('#form_id_barang_pengurangan').select2({
                            placeholder: '- Pilih Barang -',
                            allowClear: true
                        });
                    }
                }, 100);
            } else {
                // Destroy select2 when status is not "Disetujui"
                setTimeout(function() {
                    if ($('#form_id_barang_pengurangan').hasClass('select2-hidden-accessible')) {
                        $('#form_id_barang_pengurangan').select2('destroy');
                    }
                }, 100);
            }
        }
    }
});

$(document).ready(function() {
    vm.setDatas();
    
    // Initialize select2 for barang pengurangan dropdown when modal opens
    $('#form_modal').on('shown.bs.modal', function () {
        setTimeout(function() {
            if ($('#form_id_barang_pengurangan').length && vm.form_status_aktif == 2) {
                if (!$('#form_id_barang_pengurangan').hasClass('select2-hidden-accessible')) {
                    $('#form_id_barang_pengurangan').select2({
                        placeholder: '- Pilih Barang -',
                        allowClear: true
                    });
                }
            }
        }, 100);
    });
    
    // Handle select2 change event
    $(document).on("select2-selecting", "#form_id_barang_pengurangan", function(e) { 
        vm.form_id_barang_pengurangan = e.choice.id;
    });
});

$( "#save-btn" ).click(function(e) {
    vm.saveData();
});
</script>
@endsection

