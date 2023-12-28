@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('penugasan')}}">Penugasan</a></li>                            
    <li class="breadcrumb-item">Progres Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="body">
            <div id="app_vue">
                <div class="form-group">
                    <label>Judul:</label>
                    <input type="text" disabled class="form-control form-control-sm" v-model="form.isi" />
                </div>

                <div class="form-group">
                    <label>Keterangan:</label>
                    <textarea disabled class="form-control form-control-sm" rows="5" v-model="form.keterangan"></textarea>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="text" disabled class="form-control form-control-sm" v-model="form.tanggal_mulai">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="text" disabled class="form-control form-control-sm" v-model="form.tanggal_selesai">
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Satuan:</label>
                            <input disabled type="text" class="form-control form-control-sm" v-model="form.satuan" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Periode:</label>
                            <select disabled class="form-control form-control-sm" v-model="form.jenis_periode">
                                @foreach ($model->listJenisPeriode as $key=>$value)
                                    <option  value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @include('penugasan.rincian_progres_participant')
                @include('penugasan.modal_form_progres')
                <br/>
                <button type="button" @click="saveData()" class="btn btn-primary">Simpan</button>

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
  </div>
</div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/multi-select/css/multi-select.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/multi-select/js/jquery.multi-select.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                participant_old: [],
                participant: [],
                form: {
                    isi: '',
                    keterangan: '',
                    tanggal_mulai: '',
                    tanggal_selesai: '',
                    satuan: '',
                    jenis_periode: '',
                    unit_kerja: '',
                },
                detail_participant: {
                    penugasan_id: '',
                    user_id: '',
                    user_nip_lama: '',
                    user_nip_baru: '',
                    user_nama: '',
                    user_jabatan: '',
                    jumlah_target: '',
                    jumlah_selesai: '',
                    unit_kerja: '',
                    nilai_waktu: '',
                    nilai_penyelesaian: '',
                    tanggal_last_progress: '',
                    id: '',
                    index: ''
                },
                list_pegawai: {!! json_encode($list_pegawai) !!},
                id: {!! json_encode($id) !!},
            },
            computed: {
                pathname: function() {
                    return (window.location.pathname).replace("/"+this.id+"/progres", "");
                },
            },
            methods: {
                saveData: function(){
                    var self = this;

                    $('#wait_progres').modal('show');
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                    
                    var rincian = { participant: self.participant }
                    data_post = { ...rincian }

                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
                    $.ajax({
                        url :  self.pathname + "/" + self.id +"/store_progres",
                        method : 'post',
                        dataType: 'json',
                        data: data_post,
                    }).done(function (data) {
                        $('#wait_progres').modal('hide');
                        // console.log(data)
                        window.location.href = self.pathname
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                        window.location.href = self.pathname
                    });
                },
                updateProgres: function (event) {
                    var self = this;
                    if (event) {
                    console.log(event.currentTarget.getAttribute('data-user_nama'))
                        self.detail_participant.id = event.currentTarget.getAttribute('data-id');
                        self.detail_participant.tanggal_last_progress = event.currentTarget.getAttribute('data-tanggal_last_progress');
                        $('#tanggal_last_progress').val(self.detail_participant.tanggal_last_progress);

                        self.detail_participant.user_nama = event.currentTarget.getAttribute('data-user_nama');
                        self.detail_participant.keterangan = event.currentTarget.getAttribute('data-keterangan');
                        self.detail_participant.jumlah_target = event.currentTarget.getAttribute('data-jumlah_target');
                        self.detail_participant.jumlah_selesai = event.currentTarget.getAttribute('data-jumlah_selesai');
                    }
                },
                saveProgres: function(){
                    var index_data = this.participant.findIndex(x => x.id == this.detail_participant.id);
                    if(index_data!=-1){
                        this.participant[index_data].jumlah_selesai = this.detail_participant.jumlah_selesai;
                        this.participant[index_data].tanggal_last_progress = this.detail_participant.tanggal_last_progress;
                    }

                    this.detail_participant = {
                        penugasan_id: '',
                        user_id: '',
                        user_nip_lama: '',
                        user_nip_baru: '',
                        user_nama: '',
                        user_jabatan: '',
                        jumlah_target: '',
                        jumlah_selesai: '',
                        unit_kerja: '',
                        nilai_waktu: '',
                        nilai_penyelesaian: '',
                        tanggal_last_progress: '',
                        id: '',
                        index: ''
                    };
                    
                    $('#add_progres').modal('hide');
                },
                loadData: function(){
                    var self = this;
                    $('#wait_progres').modal('show');

                    $.ajax({
                        url :  self.pathname + "/" + self.id + "/detail",
                        method : 'get',
                        dataType: 'json',
                    }).done(function (data) {
                        $('#wait_progres').modal('hide');

                        if(data.form!=null){
                            self.form = data.form;

                            $('#tanggal_mulai').val(self.form.tanggal_mulai);
                            $('#tanggal_selesai').val(self.form.tanggal_selesai);

                            self.participant = data.participant;

                            self.participant_old = [];
                            for(var i=0;i<self.participant.length;i++){
                                self.participant_old.push(self.participant[i].user_nip_lama);
                            }

                            $("#participant_select").multiSelect('select', self.participant_old);
                        }
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                    
                },
            }
        });

        $('#tanggal_last_progress').change(function() {
            vm.detail_participant.tanggal_last_progress = this.value;
        });

        $(document).ready(function() {
            $('.datepicker').datepicker({
                // startDate: 'd',
                format: 'yyyy-mm-dd',
            });

            if(vm.id!=''){
                vm.loadData();
            }
        });
    </script>
@endsection