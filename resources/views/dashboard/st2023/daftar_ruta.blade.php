@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
<div class="container" id="app_vue">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="body profilepage_2 blog-page pb-0">
                <b>Daftar Rumah Tangga</b>
                <div class="alert alert-info mt-1" role="alert">
                    Pindahkan SLS setiap rumah tangga dengan cara : <br>
                    1. Centang ruta yang ingin dipindahkan <br>
                    2. Klik tombol "Pindahkan SLS"<br>
                    3. Pilih tujuan kemana SLS tersebut akan dipindahkan dan klik "Submit"
                </div>
            </div>
            <div>
                <div class="row px-2">
                    <div class="col-2">
                        <label for="" class="label">Kab/Kot</label>
                        <select v-model="kab_filter" class="form-control" @change="select_kabs()">
                            <option value="">Semua</option>
                            @foreach ($kabs as $kab)
                                <option value="{{ $kab['id_kab'] }}">[{{ $kab['id_kab'] }}] {{ $kab['alias'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-3">
                        <label for="" class="label">Kec</label>
                        <select v-model="kec_filter" class="form-control" @change="select_kecs()">
                            <option value="">Semua</option>
                            <option v-for="(data, index) in list_kec" :key="data.id" :value="data.id_kec">
                                [ @{{ data.id_kec }} ] @{{ data.nama_kec }}
                            </option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="" class="label">Desa</label>
                        <select  v-model="desa_filter" class="form-control" @change="select_desas()">
                            <option value="">Semua</option>
                            <option v-for="(data, index) in list_desa" :key="data.id" :value="data.id_desa">
                                [ @{{ data.id_desa }} ] @{{ data.nama_desa }}
                            </option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="" class="label">ID SLS</label>
                        <select  v-model="sls_filter" class="form-control">
                            <option value="">Semua</option>

                            <option v-for="(data, index) in list_sls" :key="data.id" :value="data.id_sls">
                                [ @{{ data.id_sls + data.id_sub_sls}} ] @{{ data.nama_sls }}
                            </option>
                        </select>
                    </div>

                    <div class="col-1">
                        <label for="" class="label text-white">cari</label>
                        <button type="button"  @click="get_ruta()" class="btn btn-info">cari</button>
                    </div>
                </div>

                <div class="row px-2">
                    <div class="col-3">
                        <label for="" class="label text-white">Pindahkan SLS</label>      
                        <button class="btn btn-info mr-2" data-toggle="modal" data-target="#modal_pindah_sls">Pindahkan SLS</button>
                    </div>
                </div>
            </div>
            <br>

            <div class="m-1 table-responsive">
                <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
                    <thead>
                        <tr class="text-center">
                            <th>
                                Select All <br/><input type="checkbox" @click="selectAll" v-model="allSelected">
                            </th>
                            <th>No</th>
                            <th>Kab/Kota</th>
                            <th>Kec</th>
                            <th>Desa/Kelurahan</th>
                            <th>ID SLS</th>
                            <th>ID Sub SLS</th>
                            <th>Nu RT</th>
                            <th>Kepala Rumah Tangga</th>
                            <th>Jumlah UTP</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr v-for="(data, index) in data_rutas" :key="data.id" class="text-center">
                            <td>
                                <input type="checkbox" v-model="selectedItem" @click="select" :value="data.id">
                            </td>
                            <td>@{{ index+1 }}</td>
                            <td>@{{ data.kode_kab }}</td>
                            <td>@{{ data.kode_kec }}</td>
                            <td>@{{ data.kode_desa }}</td>
                            <td>@{{ data.id_sls }}</td>
                            <td>@{{ data.id_sub_sls }}</td>
                            <td>@{{ data.nurt }}</td>
                            <td class="text-left">@{{ data.kepala_ruta }}</td>
                            <td>@{{ data.jumlah_unit_usaha }}</td>
                        </tr>
                    </tbody>
                </table>
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

    <div class="modal" id="modal_pindah_sls" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b>Pilih SLS tujuan dipindahkan</b>
                </div>
                <div class="modal-body">

                    <div class="row clearfix">
                        <div class="col-md-6">
                            Kab/Kota:
                            <select v-model="kab_filter" disabled class="form-control">
                                <option value="">Semua</option>
                                @foreach ($kabs as $kab)
                                    <option value="{{ $kab['id_kab'] }}">[{{ $kab['id_kab'] }}] {{ $kab['alias'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            Kecamatan:
                            <select v-model="kec_filter_pindah" class="form-control" @change="select_kecs_pindah()">
                                <option value="">Semua</option>
                                <option v-for="(data, index) in list_kec" :key="data.id" :value="data.id_kec">
                                    [ @{{ data.id_kec }} ] @{{ data.nama_kec }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-6">
                            Desa/Kelurahan:
                            <select  v-model="desa_filter_pindah" class="form-control" @change="select_desa_pindah()">
                                <option value="">Semua</option>
                                <option v-for="(data, index) in list_desa_pindah" :key="data.id" :value="data.id_desa">
                                    [ @{{ data.id_desa }} ] @{{ data.nama_desa }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            SLS:
                            <select  v-model="sls_filter_pindah" class="form-control">
                                <option value="">Semua</option>
                                <option v-for="(data, index) in list_sls_pindah" :key="data.id" :value="data.id_sls+data.id_sub_sls">
                                    [ @{{ data.id_sls }} @{{ data.id_sub_sls }} ] @{{ data.nama_sls }}
                                </option>
                            </select>
                        </div>
                    </div>
                        
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="pindahkan">SAVE</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
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
        el: "#app_vue",
        data() {
            return {
                data_rutas: [],
                api_token: {!! json_encode($api_token) !!},
                base_url: {!! json_encode($base_url) !!},
                kab_filter: {!! json_encode($request->kab_filter) != 'null' ? json_encode($request->kab_filter) : '""' !!},
                kec_filter: {!! json_encode($request->kec_filter) != 'null' ? json_encode($request->kec_filter) : '""' !!},
                desa_filter: {!! json_encode($request->desa_filter) != 'null' ? json_encode($request->desa_filter) : '""' !!},
                sls_filter: {!! json_encode($request->sls_filter) != 'null' ? json_encode($request->sls_filter) : '""' !!},
                list_kec: [],list_desa: [],list_sls: [],

                kec_filter_pindah: '', desa_filter_pindah: '', sls_filter_pindah: '',
                list_desa_pindah: [], list_sls_pindah: [],

                selectedItem: [],
                allSelected: false,
            }
        }, 
        mounted() {
                const self = this;
                const auth = {!! json_encode($auth) !!}
                // this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const kab_value = {!! json_encode($request->kab_filter) !!}
                const kec_value = {!! json_encode($request->kec_filter) !!}
                const desa_value = {!! json_encode($request->desa_filter) !!}
                if (kab_value) {
                    this.set_kab(kab_value)
                        .then(function() {
                            self.select_kabs()
                        }).then(function() {
                            if (kec_value) {
                                self.set_kec(kec_value)
                            }
                        }).then(function() {
                            self.select_kecs()
                        }).then(function() {
                            if (desa_value) {
                                self.set_desa(desa_value)
                            }
                        }).catch(function(error) {
                            console.log(error);
                        });
                }

                fetch('https://st23.bpssumsel.com/api/getcsrf', {
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.csrf = data.csrf_token
                    })
                    .catch(error => {
                        console.log(error);
                    });

                self.get_ruta();
        },
        methods: {
            get_ruta(){
                $('#wait_progres').modal('show');

                var self = this
                const headers = {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.api_token
                };

                kode_wilayah = "16";
                self.selectedItem = [];
                if(self.kab_filter.length>0){
                    kode_wilayah += self.kab_filter;
                    if(self.kec_filter.length>0){
                        kode_wilayah += self.kec_filter;
                        if(self.desa_filter.length>0){
                            kode_wilayah += self.desa_filter;
                            if(self.sls_filter.length>0){
                                kode_wilayah += self.sls_filter;
                            }
                        }
                    }
                }

                $.ajaxSetup({
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.api_token
                    }
                })

                $.ajax({
                    url : self.base_url + 'ruta?kode_wilayah=' + kode_wilayah + "&per_page=1000",
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    self.data_rutas = data.data.data;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            select_kabs() {
                var self = this;
                $.ajax({
                    url : self.base_url + 'list_kecs?kab_filter=' + self.kab_filter,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    self.list_kec = data.data;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            select_kecs() {
                var self = this
                $.ajax({
                    url : self.base_url + 'list_desas?kab_filter=' + self.kab_filter +
                        '&kec_filter=' + self.kec_filter,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    self.list_desa = data.data;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            select_desas() {
                var self = this
                $.ajax({
                    url :self.base_url + 'list_sls?kab_filter=' + self.kab_filter +
                        '&kec_filter=' + self.kec_filter + '&desa_filter=' + self.desa_filter,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    self.list_sls = data.data;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            select_kecs_pindah() {
                var self = this
                $.ajax({
                    url : self.base_url + 'list_desas?kab_filter=' + self.kab_filter +
                        '&kec_filter=' + self.kec_filter_pindah,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    self.list_desa_pindah = data.data;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            select_desa_pindah() {
                var self = this
                $.ajax({
                    url : self.base_url + 'list_sls?kab_filter=' + self.kab_filter +
                        '&kec_filter=' + self.kec_filter_pindah + '&desa_filter=' + self.desa_filter_pindah,
                    method : 'get',
                    dataType: 'json',
                }).done(function (data) {
                    self.list_sls_pindah = data.data;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
            selectAll: function() {
                var self = this
                self.selectedItem = [];
                if (!self.allSelected) {
                    self.data_rutas.forEach(function(item){
                        self.selectedItem.push(item.id);
                    })
                }
            },
            select: function() {
                this.allSelected = false;
            }, 
            pindahkan(){
                var self = this
                if(self.selectedItem.length==0){
                    alert("Pilih minimal 1 RUTA yang ingin dipindahkan")
                }
                else{
                    let id_sls = self.sls_filter_pindah.substr(0,4);
                    let id_sub_sls = self.sls_filter_pindah.substr(4);

                    let mydata = {
                            kode_prov: '16', 
                            kode_kab: self.kab_filter, 
                            kode_kec: self.kec_filter_pindah, 
                            kode_desa: self.desa_filter_pindah, 
                            id_sls: id_sls, 
                            id_sub_sls: id_sub_sls,
                            selected_data: self.selectedItem
                        };

                    // console.log(mydata)
                    
                    $.ajax({
                        url : self.base_url + "ruta/update_sls_many",
                        "method": "POST",
                        "headers": {
                            "Authorization": "Bearer " + self.api_token,
                            "Content-Type": "application/json"
                        },
                        data: JSON.stringify(mydata),
                    }).done(function (data) {
                        console.log(data.data)
                        if(data.status=='success'){
                            alert("SUKSES! Ruta berhasil dipindahkan")
                            self.get_ruta();
                        }
                        else{
                            alert("ERROR! Ruta gagal dipindahkan " + data.data)
                        }

                        $('#modal_pindah_sls').modal('hide');
                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                }
            }
        }
    });
</script>

@endsection