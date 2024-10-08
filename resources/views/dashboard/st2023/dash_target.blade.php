@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    <style>
        .c3-axis-x text {
            font-size: 10px;
        }

        .CodeMirror {
            display: none;
        }
    </style>
    <div class="container" id="app_vue">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body profilepage_2 blog-page pb-0 text-center">
                    <h3>Dashboard by PPL</h3>
                    <div class="alert alert-info mt-1 text-left" role="alert">
                        Target Ruta Selesai Hari ini adalah {{ $target_hari_ini }} Ruta Tani
                    </div>
                </div>
                <br>
                <div>
                    <form action="">
                        <div class="row px-2">
                            <div class="col-3">
                                <label for="" class="label">Kab/Kot</label>
                                <select name="kab_filter" id="kab_filter" class="form-control" @change="select_kabs()">
                                    <option value="">Pilih Satu</option>
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
                                <button type="button" class="btn btn-info" @click="export_dash_target()">export</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <div class="m-1 table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kab</th>
                                <th>PCL</th>
                                <th>Jumlah SLS</th>
                                <th>Jumlah Prelist Ruta </th>
                                {{-- <th>Jumlah Prelist Ruta Pertanian</th> --}}
                                <th>Ruta Dicacah</th>
                                <th>Persentase Pencacahan / Prelist</th>
                            </tr>
                        </thead>
                        @if ($data)
                            @foreach ($data as $index => $dt)
                                <tbody>
                                    <tr class="text-center">
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $dt['kode_kab'] }}</td>
                                        <td class="text-left">
                                            {{ $dt['name'] }} <span class="text-secondary">({{ $dt['email'] }})</span>
                                        </td>
                                        <td>
                                            {{ $dt['jml_sls'] }}
                                        </td>
                                        <td>
                                            {{ $dt['prelist_ruta'] }}
                                        </td>
                                        {{-- <td>
                                            {{ $dt['prelist_ruta_tani'] }}
                                        </td> --}}
                                        <td>
                                            <span class="badge badge">
                                                {{ $dt['rutas_count'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($dt['prelist_ruta'] > 0)
                                                <span
                                                    @if ($dt['rutas_count'] < $dt['prelist_ruta']) class="badge badge-danger"
                                                    @else
                                                    class="badge badge-success" @endif>
                                                    {{ round(($dt['rutas_count'] / $dt['prelist_ruta']) * 100, 2) }} %
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    100%
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="7">Belum ada Data/Belum Pilih Kab</td>
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

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data() {
                return {
                    api_token: {!! json_encode($api_token) !!},
                    kab_filter: {!! json_encode($request->kab_filter) != 'null' ? json_encode($request->kab_filter) : '""' !!},
                    kec_filter: {!! json_encode($request->kec_filter) != 'null' ? json_encode($request->kec_filter) : '""' !!},
                    desa_filter: {!! json_encode($request->desa_filter) != 'null' ? json_encode($request->desa_filter) : '""' !!},
                    sls_filter: {!! json_encode($request->sls_filter) != 'null' ? json_encode($request->sls_filter) : '""' !!},
                }
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
                export_dash_target(event) {
                    var self = this
                    const headers = {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.api_token
                    };

                    filter = "?kab_filter=" + self.kab_filter +
                        "&kec_filter=" + self.kec_filter +
                        "&desa_filter=" + self.desa_filter
                    fetch('https://st23.bpssumsel.com/api/export_target' + filter, {
                            method: 'GET',
                            headers: headers,
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = "target_16" + self.kab_filter + self.kec_filter + self.desa_filter +
                                self.sls_filter + ".xlsx";
                            document.body.appendChild(
                                a
                            ); // we need to append the element to the dom -> otherwise it will not work in firefox
                            a.click();
                            a.remove(); //afterwards we remove the element again
                        })
                        .catch(error => {
                            console.log(error)
                        });
                },
            }

        });
    </script>
@endsection
