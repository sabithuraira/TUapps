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
                
                <div>
                    <a href="{{action('JadwalDinasController@create')}}" class="'btn btn-primary btn-sm"><i class='fa fa-list'></i> Daftar Jadwal Tugas</a>
                    
                    <a href="{{action('JadwalDinasController@create')}}" class="'btn btn-success btn-sm"><i class='fa fa-plus'></i> Tambah Jadwal Tugas</a>
                </div>
                <!-- /.pull-right -->
            </div>
            <br/>
            <div class="mailbox-controls">
                <b>Kalender Jadwal Tugas - </b>
                
                <select v-model="unit_kerja">
                    @foreach ($unit_kerja as $key=>$value)
                        <option value="{{ $value->id }}">{{ $value->nama }}
                        </option>
                    @endforeach
                </select>

                <div class="pull-right">
                    <select name="month" v-model="month">
                        @foreach ( config('app.months') as $key=>$value)
                            <option value="{{ $key }}" >{{ $value }}</option>
                        @endforeach
                    </select>

                    <select name="year" v-model="year">
                        @for($i=2019;$i<=date('Y');++$i)
                            <option value="{{ $i }}" >{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <!-- /.pull-right -->
            </div>
        </div>

        <div class="box-body">
            <div class="scrollme"> 
                <table class="table table-bordered table-sm">
                    <thead v-html="html_header"></thead>
                    <tbody v-html="html_body"></tbody>
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
    el: "#calendar_tag",
    data: {
        hello: "Hello world",
        list_name: [],
        data : [],
        total_day: 30,
        month: new Date().getMonth()+1,
        year: new Date().getFullYear(),
        unit_kerja:  parseInt({!! json_encode($cur_unit_kerja) !!}),
        pathname:  window.location.pathname,
        html_header: '',
        html_body: '',
    },
    computed: {
        generateEmptyId: function(){    
            str_result="";
            for(var i=1;i<=this.total_day;++i){
                str_result += '<td></td>';
            }
            return str_result;
        }, 
    },
    
    watch: {
        month: function (val) {
            this.grabListName();
        },
        year: function (val) {
            this.grabListName();
        },
        unit_kerja: function (val) {
            this.grabListName();
        },
    },
    methods: {
        grabListName: function(){
            var self = this;

            self.html_header = '';
            self.html_body = '';
            $('#wait_progres').modal('show');

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            })
            $.ajax({
                url : self.pathname+"/list_pegawai",
                method : 'post',
                dataType: 'json',
                data:{
                    unit_kerja: self.unit_kerja,
                },
            }).done(function (data) {
                self.list_name = data.datas;
                self.grabDatas();
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        grabDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            })
            $.ajax({
                url : self.pathname+"/list_kegiatan",
                method : 'post',
                dataType: 'json',
                data:{
                    month: self.month,
                },
            }).done(function (data) {
                self.data=data.data;
                self.generateTable();
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        generateTable: function(){
            var self = this;
            
            self.generateHeader();
            self.generateBody();
            self.setJadwal();
        }, 
        setJadwal: function(){
            var self = this;
            
            for(var i=0;i<self.data.length;++i){
                setCellJadwal(self.data[i]);
            }
        },
        setCellJadwal: function(data){
            var self = this;
            
            if(self.data.start_date==self.data.end_date){
                $("#id"+self.data.nip+" td").eq(self.data.start_date+1).addClass("red");
            }
            else{
                var total_jadwal = self.data.end_date - self.data.start_date + 1;
                var start_cell= $("#id"+self.data.nip+" td").eq(parseInt(self.data.start_date)+1);
                
                start_cell.attr('colspan',total_jadwal);
                start_cell.addClass("red");
                start_cell.append(self.data.judul);
                
                for(var d=parseInt(self.data.start_date)+1;d<=parseInt(self.data.end_date);++d){
                    $("#id"+self.data.nip+" td").eq(d+1).remove();
                }
            }
        },
        generateHeader: function(){
            var self = this;
            self.html_header ='<th style="width: 20px"></th><th></th>';
            for(var i=1;i<=self.total_day;++i){
                self.html_header += '<th style="width: 30px">'+i+'</th>';
            }
        },
        generateBody: function(){
            var self = this;
            self.html_body = '';

            for(var i=0 ;i < self.list_name.length; ++i){
                self.html_body += '<tr id="id'+self.list_name[i].id+'"><td>'+(i+1)+'.</td>';
                self.html_body += '<td>'+self.list_name[i].name+'</td>';
                self.html_body += self.generateEmptyId;
                self.html_body += '</tr>';
            }
        },
    }
});


$(document).ready(function() {
    vm.grabListName();
});
</script>
@endsection