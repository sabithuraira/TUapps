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
          <a href="{{action('OpnamePersediaanController@create')}}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <span>Penambahan</span></a>
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

    
    <div class="modal fade" id="add_pengurangan" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">Tambah Barang Keluar</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
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
                        <div class="form-line">
                            <input type="number" v-model="form_jumlah" class="form-control" placeholder="Jumlah barang">
                        </div>
                    </div> 

                    <div class="form-group">
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

                    <div class="form-group">
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
                    <button type="button" class="btn btn-primary" id="add-btn">Add</button>
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
      month: parseInt({!! json_encode($month) !!}),
      year: {!! json_encode($year) !!},
      pathname : window.location.pathname,
      form_id_data: '',
      form_id_barang: '',
      form_jumlah: '',
      form_unit_kerja: '',
      form_tanggal: ''
    },
    computed: {
        label_op_awal: function () {
            return "op_awal_" + this.month
        },
        label_op_tambah: function () {
            return "op_tambah_" + this.month
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
                console.log(self.datas);

                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        addBarangKeluar: function (event) {
            var self = this;
            if (event) {
                self.form_id_data = '';
                self.form_id_barang = '';
                self.form_jumlah = '';
                self.form_unit_kerja = '';
                self.form_tanggal = '';
            }
        },
        updateBarangKeluar: function (event) {
            var self = this;
            if (event) {
                self.form_id_data = event.target.getAttribute('data-id');
                self.form_id_barang = event.target.getAttribute('data-idbarang');
                self.form_jumlah = event.target.getAttribute('data-jumlah');
                self.form_unit_kerja = event.target.getAttribute('data-unitkerja');
                self.form_tanggal = event.target.getAttribute('data-tanggal');

                console.log(self.form_id_data);
            }
        },
        saveBarangKeluar: function () {
            var self = this;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
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
                    form_unit_kerja: self.form_unit_kerja,
                    form_tanggal: self.form_tanggal, 
                },
            }).done(function (data) {
                $('#add_pengurangan').modal('hide');
                window.location.reload(false); 
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
            });
        },
    }
});

$(document).ready(function() {
    vm.setDatas();
});

$( "#add-btn" ).click(function(e) {
    vm.saveBarangKeluar();
});
</script>
@endsection