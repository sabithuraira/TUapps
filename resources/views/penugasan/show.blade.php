@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('penugasan')}}">Penugasan</a></li>                            
    <li class="breadcrumb-item">Detail Data</li>
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
                    <label>Ditugaskan Oleh :</label>
                    <select disabled class="form-control form-control-sm" v-model="form.ditugaskan_oleh_fungsi">
                        @foreach($list_fungsi as $key=>$value)
                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                        @endforeach
                    </select>
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
                            <input type="text" disabled class="form-control form-control-sm" v-model="form.satuan" />
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

                <b>Daftar Participant</b>

                <div class="table-responsive">
                    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
                        <thead>
                            <tr class="text-center">
                                <td rowspan="2">No</td>
                                <td rowspan="2">Pegawai</td>
                                <td rowspan="2">Keterangan</td>
                                <td colspan="2">Jumlah</td>
                                <td rowspan="2">Progres <br/>Terakhir Pada</td>
                                <td rowspan="2">Skor</td>
                            </tr>
                            <tr class="text-center">
                                <td>Target</td>
                                <td>Realisasi</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(data, index) in participant" :key="data.user_nip_lama">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ data.user_nip_baru }} - @{{ data.user_nama }}</td>
                                <td class="text-center">@{{ data.keterangan }}</td>
                                <td class="text-center">@{{ data.jumlah_target }}</td>
                                <td class="text-center">@{{ data.jumlah_selesai }}</td>
                                <td class="text-center">@{{ data.tanggal_last_progress }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
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
                list_pegawai: {!! json_encode($list_pegawai) !!},
                id: {!! json_encode($id) !!},
            },
            computed: {
                pathname: function() {
                    return (window.location.pathname).replace("/"+this.id + "/show", "");
                },
            },
            methods: {
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

        $(document).ready(function() {
            vm.loadData();
        });
    </script>
@endsection
