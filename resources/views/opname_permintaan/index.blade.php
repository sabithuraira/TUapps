@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">OPNAME PERMINTAAN</li>
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
          <a href="#" role="button" v-on:click="addData" class="btn btn-primary" data-toggle="modal" data-target="#form_modal"><i class="fa fa-plus-circle"></i> <span>Tambah Permintaan</span></a>
          <br/><br/>
          <section class="datas">
            @include('opname_permintaan.list')
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
                    <b class="title" id="defaultModalLabel">Form Permintaan Barang</b>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Barang: 
                        <div class="form-line">
                            <select class="form-control show-tick ms select2" v-model="form_id_barang" id="form_id_barang" autofocus>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($master_barang ?? [] as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" v-model="form_id_data">
                       
                    <div class="form-group">
                        Tanggal Permintaan:
                        <div class="form-line">
                            <input type="date" v-model="form_tanggal_permintaan" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        Jumlah Diminta:
                        <div class="form-line">
                            <input type="number" v-model="form_jumlah_diminta" class="form-control" placeholder="Jumlah diminta">
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" v-model="form_tanggal_penyerahan">
                    <input type="hidden" v-model="form_jumlah_disetujui">
                    <input type="hidden" v-model="form_status_aktif">
                    <input type="hidden" v-model="form_unit_kerja">

                    <div class="form-group">
                        Unit Kerja 4:
                        <div class="form-line">
                            <select class="form-control" v-model="form_unit_kerja4" autofocus>
                                <option value="">- Pilih Unit Kerja 4 -</option>
                                @foreach ($unit_kerja4 ?? [] as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-btn">SAVE</button>
                    <button v-show="form_id_data!=''" type="button" class="btn btn-danger" id="delete-btn">DELETE</button>
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
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/markdown/markdown.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/to-markdown/to-markdown.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-markdown/bootstrap-markdown.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script>

<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      datas: [],
      pathname : window.location.pathname,
      form_id_data: '',
      form_id_barang: '',
      form_tanggal_permintaan: '',
      form_tanggal_penyerahan: null,
      form_jumlah_diminta: '',
      form_jumlah_disetujui: null,
      form_unit_kerja: '18',
      form_unit_kerja4: '',
      form_status_aktif: 1,
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
                url : self.pathname+"/load_data",
                method : 'post',
                dataType: 'json',
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        addData: function (event) {
            var self = this;
            if (event) {
                self.form_id_data = '';
                self.form_id_barang = '';
                self.form_tanggal_permintaan = '';
                self.form_tanggal_penyerahan = null;
                self.form_jumlah_diminta = '';
                self.form_jumlah_disetujui = null;
                self.form_unit_kerja = '1600';
                self.form_unit_kerja4 = '';
                self.form_status_aktif = 1;
            }
        },
        updateData: function (event) {
            var self = this;
            if (event) {
                var target = event.currentTarget;
                self.form_id_data = target.getAttribute('data-id');
                self.form_id_barang = target.getAttribute('data-id-barang');
                self.form_tanggal_permintaan = target.getAttribute('data-tanggal-permintaan');
                self.form_tanggal_penyerahan = target.getAttribute('data-tanggal-penyerahan') || null;
                self.form_jumlah_diminta = target.getAttribute('data-jumlah-diminta');
                self.form_jumlah_disetujui = target.getAttribute('data-jumlah-disetujui') || null;
                
                // Get unit_kerja4 from the data object
                var dataId = target.getAttribute('data-id');
                var dataObj = self.datas.find(function(item) { return item.id == dataId; });
                if (dataObj) {
                    self.form_unit_kerja = '1600'; // Always set to 1600
                    self.form_unit_kerja4 = dataObj.unit_kerja4 ? dataObj.unit_kerja4.id : '';
                } else {
                    self.form_unit_kerja = '1600';
                    self.form_unit_kerja4 = '';
                }
                
                self.form_status_aktif = target.getAttribute('data-status-aktif');
                
                // Update select2
                setTimeout(function() {
                    $('#form_id_barang').val(self.form_id_barang).trigger('change');
                }, 100);
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
                url : "{{ url('/opname_permintaan') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.form_id_data,
                    form_id_barang: self.form_id_barang, 
                    form_tanggal_permintaan: self.form_tanggal_permintaan,
                    form_tanggal_penyerahan: self.form_tanggal_penyerahan || null,
                    form_jumlah_diminta: self.form_jumlah_diminta,
                    form_jumlah_disetujui: self.form_jumlah_disetujui || null,
                    form_unit_kerja: self.form_unit_kerja,
                    form_unit_kerja4: self.form_unit_kerja4,
                    form_status_aktif: self.form_status_aktif || 1
                },
            }).done(function (data) {
                $('#form_modal').modal('hide');
                self.setDatas();
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        deleteData: function () {
            var self = this;
            if(!confirm('Apakah Anda yakin ingin menghapus data ini?')){
                return;
            }
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : "{{ url('/opname_permintaan/destroy') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.form_id_data,
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
    }
});

$(document).ready(function() {
    vm.setDatas();
    $('.select2').select2();
});

$('#form_id_barang').on("select2-selecting", function(e) { 
    vm.form_id_barang = e.choice.id
});

$( "#save-btn" ).click(function(e) {
    vm.saveData();
});

$( "#delete-btn" ).click(function(e) {
    vm.deleteData();
});
</script>
@endsection

