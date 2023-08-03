@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">

    <style>
        .c3-axis-x text {
            font-size: 10px;
        }
    </style>
    <div class="container" id="app_vue">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body profilepage_2 blog-page pb-0 text-center">
                    <h3>Daftar Petugas Melakukan Pendataan Titik Awal dan Akhir Pencacahan Berbeda Jauh</h3>
                    <div class="alert alert-info mt-1 text-left" role="alert">
                        Jarak Maksimal Kewajarn Titik Awal dan Akhir Pencacahan adalah 1000meter atau 1 km
                    </div>
                </div>
                <br>
                <div>
                    <form action="">
                        <div class="row px-2">
                            <div class="col-3">
                                <label for="" class="label">Kab/Kot</label>
                                <select name="kab_filter" id="kab_filter" class="form-control" @change="select_kabs()">
                                    <option value="">Semua</option>
                                    @foreach ($kabs as $kab)
                                        <option value="{{ $kab['id_kab'] }}">[{{ $kab['id_kab'] }}] {{ $kab['alias'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="" class="label">Kec</label>
                                <select name="kec_filter" id="kec_filter" class="form-control" @change="select_kecs()">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="" class="label">Desa</label>
                                <select name="desa_filter" id="desa_filter" class="form-control">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                            <div class="col-1 ">
                                <label for="" class="label text-white">cari</label>
                                <button type="submit" class="btn btn-info">cari</button>
                            </div>
                            <div class="col-1 ">
                                <label for="" class="label text-white">export</label>
                                <button type="button" class="btn btn-info" @click="export_dash_lokasi()">export</button>
                            </div>

                        </div>
                        <div class="row px-2">
                            <div class="col-lg-6 col-md-6 left-box">
                                <label>Tampilkan Tanggal:</label>
                                <div class="input-daterange input-group" data-provide="datepicker">
                                    <input type="text" class="input-sm form-control" v-model="start" id="start"
                                        name="tanggal_awal" autocomplete="off">
                                    <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                                    <input type="text" class="input-sm form-control" v-model="end" id="end"
                                        name="tanggal_akhir" autocomplete="off">
                                </div>

                            </div>


                        </div>
                    </form>
                </div>
                <br>
                <div class="m-1">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kab</th>
                                <th>PCL</th>
                                <th>Jarak(Km)</th>
                                {{-- <th>Rata Selisih Latitue</th>
                                <th>Rata Selisih Longitude</th> --}}
                                <th>Jumlah Ruta</th>
                            </tr>
                        </thead>
                        @if ($data)
                            <tbody class="text-center">
                                @foreach ($data as $i => $dt)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $dt['kode_kab'] }}</td>
                                        <td class="text-left">
                                            <a href="{{ url('dashboard/petugas_sls/' . $dt['email']) }}">
                                                {{ $dt['name'] }}
                                            </a>
                                        </td>

                                        @if ($dt['rutas'])
                                            <td @if (abs($dt['rutas'][0]['rata_latitude']) > 0.01) class="bg-danger text-white" @endif>
                                                {{ round(abs($dt['rutas'][0]['rata_latitude']) * 1000, 2) }} Km
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        {{-- @if ($dt['rutas'])
                                            <td @if (abs($dt['rutas'][0]['rata_latitude']) > 0.01) class="bg-danger text-white" @endif>
                                                {{ $dt['rutas'][0]['rata_latitude'] }}
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        @if ($dt['rutas'])
                                            <td @if (abs($dt['rutas'][0]['rata_longitude']) > 0.01) class="bg-danger text-white" @endif>
                                                {{ $dt['rutas'][0]['rata_longitude'] }}
                                            </td>
                                        @else
                                            <td></td>
                                        @endif --}}
                                        <td>
                                            @if ($dt['rutas'])
                                                {{ $dt['rutas'][0]['jml_ruta'] }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="6">Belum ada Data</td>
                                </tr>

                            </tbody>
                        @endif
                    </table>
                    <ul class="pagination pagination-primary">
                        @foreach ($links as $lk)
                            <li class="page-item @if ($lk['active']) active @endif">
                                <a class="page-link" href="{{ $lk['url'] }}"> {!! $lk['label'] !!}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {
                datas: [],
                api_token: {!! json_encode($api_token) !!},
                start: {!! json_encode($tanggal_awal) !!},
                end: {!! json_encode($tanggal_akhir) !!},
            },
            mounted() {
                const self = this;
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
            },
            methods: {
                select_kabs() {
                    return new Promise((resolve, reject) => {
                        const kab_filter = document.getElementById('kab_filter').value;
                        var request = new XMLHttpRequest();
                        request.open('GET', 'https://st23.bpssumsel.com/api/list_kecs?kab_filter=' +
                            kab_filter,
                            false
                        ); // Set argumen ketiga menjadi false untuk menjalankan permintaan secara sinkron
                        request.send();
                        if (request.status === 200) {
                            var data = JSON.parse(request.responseText);
                            const kec_select = document.getElementById('kec_filter');
                            kec_select.innerHTML = "";
                            var option = document.createElement('option');
                            option.value = "";
                            option.textContent = "Semua";
                            kec_select.appendChild(option);
                            data.data.forEach(element => {
                                var option = document.createElement('option');
                                option.value = element.id_kec;
                                // option.textContent = element.nama_kec;
                                option.textContent = '[' + element.id_kec + '] ' + element.nama_kec;
                                kec_select.appendChild(option);
                            });
                        } else {
                            console.error('Error:', request.status);
                        }
                        resolve();
                    })
                },
                select_kecs() {
                    return new Promise((resolve, reject) => {
                        const kec_filter = document.getElementById('kec_filter').value;
                        const kab_filter = document.getElementById('kab_filter').value;
                        var request = new XMLHttpRequest();
                        request.open('GET', 'https://st23.bpssumsel.com/api/list_desas?kab_filter=' +
                            kab_filter +
                            '&kec_filter=' + kec_filter,
                            false
                        ); // Set argumen ketiga menjadi false untuk menjalankan permintaan secara sinkron
                        request.send();
                        if (request.status === 200) {
                            var data = JSON.parse(request.responseText);
                            const desa_select = document.getElementById('desa_filter');
                            desa_select.innerHTML = "";
                            var option = document.createElement('option');
                            option.value = "";
                            option.textContent = "Semua";
                            desa_select.appendChild(option);
                            data.data.forEach(element => {
                                var option = document.createElement('option');
                                option.value = element.id_desa;
                                option.textContent = '[' + element.id_desa + '] ' + element
                                    .nama_desa;
                                desa_select.appendChild(option);
                            });
                        } else {
                            console.error('Error:', request.status);
                        }
                        resolve();
                    })
                },
                set_kab(kab_value) {
                    return new Promise((resolve, reject) => {
                        const kab_select = document.getElementById('kab_filter');
                        kab_select.value = kab_value
                        resolve();
                    });

                },
                set_kec(kec_value) {
                    return new Promise((resolve, reject) => {
                        const kec_select = document.getElementById('kec_filter');
                        kec_select.value = kec_value
                        resolve();
                    });
                },
                set_desa(desa_value) {
                    return new Promise((resolve, reject) => {
                        const desa_select = document.getElementById('desa_filter');
                        desa_select.value = desa_value
                        resolve();
                    });
                },
                export_dash_lokasi(event) {
                    var self = this;
                    const headers = {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.api_token
                    };
                    console.log(self.start);
                    const kab_filter = document.getElementById('kab_filter').value;
                    const kec_filter = document.getElementById('kec_filter').value;
                    const desa_filter = document.getElementById('desa_filter').value;
                    filter = "?kode_kab=" + kab_filter + "&kode_kec=" + kec_filter + "&kode_desa=" + desa_filter +
                        "&tanggal_awal=" + self.start + "&tanggal_akhir=" + self.end
                    console.log(filter)
                    fetch('https://st23.bpssumsel.com/api/export_dashboard_lokasi' + filter, {
                            method: 'GET',
                            headers: headers,
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            var url = window.URL.createObjectURL(blob);
                            // Buat elemen <a> untuk mengunduh file
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = "lokasi_16" + kab_filter + kec_filter + desa_filter + ".xlsx";
                            // Klik elemen <a> secara otomatis
                            a.target = "_blank";
                            a.click();
                            // Hapus elemen <a> setelah selesai
                            window.URL.revokeObjectURL(url);
                            a.remove();
                        })
                        .catch(error => {
                            console.log(error)
                        });
                },
                setDatas: function() {
                    var self = this;
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: self.pathname + "/data_log_book",
                        method: 'post',
                        dataType: 'json',
                        data: {
                            start: self.start,
                            end: self.end,
                        },
                    }).done(function(data) {
                        self.datas = data.datas;
                        $('#wait_progres').modal('hide');
                    }).fail(function(msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });
                },
            }

        });
        $(document).ready(function() {
            $('.time24').inputmask('hh:mm', {
                placeholder: '__:__',
                alias: 'time24',
                hourFormat: '24'
            });


            $('.datepicker').datepicker({
                format: 'm/d/Y',
                endDate: 'd',
            });

        });

        $('#start').change(function() {
            vm.start = this.value;
            vm.setDatas();
        });

        $('#end').change(function() {
            vm.end = this.value;
            vm.setDatas();
        });
    </script>
@endsection
