@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>             
    <li class="breadcrumb-item"><a href="{{url('izin_keluar')}}"> Permohonan Izin Keluar</a></li>                      
    <li class="breadcrumb-item">Pegawai Izin Hari Ini</li>
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
          <h4 class="text-center">Daftar Pegawai Izin Keluar Hari Ini</h4>
          <section class="datas">
              <div class="table-responsive">
                <table class="table-bordered m-b-0"  style="min-width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Pegawai</th>
                            <th class="text-center">Waktu</th>
                            <th class="text-center" style="width: 50%" >Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in datas" :key="data.id">
                            <td class="px-2">@{{ index+1 }}</td>
                            <td class="text-center pt-2">
                                @{{ data.name }}<br/>
                                <span class="text-muted">@{{ data.pegawai_nip }}</span>
                            </td>
                            <td class="text-center pt-2">
                                @{{ data.tanggal }} pukul: @{{ data.start }} - @{{ data.end }}
                                <p class="text-muted">Durasi: @{{ data.total_minutes }} Menit</p>
                            </td>
                            
                            <td class="px-2">
                                @{{ data.keterangan }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </section>

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
  </div>
@endsection



@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
    <style type="text/css">
        * {font-family: Segoe UI, Arial, sans-serif;}
        table{font-size: small;border-collapse: collapse;}
        tfoot tr td{font-weight: bold;font-size: small;}
    </style>
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/select2/select2.min.js') !!}"></script> <!-- Select2 Js -->
<script>
                
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        datas: [],
    },
    methods: {
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            })
            $.ajax({
                url :  "{{ url('/izin_keluar/data_rekap_today') }}",
                method : 'post',
                dataType: 'json',
            }).done(function (data) {
                self.datas = data.datas;
                // console.log(self.datas)
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
