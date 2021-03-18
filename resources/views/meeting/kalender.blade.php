@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Kalender Rapat Pertemuan</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

        <div class="row clearfix">
            <div class="col-lg-8">
                <div class="card">
                    <div class="body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="text-center">
                    <a href="{{action('MeetingController@create')}}" class="btn btn-info btn-lg">Tambah Rapat/Pertemuan</a>
                </div>
                <br/>
                <div class="card profile-header">
                    <div class="body">
                        <div class="text-center">
                            
                            <span v-if="e_is_secret==1" class="badge badge-danger mb-2">RAHASIA</span>
                            <div>
                                <h4 class="m-b-0"><strong></strong> @{{ e_kab }}</h4>
                                <span>@{{ e_judul }}</span>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <i class="fa fa-user fa-2x"></i>
                                    <h6>@{{ e_peserta }}</h6>
                                    <span>Peserta</span>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        
                        <div class="row">
                            <div class="col-3">Waktu</div>
                            <div class="col-9">: <span>@{{ formatDate(e_waktu_mulai) }} <b>s/d</b> @{{ formatDate(e_waktu_selesai) }}</span></div>
                        </div>
                        <br/>
                        <a v-if="e_id!=0 && e_is_secret==0" :href="pathname+'/'+e_id+'/detail'" class="float-right">Selengkapnya >></span>
                    </div>
                </div>
            </div>
        </div>
  </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/fullcalendar/fullcalendar.min.css') !!}">
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('assets/bundles/fullcalendarscripts.bundle.js') !!}"></script><!--/ calender javascripts --> 
    <script src="{!! asset('lucid/assets/vendor/fullcalendar/fullcalendar.js') !!}"></script><!--/ calender javascripts --> 

    
    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                datas: {!! json_encode($datas) !!},
                cur_date: {!! json_encode($cur_date) !!},
                e_id: 0, e_kab:'SUMSEL', e_judul: 'Pilih Meeting Pada Kalender', 
                e_waktu_mulai: '', e_waktu_selesai: '', e_peserta: 0,
                e_is_secret: 0,
                classNames: ['bg-primary', 'bg-info', 'bg-secondary','bg-success','bg-danger','bg-dark','bg-warning',],
            },
            computed: {
                pathname: function () {
                    return (window.location.pathname).replace("/kalender", "");
                },
                data_kalender: function(){
                    var temp_datas = [];
                    for(i=0;i<this.datas.length;++i){
                        temp_datas.push({
                            id: this.datas[i].id,
                            title: "["+this.datas[i].kdprop + this.datas[i].kdkab+"] ",
                            start: this.datas[i].waktu_mulai,
                            end: this.datas[i].waktu_selesai,
                            judul: this.datas[i].judul,
                            className: this.classNames[i%7],
                            peserta: this.datas[i].totalPeserta,
                            is_secret: this.datas[i].is_secret,
                        });
                    }

                    return temp_datas;
                },
            },
            methods: {
                formatDate: function(param1){
                    // var d = new Date(param1);
                    // return d.toString("D MMMM YYYY HH:mm"); 
                    return moment(param1).format("D MMMM YYYY HH:mm");
                },
                setDatas: function(){
                    var self = this;
                    console.log(self.datas);
                    $('#wait_progres').modal('show');

                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay,listWeek'
                        },
                        defaultDate: self.cur_date,
                        // editable: true,
                        // droppable: true, 
                        // drop: function() {
                        //     // is the "remove after drop" checkbox checked?
                        //     if ($('#drop-remove').is(':checked')) {
                        //         // if so, remove the element from the "Draggable Events" list
                        //         $(this).remove();
                        //     }
                        // },
                        eventClick: function(info) {
                            self.e_kab = info.title;
                            self.e_judul = info.judul;
                            self.e_waktu_mulai = info.start;
                            self.e_waktu_selesai = info.end;
                            self.e_id = info.id;
                            self.e_peserta = info.peserta;
                            self.e_is_secret = info.is_secret;
                        },
                        eventLimit: true, // allow "more" link when too many events
                        events: self.data_kalender,
                    });
                    
                    $('#wait_progres').modal('hide');
                },
            }
        });
        
        $(document).ready(function() {
            vm.setDatas();
        });
    </script>
@endsection
