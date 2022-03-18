@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">OPNAME PERSEDIAAN</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <a href="#" role="button" v-on:click="addBarangMasuk"  class="btn btn-primary" data-toggle="modal" data-target="#add_pengurangan"><i class="fa fa-plus-circle"></i> <span>Penambahan</span></a>
          
          <a href="#" role="button" v-on:click="addBarangKeluar"  class="btn btn-danger" data-toggle="modal" data-target="#add_pengurangan"><i class="fa fa-minus-circle"></i> <span>Barang Keluar</span></a>
          <br/><br/>
          <form action="{{url('opname_persediaan')}}" method="get">
            <div class="input-group mb-3">
                    
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bulan:</label>
                        <select class="form-control" name="month" v-model="month">
                            <option value="">- Pilih Bulan -</option>
                            @foreach ( config('app.months') as $key=>$value)
                                <option value="{{ $key }}" 
                                    @if ($month == $key)
                                        selected="selected"
                                    @endif >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tahun:</label>
                        <select class="form-control" name="year" v-model="year">
                            <option value="">- Pilih Tahun -</option>
                            @for($i=2019;$i<=date('Y');++$i)
                                <option value="{{ $i }}" 
                                    @if ($year == $i)
                                        selected="selected"
                                    @endif >{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
          </form>
          <section class="datas">
            @include('opname_persediaan.list')
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
    
    <div class="modal" id="add_pengurangan" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b v-if="form_current_jenis==2" class="title" id="defaultModalLabel">Form Barang Keluar</b>
                    <b v-if="form_current_jenis==1" class="title" id="defaultModalLabel">Form Barang Masuk</b>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Barang: 
                        <div class="form-line">
                            <select class="form-control"  v-model="form_id_barang" autofocus>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($master_barang as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->nama_barang }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <input type="hidden" v-model="form_id_data">
                       
                    <div class="form-group">
                        Jumlah
                        <div class="form-line">
                            <input type="number" v-model="form_jumlah" class="form-control" placeholder="Jumlah barang">
                        </div>
                    </div> 

                    <div v-if="form_current_jenis==2" class="form-group">
                        Barang Usang
                        <div class="form-line">
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox" v-model="form_is_usang">
                                <span>Check jika barang ini keluar karena dinyatakan "USANG"</span>
                            </label>
                        </div>

                        <div v-if="!form_is_usang" class="form-group">
                            Unit Kerja:
                            <div class="form-line">
                                <select class="form-control"  v-model="form_unit_kerja" autofocus>
                                    <option value="">- Pilih Unit Kerja -</option>
                                    @foreach ($unit_kerja as $key=>$value)
                                        <option value="{{ $value->id }}">{{ $value->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div v-else>
                            Keterangan Usang:
                            <div class="form-line">
                                <input type="text" v-model="form_keterangan_usang" class="form-control" placeholder="Keterangan usang..">
                            </div>
                        </div>
                    </div>

                    <div v-if="form_current_jenis==1" class="form-group">
                        Penyedia:
                        <div class="form-line">
                            <input type="text" v-model="form_nama_penyedia" class="form-control" placeholder="Nama Penyedia">
                        </div>
                    </div>

                    <div class="form-group">
                        Tanggal:
                        <div class="form-line">
                            <select class="form-control"  v-model="form_tanggal" autofocus>
                                <option value="">- Pilih Tanggal -</option>
                                @for($i=1;$i<=31;++$i)
                                    <option value="{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-btn">SAVE</button>
                    <button  v-show="form_id_data!=''" type="button" class="btn btn-danger" id="delete-btn">DELETE</button>
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
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/markdown/markdown.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/to-markdown/to-markdown.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-markdown/bootstrap-markdown.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>

<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      datas: [],
      list_detail: [],
      month: parseInt({!! json_encode($month) !!}),
      months: [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
      ],
      year: {!! json_encode($year) !!},
      pathname : window.location.pathname,
      form_id_data: '',
      form_id_barang: '',
      form_jumlah: '',
      form_unit_kerja: '',
      form_nama_penyedia: '',
      form_tanggal: '',
      form_is_usang: '',
      form_keterangan_usang: '',
      form_current_jenis: 1, //1 penambahan, 2 pengurangan
      current_nama_barang: '',
    },
    computed: {
        headerOnDetail: function () {
            var result = 'Detail Barang ';
            if(this.form_current_jenis==1) result += "Masuk "
            else result += "Keluar "

            result += this.months[this.month] + " " + this.year;
            result += " (" + this.current_nama_barang + ")"

            return result
        }
    },
    watch: {
        month: function (val) {
            this.setDatas();
        },
        year: function (val) {
            this.setDatas();
        },
    },
    methods: {
        detailTambah: function(event){
            var self = this;
            $('#wait_progres').modal('show');
            
            self.form_current_jenis= event.currentTarget.getAttribute('data-jenis');
            let id_barang =  event.currentTarget.getAttribute('data-idbarang');
            self.current_nama_barang = event.currentTarget.getAttribute('data-namabarang');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : self.pathname+"/load_rincian",
                method : 'post',
                dataType: 'json',
                data:{
                    month: self.month,
                    year: self.year,
                    id_barang: id_barang,
                    jenis: self.form_current_jenis
                },
            }).done(function (data) {
                self.list_detail = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
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
                data:{
                    month: self.month,
                    year: self.year,
                },
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        addBarangKeluar: function (event) {
            var self = this;
            if (event) {
                self.form_current_jenis = 2;
                self.form_id_data = '';
                self.form_id_barang = '';
                self.form_jumlah = '';
                self.form_unit_kerja = '';
                self.form_tanggal = '';
                self.form_is_usang = '';
                self.form_keterangan_usang = '';
            }
        },
        updateBarangKeluar: function (event) {
            var self = this;
            $('#detail_tambah').modal('hide');
            if (event) {
                self.form_current_jenis = 2;
                self.form_id_data = event.currentTarget.getAttribute('data-id');
                self.form_id_barang = event.currentTarget.getAttribute('data-idbarang');
                self.form_jumlah = event.currentTarget.getAttribute('data-jumlah');
                self.form_unit_kerja = event.currentTarget.getAttribute('data-unitkerja');
                self.form_keterangan_usang = event.curketerangan_usang.getAttribute('data-unitkerja');
                var temp_tanggal = event.currentTarget.getAttribute('data-tanggal');
                self.form_tanggal = parseInt(temp_tanggal.split('-')[2]);
            }
        },
        addBarangMasuk: function (event) {
            var self = this;
            if (event) {
                self.form_current_jenis = 1;
                self.form_id_data = '';
                self.form_id_barang = '';
                self.form_jumlah = '';
                self.form_nama_penyedia = '';
                self.form_tanggal = '';
            }
        },
        updateBarangMasuk: function (event) {
            var self = this;
            $('#detail_tambah').modal('hide');
            if (event) {
                self.form_current_jenis = 1;
                self.form_id_data = event.currentTarget.getAttribute('data-id');
                self.form_id_barang = event.currentTarget.getAttribute('data-idbarang');
                self.form_jumlah = event.currentTarget.getAttribute('data-jumlah');
                self.form_nama_penyedia = event.currentTarget.getAttribute('data-namapenyedia');
                var temp_tanggal = event.currentTarget.getAttribute('data-tanggal');
                self.form_tanggal = parseInt(temp_tanggal.split('-')[2]);

            }
        },
        saveBarangKeluarMasuk: function () {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            if(self.form_current_jenis==1){
                $.ajax({
                    url : "{{ url('/opname_persediaan/store_barang_masuk/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        form_id_data: self.form_id_data,
                        form_month: self.month,
                        form_year: self.year,
                        form_id_barang: self.form_id_barang, 
                        form_jumlah: self.form_jumlah, 
                        form_nama_penyedia: self.form_nama_penyedia,
                        form_tanggal: self.form_tanggal,
                    },
                }).done(function (data) {
                    $('#add_pengurangan').modal('hide');
                    window.location.reload(false); 
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
                });
            }
            else{
                $.ajax({
                    url : "{{ url('/opname_persediaan/store_barang_keluar/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        form_id_data: self.form_id_data,
                        form_month: self.month,
                        form_year: self.year,
                        form_id_barang: self.form_id_barang, 
                        form_jumlah: self.form_jumlah, 
                        form_keterangan_usang: self.form_keterangan_usang,
                        form_tanggal: self.form_tanggal, 
                    },
                }).done(function (data) {
                    $('#add_pengurangan').modal('hide');
                    window.location.reload(false); 
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
                });
            }
        },
        deleteBarang: function () {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            if(self.form_current_jenis==1){
                $.ajax({
                    url : "{{ url('/opname_persediaan/delete_barang_masuk/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        form_id_data: self.form_id_data,
                    },
                }).done(function (data) {
                    $('#add_pengurangan').modal('hide');
                    window.location.reload(false); 
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            }
            else{
                $.ajax({
                    url : "{{ url('/opname_persediaan/delete_barang_keluar/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        form_id_data: self.form_id_data,
                    },
                }).done(function (data) {
                    $('#add_pengurangan').modal('hide');
                    window.location.reload(false); 
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            }
            
        },
        dateOnlyFormat:function(tanggal){
          var self = this;
          var toDate = new Date(tanggal);
          var date_label = toDate.getDate();

          return date_label;
        },
        moneyFormat:function(amount){
          var decimalCount = 0;
          var decimal = ".";
          var thousands = ",";
          decimalCount = Math.abs(decimalCount);
          decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

          const negativeSign = amount < 0 ? "-" : "";

          let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
          let j = (i.length > 3) ? i.length % 3 : 0;

          return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");      
        },
    }
});

$(document).ready(function() {
    vm.setDatas();
});

$( "#add-btn" ).click(function(e) {
    vm.saveBarangKeluarMasuk();
});

$( "#delete-btn" ).click(function(e) {
    vm.deleteBarang();
});
</script>
@endsection