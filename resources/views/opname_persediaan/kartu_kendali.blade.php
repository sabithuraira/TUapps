@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('opname_persediaan')}}"> OPNAME PERSEDIAAN</a></li>                      
    <li class="breadcrumb-item">Kartu Kendali</li>
</ul>
@endsection

@section('content')
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card" id="app_vue">
        <div class="body">
          <a href="{{action('OpnamePersediaanController@index')}}" class="btn btn-primary"><i class="fa fa-list"></i> <span>Rekap Persediaan</span></a>
          <br/><br/>
          
          <div class="row clearfix">

                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Barang:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm" v-model="barang" name="barang">
                                @foreach ($list_barang as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->nama_barang }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Bulan:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm" v-model="month" name="month">
                                @foreach ( config('app.months') as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 right-box">
                    <div class="form-group">
                        <label>Tahun:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm" v-model="year" name="year">
                              @for ($i=2019;$i<=date('Y');$i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>

            </div>

          <section class="datas">
            @include('opname_persediaan.kartu_kendali_list')
          </section>
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
  </div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

<script>
  var vm = new Vue({  
      el: "#app_vue",
      data:  {
        datas: [],
        persediaan: {},
        detail_barang: {},
        month: parseInt({!! json_encode($month) !!}),
        year: parseInt({!! json_encode($year) !!}),
        barang: parseInt({!! json_encode($barang) !!}),
        months: [
          'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ],
        short_months: [
          'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
          'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des',
        ],
        pathname : window.location.pathname.replace("/kartu_kendali", ""),
      },
      watch: {
          month: function (val) {
              this.setDatas();
          },
          year: function (val) {
              this.setDatas();
          },
          barang: function (val) {
              this.setDatas();
          },
      },
      methods: {
        dateFormat:function(tanggal){
          var self = this;
          var toDate = new Date(tanggal);
          var date_label = toDate.getDate();
          var monthIndex = toDate.getMonth();

          return date_label + '-' + self.short_months[monthIndex];
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
        
          setDatas: function(){
              var self = this;
              $('#wait_progres').modal('show');
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              })
              $.ajax({
                  url : self.pathname+"/load_kartukendali",
                  method : 'post',
                  dataType: 'json',
                  data:{
                      month: self.month,
                      year: self.year,
                      barang: self.barang,
                  },
              }).done(function (data) {
                  self.datas = data.datas;
                  self.persediaan = data.persediaan;
                  self.detail_barang = data.detail_barang;
                    if(typeof self.persediaan.saldo_awal=='undefined'){
                        alert("Barang ini belum tersedia pada bulan yang dipilih");
                    }
                $('#wait_progres').modal('hide');
              }).fail(function (msg) {
                  console.log(JSON.stringify(msg));
                  $('#wait_progres').modal('hide');
              });
          },
      }
  });

  $(document).ready(function() {
      vm.setDatas();
  });
</script>
@endsection