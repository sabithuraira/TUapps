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
          <a href="{{action('OpnamePersediaanController@create')}}" class="btn btn-danger"><i class="fa fa-minus-circle"></i> <span>Pengurangan</span></a>
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