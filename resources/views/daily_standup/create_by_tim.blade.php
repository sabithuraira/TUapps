@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">DAILY STANDUP PER TIM</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      @if (\Session::has('error'))
        <div class="alert alert-danger">
          <p>{{ \Session::get('error') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <h4>Input Daily Standup Per Tim</h4>
          <hr>
          
          <form id="daily_standup_form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Pilih Tim: <span class="text-danger">*</span></label>
                  <div class="form-line">
                    <select class="form-control" v-model="form_tim_id" @change="loadAnggota" required>
                      <option value="">- Pilih Tim -</option>
                      @foreach ($list_tim ?? [] as $tim)
                        <option value="{{ $tim->id }}">{{ $tim->nama_tim }} ({{ $tim->tahun }})</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal: <span class="text-danger">*</span></label>
                  <div class="form-line">
                    <input type="date" v-model="form_tanggal" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table for anggota -->
            <div v-if="anggota_list.length > 0" class="m-t-20">
              <h5>Anggota Tim</h5>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th style="width: 30%;">Nama Anggota</th>
                      <th style="width: 20%;">NIP</th>
                      <th style="width: 45%;">Isi Daily Standup <span class="text-danger">*</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(anggota, index) in anggota_list" :key="anggota.id">
                      <td>@{{ index + 1 }}</td>
                      <td>@{{ anggota.nama_anggota }}</td>
                      <td>@{{ anggota.nik_anggota }}</td>
                      <td>
                        <input 
                          type="text" 
                          v-model="anggota.isi" 
                          class="form-control" 
                          :placeholder="'Masukkan isi standup untuk ' + anggota.nama_anggota"
                          required>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <div class="m-t-20">
                <button type="button" @click="saveData" class="btn btn-primary" :disabled="!canSave">
                  <i class="fa fa-save"></i> Simpan Data
                </button>
                <button type="button" @click="resetForm" class="btn btn-secondary">
                  <i class="fa fa-refresh"></i> Reset
                </button>
              </div>
            </div>

            <div v-else-if="form_tim_id && !loading_anggota" class="alert alert-info m-t-20">
              <i class="fa fa-info-circle"></i> Tidak ada anggota aktif untuk tim yang dipilih.
            </div>

            <div v-if="loading_anggota" class="text-center m-t-20">
              <i class="fa fa-spinner fa-spin"></i> Memuat data anggota...
            </div>
          </form>
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
@endsection

@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
  <style type="text/css">
      .table th {
          background-color: #f8f9fa;
          font-weight: bold;
      }
  </style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data: {
      form_tim_id: '',
      form_tanggal: '',
      anggota_list: [],
      loading_anggota: false,
    },
    computed: {
      canSave: function() {
        if (!this.form_tim_id || !this.form_tanggal || this.anggota_list.length === 0) {
          return false;
        }
        
        // Check if at least one anggota has isi filled
        var hasData = this.anggota_list.some(function(anggota) {
          return anggota.isi && anggota.isi.trim() !== '';
        });
        
        return hasData;
      }
    },
    methods: {
      loadAnggota: function() {
        var self = this;
        
        if (!self.form_tim_id) {
          self.anggota_list = [];
          return;
        }
        
        self.loading_anggota = true;
        self.anggota_list = [];
        
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        
        $.ajax({
          url: "{{ url('daily_standup/get-anggota-by-tim') }}",
          method: 'get',
          dataType: 'json',
          data: {
            tim_id: self.form_tim_id
          }
        }).done(function (response) {
          if (response.success == '1' && response.data.length > 0) {
            // Add isi field to each anggota
            self.anggota_list = response.data.map(function(anggota) {
              return {
                id: anggota.id,
                nama_anggota: anggota.nama_anggota,
                nik_anggota: anggota.nik_anggota,
                isi: ''
              };
            });
          } else {
            self.anggota_list = [];
          }
          self.loading_anggota = false;
        }).fail(function (msg) {
          console.log(JSON.stringify(msg));
          self.loading_anggota = false;
          alert('Gagal memuat data anggota. Silakan coba lagi.');
        });
      },
      saveData: function() {
        var self = this;
        
        // Validate
        if (!self.form_tim_id || !self.form_tanggal) {
          alert('Mohon lengkapi Tim dan Tanggal terlebih dahulu.');
          return;
        }
        
        // Filter only anggota with isi filled
        var dataToSave = self.anggota_list
          .filter(function(anggota) {
            return anggota.isi && anggota.isi.trim() !== '';
          })
          .map(function(anggota) {
            return {
              nik_anggota: anggota.nik_anggota,
              isi: anggota.isi.trim()
            };
          });
        
        if (dataToSave.length === 0) {
          alert('Mohon isi minimal satu daily standup untuk anggota tim.');
          return;
        }
        
        $('#wait_progres').modal('show');
        
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        
        $.ajax({
          url: "{{ url('daily_standup/store-by-tim') }}",
          method: 'post',
          dataType: 'json',
          data: {
            tim_id: self.form_tim_id,
            tanggal: self.form_tanggal,
            data: dataToSave
          }
        }).done(function (response) {
          $('#wait_progres').modal('hide');
          
          if (response.success == '1') {
            alert('Data berhasil disimpan!\nBerhasil: ' + response.inserted_count + ' data\nGagal: ' + response.failed_count + ' data');
            self.resetForm();
          } else {
            alert('Gagal menyimpan data: ' + (response.message || 'Unknown error'));
          }
        }).fail(function (msg) {
          $('#wait_progres').modal('hide');
          console.log(JSON.stringify(msg));
          alert('Gagal menyimpan data. Silakan coba lagi.');
        });
      },
      resetForm: function() {
        var self = this;
        self.form_tim_id = '';
        self.form_tanggal = '';
        self.anggota_list = [];
      }
    }
});

// Set default tanggal to today
$(document).ready(function() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0');
  var yyyy = today.getFullYear();
  vm.form_tanggal = yyyy + '-' + mm + '-' + dd;
});
</script>
@endsection
