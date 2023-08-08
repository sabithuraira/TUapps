<style>
    .c3-axis-x text {
        font-size: 10px;
    }
</style>

<div class="card" id="data-container">
    <div class="body profilepage_2 blog-page">
        <b>MONITORING PES ST 2023 :</b>
        <u><a href="{{ url('dashboard/index') }}">SUMATERA SELATAN</a></u>
        @if ($request->kab_filter)
            -<u>
                <a href="{{ url('dashboard/index?kab_filter=' . $request->kab_filter) }}">
                    {{ $label_kab }}
                </a>
            </u>
        @endif
        @if ($request->kec_filter)
            -<u><a
                    href="{{ url('dashboard/index?kab_filter=' . $request->kab_filter . '&kec_filter=' . $request->kec_filter) }}">
                    {{ $label_kec }}
                </a>
            </u>
        @endif
        @if ($request->desa_filter)
            -<u><a
                    href="{{ url('dashboard/index?kab_filter=' . $request->kab_filter . '&kec_filter=' . $request->kec_filter . '&desa_filter=' . $request->desa_filter) }}">
                    {{ $label_desa }}
                </a>
            </u>
        @endif
        @if ($request->sls_filter)
            -<u><a
                    href="{{ url(
                        'dashboard/index?kab_filter=' .
                            $request->kab_filter .
                            '&kec_filter=' .
                            $request->kec_filter .
                            '&desa_filter=' .
                            $request->desa_filter .
                            '&sls_filter=' .
                            $request->sls_filter,
                    ) }}">
                    {{ $label_sls }}
                </a>
            </u>
        @endif
    </div>
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
                <div class="col-1 ">
                    <label for="" class="label text-white">cari</label>
                    <button type="submit" class="btn btn-info">cari</button>
                </div>
                <div class="col-2">
                    <label for="" class="label text-white">export</label>
                    <button type="button" class="btn btn-info mr-2" @click="excel_pes()">Export
                        PES</button>
                </div>
            </div>
        </form>
    </div>
    <div class="m-1">
        <div class="tab-content">
            <div class="tab-pane show active" id="st_wilayah">
                <h6>Menunjukkan Progress Per SLS</h6>

                <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode Wilayah</th>
                            <th>Nama SLS</th>
                            <th>Jumlah Ruta</th>
                            <th>Jumlah ART</th>
                            <th>RUTA PES</th>
                            <th>ART PES</th>
                            <th>Status Selesai</th>
                        </tr>
                    </thead>
                    @if (sizeof($data) > 0)
                        <tbody>
                            @foreach ($data as $index => $dt)
                                <tr class="text-center">
                                    <td>
                                        {{ ++$index }}
                                    </td>
                                    <td class="text-left">
                                        {{ $dt['kode_prov'] . $dt['kode_kab'] . $dt['kode_kec'] . $dt['kode_desa'] . $dt['id_sls'] . $dt['id_sub_sls'] }}
                                    </td>
                                    <td class="text-left">
                                        {{ $dt['nama_sls'] }}
                                    </td>
                                    <td>
                                        {{ $dt['jml_ruta_tani'] }}
                                    </td>
                                    <td>
                                        {{ $dt['jml_art_tani'] }}
                                    </td>
                                    <td>
                                        {{ $dt['jml_ruta_pes'] }}
                                        @if ($dt['jml_ruta_tani'] > 0)
                                            {{ '( ' . round(($dt['jml_ruta_pes'] / $dt['jml_ruta_tani']) * 100) . ' % )' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $dt['jml_art_pes'] }}
                                        @if ($dt['jml_art_tani'] > 0)
                                            {{ '( ' . round(($dt['jml_art_pes'] / $dt['jml_art_tani']) * 100) . ' % )' }}
                                        @else
                                            (&nbsp;%)
                                        @endif
                                    </td>
                                    <td>
                                        @if ($dt['status_selesai'] == 1)
                                            <span class="badge badge-success">100</span>
                                        @else
                                            <span class="badge badge-warning">0</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    @endif
                </table>
                <br>
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



@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
    <script>
        var vm = new Vue({
            el: "#data-container",
            data() {
                return {
                    api_token: {!! json_encode($api_token) !!},
                    kab_filter: {!! json_encode($request->kab_filter) != 'null' ? json_encode($request->kab_filter) : '""' !!},
                    kec_filter: {!! json_encode($request->kec_filter) != 'null' ? json_encode($request->kec_filter) : '""' !!},
                    desa_filter: {!! json_encode($request->desa_filter) != 'null' ? json_encode($request->desa_filter) : '""' !!},
                    sls_filter: {!! json_encode($request->sls_filter) != 'null' ? json_encode($request->sls_filter) : '""' !!},
                    total_sipmen: {},
                    list_kab: [
                        '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '71',
                        '72', '73', '74'
                    ],
                }
            },
            mounted() {
                const self = this;
                const auth = {!! json_encode($auth) !!}
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
                excel_pes(event) {
                    var self = this
                    const headers = {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.api_token
                    };
                    filter = "?kab_filter=" + self.kab_filter +
                        "&kec_filter=" + self.kec_filter +
                        "&desa_filter=" + self.desa_filter +
                        "&sls_filter=" + self.sls_filter
                    fetch('https://st23.bpssumsel.com/api/export_pes' + filter, {
                            method: 'GET',
                            headers: headers,
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = "pes_16" + self.kab_filter + self.kec_filter + self.desa_filter +
                                self.sls_filter + ".xlsx";
                            document.body.appendChild(
                                a
                            );
                            a.click();
                            a.remove();
                        })
                        .catch(error => {
                            console.log(error)
                        });
                },
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
            }
        })
    </script>
@endsection
