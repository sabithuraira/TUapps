@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Kelengkapan Administrasi</li>
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
          <a href="{{action('SiraController@create_akun')}}" class="btn btn-info">Tambah Akun</a>
          <a href="{{action('SiraController@create')}}" class="btn btn-info">Tambah Bukti Administrasi</a>
          <br/><br/>

          <div class="card">
                <div class="header">
                    <h2>Bar Chart</h2>
                </div>
                <div class="body">
                    <div id="chart-bar" style="height: 16rem"></div>
                </div>
            </div>   
          <form action="{{url('sira')}}" method="get">
            <div class="input-group mb-3"> 
              @csrf
              <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

              <div class="input-group-append">
                  <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
          <section class="datas">
            @include('sira.list')
          </section>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script>

    <script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>    
    <script src="{!! asset('assets/bundles/vendorscripts.bundle.js') !!}"></script>
    <script src="{!! asset('assets/bundles/c3.bundle.js') !!}"></script>
    <script src="{!! asset('assets/bundles/mainscripts.bundle.js') !!}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                data1: ['data1'],
                data2: ['data2']
            },
            methods: {
              setData(){
                var self = this;
                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
                })

                    $.ajax({
                        url : "{{ url('/sira/get_dashboard') }}",
                        method : 'get',
                        dataType: 'json',
                    }).done(function (data) {
                        self.data1 = ['data1'].concat(data.data1);
                        self.data2 = ['data2'].concat(data.data2);
                        self.setChart();
                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
              },
              setChart(){
                    var self = this;
                    $('#wait_progres').modal('show');

                    var chart = c3.generate({
                      bindto: '#chart-bar', 
                      data: {
                          columns: [
                              self.data1,
                              self.data2
                              // ['data1', 10, 20, 9, 30,1, 3],
                              // ['data2', 10, 40, 39, 20, 100, 11],
                          ],
                          type: 'bar', 
                          colors: {
                              'data1': lucid.colors["blue"],
                              'data2': lucid.colors["pink"]
                          },
                          names: {
                              'data1': 'Belum Realisasi',
                              'data2': 'Sudah Realisasi'
                          }
                      },
                      axis: {
                          x: {
                              type: 'category',
                              categories: [
                                'Subbagian Umum', 
                                'Fungsi Sosial', 
                                'Fungsi Nerwilis', 
                                'Fungsi Statistik Distribusi', 
                                'Fungsi Statistik Produksi', 
                                'Fungsi IPDS'
                              ]
                          },
                      },
                      bar: {
                          width: 16
                      },
                      legend: {
                          show: true, //hide legend
                      },
                      padding: {
                          bottom: 40,
                          top: 0
                      },
                  });
                },
            }
        });

        $(document).ready(function() {
            // vm.setNomor();
            vm.setData();

        });
    </script>
@endsection

