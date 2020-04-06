<div id="app_vue">
    <ul class="nav nav-tabs-new2">
        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#data">Data</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#peserta">Peserta</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#notulen_materi">Notulen & Materi</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane show active" id="data">

            <div class="form-group">
                <label>{{ $model->attributes()['judul']}}:</label>
                <input type="text" class="form-control {{($errors->first('judul') ? ' parsley-error' : '')}}" name="judul" value="{{ old('judul', $model->judul) }}">
                @foreach ($errors->get('judul') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>  

            <div class="form-group">
                <label>{{ $model->attributes()['deskripsi']}}:</label>
                <textarea id="deskripsi" class="summernote form-control {{($errors->first('deskripsi') ? ' parsley-error' : '')}}" name="deskripsi" value="{{ old('deskripsi', $model->deskripsi) }}" rows="10"></textarea>
                @foreach ($errors->get('deskripsi') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>


            <div class="row clearfix">
                <div class="col-md-6">
                    <div class="form-group demo-masked-input">
                        <label>{{ $model->attributes()['waktu_mulai']}}:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control datetime {{($errors->first('waktu_mulai') ? ' parsley-error' : '')}}" name="waktu_mulai" value="{{ old('waktu_mulai', date('d-m-Y H:i', strtotime($model->waktu_mulai))) }}"  placeholder="Ex: 30-07-2019 23:59">
                        </div>
                        @foreach ($errors->get('waktu_mulai') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
                
                <div class="col-md-6 left">
                    <div class="form-group demo-masked-input">
                        <label>{{ $model->attributes()['waktu_selesai']}}:</label>
                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control datetime {{($errors->first('waktu_selesai') ? ' parsley-error' : '')}}" name="waktu_selesai" value="{{ old('waktu_selesai', date('d-m-Y H:i', strtotime($model->waktu_selesai))) }}"  placeholder="Ex: 30-07-2019 23:59">
                            <!-- <input type="text" class="form-control datetime" placeholder="Ex: 30/07/2016 23:59"> -->
                        </div>

                        @foreach ($errors->get('waktu_selesai') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="peserta">
            <label><span style="color: red; display:block; float:right">*</span>Peserta Meeting</label>
            &nbsp <a v-on:click="setDataPeserta">&nbsp &nbsp<i class="icon-plus text-info"></i></a>
                
            <table class="table table-sm m-b-0 table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, index) in rincian_peserta" :key="data.id">
                        <td>
                            <template v-if="is_delete(data.id)">
                                <a :data-id="data.id" v-on:click="delDataPeserta(data.id)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                            </template>
                            <template v-if="!is_delete(data.id)">
                                <a :data-id="data.id" v-on:click="delDataPesertaTemp(index)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                            </template>
                            @{{ index+1 }}
                        </td>

                        <td>@{{ data.name }}</td>
                        <td>@{{ data.nip_baru }}</td>
                        <td>@{{ data.nmjab }}</td>
                        <input type="hidden" :name="'p_email'+data.id" v-model="data.email">
                        <input type="hidden" :name="'p_nip_baru'+data.id" v-model="data.nip_baru">
                        <input type="hidden" :name="'p_name'+data.id" v-model="data.name">
                        <input type="hidden" :name="'p_nmjab'+data.id" v-model="data.nmjab">
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="notulen_materi">
            
            <div class="form-group">
                <label>{{ $model->attributes()['notulen']}}:</label>
                <textarea id="notulen" class="summernote form-control {{($errors->first('notulen') ? ' parsley-error' : '')}}" name="notulen" value="{{ old('notulen', $model->notulen) }}" rows="10"></textarea>
                @foreach ($errors->get('notulen') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>

            <div class="form-group">
                <label>{{ $model->attributes()['keterangan']}}:</label>
                <textarea id="keterangan" class="summernote form-control {{($errors->first('keterangan') ? ' parsley-error' : '')}}" name="keterangan" value="{{ old('keterangan', $model->keterangan) }}" rows="10"></textarea>
                @foreach ($errors->get('keterangan') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>
        
    <input type="hidden" name="total_peserta" v-model="total_peserta">

    <hr/>
    <button type="submit" class="btn btn-primary">Simpan</button>
    
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
    
    @include('meeting.modal_peserta')
</div>

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data:  {
                total_peserta: 1,
                id_induk: {!! json_encode($model->id) !!},
                list_peserta: [],
                rincian_peserta: [],
                keyword_peserta: '',
                kab_peserta:  {!! json_encode($kd_kab) !!},
            },
            computed: {
                pathname: function () {
                    if(this.id_induk)
                        return (window.location.pathname).replace("/"+this.id_induk+"/edit", "");
                    else
                        return (window.location.pathname).replace("/create", "");
                }
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
                        url : self.pathname+"/data_peserta",
                        method : 'post',
                        dataType: 'json',
                        data:{
                            idnya: self.id_induk,
                        },
                    }).done(function (data) {
                        self.rincian_peserta = data.datas;
                        // var selisih = self.total_peserta - self.rincian.length;

                        // for(i=1;i<=selisih;++i){
                        //     self.rincian_peserta.push({
                        //         'id': 'au'+(i),
                        //     });
                        // }

                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
            
                pilihPeserta: function(event){
                    var self = this;
                    if (event) {
                        let index_data = parseInt(event.currentTarget.getAttribute('data-index'));
                        let cur_peserta =  self.list_peserta[index_data];

                        self.total_peserta++;
                        self.rincian_peserta.push({
                            'id': 'au'+(self.total_peserta),
                            'email': cur_peserta.email,
                            'nip_baru': cur_peserta.nip_baru,
                            'name': cur_peserta.name,
                            'nmjab': cur_peserta.nmjab,
                        });
                        
                        $('#select_peserta').modal('hide');
                    }
                },
                setDataPeserta: function(){
                    var self = this;
                    $('#select_peserta').modal('hide');
                    $('#wait_progres').modal('show');
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })

                    $.ajax({
                        url : self.pathname + "/load_pegawai",
                        method : 'post',
                        dataType: 'json',
                        crossDomain: true,
                        data:{
                            keyword: self.keyword_peserta,
                            kd_kab: self.kab_peserta,
                        },
                    }).done(function (data) {
                        self.list_peserta = data.datas;
                        $('#wait_progres').modal('hide');
                        $('#select_peserta').modal('show');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },

                delDataPeserta: function (idnya) {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajax({
                        url : self.pathname+"/" + idnya + "/destroy_peserta/",
                        method : 'get',
                        dataType: 'json',
                    }).done(function (data) {
                        window.location.reload(true);
                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
            
                delDataPesertaTemp: function (index) {
                    var self = this;
                    $('#wait_progres').modal('show');
                    self.rincian_peserta.splice(index, 1);
                    $('#wait_progres').modal('hide');
                },
            
                is_delete: function(params){
                    if(isNaN(params)) return false;
                    else return true;
                },
                addData: function (event) {
                    var self = this;
                    if (event) {
                        self.total_peserta++;
                        self.rincian.push({
                            'id': 'au'+(self.total_peserta),
                        });
                    }
                },
            }
        });

        $(document).ready(function() {
            vm.setDatas();
        });

        $(function() {
                var initDeskripsi = {!! json_encode(old('deskripsi', $model->deskripsi)) !!};
                $('#deskripsi').summernote('code', initDeskripsi);
                
                var initNotulen = {!! json_encode(old('notulen', $model->notulen)) !!};
                $('#notulen').summernote('code', initNotulen);
                
                var initKeterangan = {!! json_encode(old('keterangan', $model->keterangan)) !!};
                $('#keterangan').summernote('code', initKeterangan);
                
            });

            $(document).ready(function() {
                var $demoMaskedInput = $('.demo-masked-input');
                $demoMaskedInput.find('.datetime').inputmask('d-m-y h:s', { placeholder: '__-__-____ __:__', alias: "datetime", hourFormat: '24' });
            });
    </script>
@endsection