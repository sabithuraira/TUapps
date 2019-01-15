@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Log Book</li>
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
          <a href="{{action('LogBookController@create')}}" class="btn btn-info">Tambah Log Book</a>
          <br/><br/>
          

          <div class="row clearfix">
                <div class="col-lg-12 col-md-12 left-box">

                    <div class="form-group">
                        <label>Rentang Waktu:</label>
                           
                        <div class="input-daterange input-group" data-provide="datepicker">
                            <input type="text" class="input-sm form-control" name="start">
                            <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                            
                            <input type="text" class="input-sm form-control" name="end">
                        </div>

                    </div>
                </div>

            </div>

          <section class="datas">
          </section>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>
<script>
    
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      datas: [],
      tanggal: parseInt({!! json_encode($tanggal) !!}),
    },
    watch: {
        // type: function (val) {
        //     this.setDatas();
        // },
        // month: function (val) {
        //     this.setDatas();
        // },
        // year: function (val) {
        //     this.setDatas();
        // },
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
                url : "{{ url('/ckp/data_ckp/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    month: self.month, 
                    year: self.year, 
                    type: self.type,
                },
            }).done(function (data) {
                self.datas = data.datas.utama;


                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        }
    }
});

$(document).ready(function() {
    vm.setDatas();
});
</script>
@endsection