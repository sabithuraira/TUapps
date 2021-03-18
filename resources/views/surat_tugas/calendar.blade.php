@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Kalender Jadwal Tugas</li>
</ul>
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
                        <option value="{{ $key }}" >{{ $value }}</option>
                    @endforeach
                </select>

                <select name="year" v-model="year">
                    @for($i=2019;$i<=date('Y');++$i)
                        <option value="{{ $i }}" >{{ $i }}</option>
                    @endfor
                </select>

                <div class="pull-right">
                
                    <select v-model="unit_kerja">
                        @foreach ($unit_kerja as $key=>$value)
                            <option value="{{ $value->id }}">{{ $value->nama }}
                            </option>
                        @endforeach
                    </select>
                
                    <a href="{{action('SuratTugasController@create')}}" class="'btn btn-primary btn-sm"><i class='fa fa-list'></i> Daftar Jadwal Tugas</a>
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
        thead: $("#tablehead"),
        tbody: $("#tablebody"),
    },
    watch: {
        month: function (val) {
            this.grabListName();
        },
        year: function (val) {
            this.grabListName();
        },
    },
    
    methods: {
        grabListName: function(){
            var self = this;
            thead.children().remove();
            tbody.children().remove();

            $('#wait_progres').modal('show');

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //     }
            // })
            // $.ajax({
            //     url : self.pathname+"/list_pegawai",
            //     method : 'post',
            //     dataType: 'json',
            // }).done(function (data) {
            //     self.list_name = data.data;
            //     self.grabDatas();
            //     $('#wait_progres').modal('hide');
            // }).fail(function (msg) {
            //     console.log(JSON.stringify(msg));
            //     $('#wait_progres').modal('hide');
            // });
        },
    }
});


// $(document).ready(function() {
//     month_id.val(vm.month);

//     grabListName();
// });

// month_id.change(function() {
//     vm.month = month_id.val();
//     grabListName();
// });

// function generateTable(){
//     generateHeader();
//     generateBody();
//     setJadwal();
// }

// function grabListName(){

// }

// function grabDatas()
// {
//     $.ajax({
//         url: pathname+"?r=jadwalTugas/listkegiatan&id="+vm.month,
//         dataType: 'json',
//         success: function(data) {
//             vm.data=data.data;
//             generateTable();

//             loading.css("display", "none");
//         }.bind(this),
//         error: function(xhr, status, err) {
//             console.log(xhr);
//         }.bind(this)
//     });
// }

// function setJadwal(){
//     for(var i=0;i<vm.data.length;++i){
//         setCellJadwal(vm.data[i]);
//     }
// }

// function setCellJadwal(data){
//     if(data.start_date==data.end_date){
//         $("#id"+data.nip+" td").eq(data.start_date+1).addClass("red");
//     }
//     else{
//         var total_jadwal = data.end_date - data.start_date + 1;
//         var start_cell= $("#id"+data.nip+" td").eq(parseInt(data.start_date)+1);
        
//         start_cell.attr('colspan',total_jadwal);
//         start_cell.addClass("red");
//         start_cell.append(data.judul);
        
//         for(var d=parseInt(data.start_date)+1;d<=parseInt(data.end_date);++d){
//              $("#id"+data.nip+" td").eq(d+1).remove();
//         }
//     }
// }

// function generateHeader(){
//     var str_head ='<th style="width: 20px"></th><th></th>';

//     for(var i=1;i<=vm.total_day;++i){
//         str_head += '<th style="width: 30px">'+i+'</th>';
//     }

//     thead.append(str_head);
// }

// function generateBody(){
//     var tbody = $("#tablebody");
//     // console.log(vm.list_name);
//     for(var i=0 ;i < vm.list_name.length; ++i){
//         var str_body = '<tr id="id'+vm.list_name[i].id+'"><td>'+(i+1)+'.</td>';
//         str_body += '<td class="gray">'+vm.list_name[i].name+'</td>';
//         str_body += generateEmptyTd();
//         str_body += '</tr>';

//         tbody.append(str_body);
//     }
// }

// function generateEmptyTd(){
//     str_result="";
//     for(var i=1;i<=vm.total_day;++i){
//         str_result += '<td></td>';
//     }

//     return str_result;
// }
</script>
@endsection