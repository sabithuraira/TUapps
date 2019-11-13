@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Kalender Jadwal Tugas</li>
</ul>
@endsection


@section('content')

<div class="container" id="calendar_tag">
    <br />
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div><br />
    @endif

    <div class="card">
        <div class="body">
            <div class="mailbox-controls">
                <b>Kalender Jadwal Tugas - </b>
                
                <select name="month" v-model="month">
                    @foreach ( config('app.months') as $key=>$value)
                        <option value="{{ $key }}" 
                            @if ($month == $key)
                                selected="selected"
                            @endif >{{ $value }}</option>
                    @endforeach
                </select>

                <div class="pull-right">
                
                    <a href="{{action('JadwalTugasController@create')}}" class="'btn btn-primary btn-sm"><i class='fa fa-list'></i> Daftar Jadwal Tugas</a>
                </div>
                <!-- /.pull-right -->
            </div>
        </div>

        <div class="box-body">
            <div class="scrollme"> 
                <table class="table table-bordered">
                    <thead id="tablehead">
                    </thead>

                    <tbody id="tablebody">
                    </tbody>
                </table>
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
</div>

@endsection

@section('css')
    <style>
        .scrollme {
            overflow-y: auto;
        }

        td.red {
            background-color: #ff2600 !important;
            color: #fff;
            font-size: 10px;
        }

        td.yellow {
            background-color: #fece44 !important;
            color: #fff;
            font-size: 10px;
        }

        td.gray {
            background-color: #e8e8e8 !important;
        }
    </style>
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-markdown/bootstrap-markdown.min.css') !!}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

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