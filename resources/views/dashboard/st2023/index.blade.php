<style>
    .c3-axis-x text {
        font-size: 10px;
    }
</style>

<div class="card" id="data-container">
    <div class="body profilepage_2 blog-page">
        <b>MONITORING ST 2023 :</b>
        <u><a href="{{ url('dashboard/st2023') }}">SUMATERA SELATAN</a></u>
        @if ($request->kab_filter)
            -<u>
                <a href="{{ url('dashboard/st2023?kab_filter=' . $request->kab_filter) }}">
                    {{ $label_kab }}
                </a>
            </u>
        @endif
        @if ($request->kec_filter)
            -<u><a
                    href="{{ url('dashboard/st2023?kab_filter=' . $request->kab_filter . '&kec_filter=' . $request->kec_filter) }}">
                    {{ $label_kec }}
                </a>
            </u>
        @endif
        @if ($request->desa_filter)
            -<u><a
                    href="{{ url('dashboard/st2023?kab_filter=' . $request->kab_filter . '&kec_filter=' . $request->kec_filter . '&desa_filter=' . $request->desa_filter) }}">
                    {{ $label_desa }}
                </a>
            </u>
        @endif
        @if ($request->sls_filter)
            -<u><a
                    href="{{ url(
                        'dashboard/st2023?kab_filter=' .
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
        {{-- <br> --}}
        {{-- <div class=" d-flex flex-row-reverse">
            <a class="btn btn-info" href="{{ url('dashboard/petugas') }}">Halaman Petugas</a>
        </div> --}}
    </div>
    {{-- <br> --}}
    <div class="m-1">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#st_wilayah">Wilayah</a>
            </li>
            {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#st_kk">KK</a></li> --}}
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#st_dokumen">Dokumen</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="st_wilayah">
                <h6>Menunjukkan progress sls yang selesai dan filter wilayah</h6>
                @include('dashboard.st2023.wilayah')
            </div>
            {{-- <div class="tab-pane  " id="st_kk">
                <h6>Menunjukkan perbandingan data art yang berusaha di sektor pertanian antara st2023 lapangan
                    dengan regsosek2022</h6>
                @include('dashboard.st2023.kk')
            </div> --}}
            <div class="tab-pane  " id="st_dokumen">
                <h6>Menunjukkan progress/alur dokumen telah sampai dimana </h6>
                @include('dashboard.st2023.dokumen')
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
                this.getSipmenData();
            },
            methods: {
                excel_dokumen(event) {
                    var self = this
                    const headers = {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.api_token
                    };
                    filter = "?kab_filter=" + self.kab_filter +
                        "&kec_filter=" + self.kec_filter +
                        "&desa_filter=" + self.desa_filter +
                        "&sls_filter=" + self.sls_filter
                    fetch('https://st23.bpssumsel.com/api/export_dokumen' + filter, {
                            method: 'GET',
                            headers: headers,
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = "dokumen_16" + self.kab_filter + self.kec_filter + self.desa_filter +
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
                getSipmenData() {
                    var self = this;

                    for (let i = 0; i < self.list_kab.length; ++i) {
                        let currKab = self.list_kab[i];
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        })

                        $.ajax({
                            url: 'https://sipmen.bps.go.id/st2023/apigetdataterima?clientid=16&token=4A6C252C118BB7C69D8EA2A3022429&kd_kab=' +
                                currKab,
                            method: 'get',
                            dataType: 'json',
                        }).done(function(data) {
                            $('#wait_progress').modal('hide');
                            let total = data.data
                                .filter(item => item.kd_dokumen == "ST2023.L2-UTP")
                                .reduce((sum, x) => {
                                    if (typeof x === 'object') {
                                        if ('jml_terima' in x) sum += parseInt(x.jml_terima)
                                    }
                                    return sum;
                                }, 0)
                            const element = document.getElementById("sipmen" + currKab);
                            element.innerHTML = total;

                            let totalTerpakai = data.data
                                .filter(item => item.kd_dokumen == "ST2023.L2-UTP")
                                .reduce((sum, x) => {
                                    if (typeof x === 'object') {
                                        if ('jml_terpakai' in x) sum += parseInt(x.jml_terpakai)
                                    }
                                    return sum;
                                }, 0)
                            const elementTerpakai = document.getElementById("sipmen_terpakai" + currKab);
                            elementTerpakai.innerHTML = totalTerpakai;

                            let totalRusak = data.data
                                .filter(item => item.kd_dokumen == "ST2023.L2-UTP")
                                .reduce((sum, x) => {
                                    if (typeof x === 'object') {
                                        if ('jml_kosong' in x || 'jml_rusak' in x) sum += (parseInt(x.jml_kosong) + parseInt(x.jml_rusak))
                                    }
                                    return sum;
                                }, 0)
                            const elementRusak = document.getElementById("sipmen_rusak" + currKab);
                            elementRusak.innerHTML = totalRusak;
                        }).fail(function(msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progres').modal('hide');
                        });

                    }
                },
                excel_ruta(event) {
                    // console.log("masuk sini")
                    // let timerInterval
                    // Swal.fire({
                    //     title: 'Loading',
                    //     timerProgressBar: true,
                    //     didOpen: () => {
                    //         Swal.showLoading()

                    //     },
                    // }).then((result) => {
                    //     /* Read more about handling dismissals below */

                    // })

                    // var self = this
                    // const headers = {
                    //     'Content-Type': 'application/json',
                    //     'Authorization': 'Bearer ' + this.api_token
                    // };
                    // filter = "?kode_kab=" + self.kab_filter +
                    //     "&kode_kec=" + self.kec_filter +
                    //     "&kode_desa=" + self.desa_filter +
                    //     "&id_sls=" + self.sls_filter
                    // fetch('https://st23.bpssumsel.com/api/export_ruta' + filter, {
                    //         method: 'GET',
                    //         headers: headers,
                    //     })
                    //     .then(response => response.blob())
                    //     .then(blob => {

                    //         console.log("masuk result")
                    //         var url = window.URL.createObjectURL(blob);
                    //         var a = document.createElement('a');
                    //         a.href = url;
                    //         a.download = "ruta_16" + self.kab_filter + self.kec_filter + self.desa_filter + self
                    //             .sls_filter +
                    //             ".csv";
                    //         document.body.appendChild(
                    //             a
                    //         );
                    //         a.click();
                    //         a.remove();
                    //         swal.close();
                    //     })
                    //     .catch(error => {
                    //         console.log(error)
                    //         swal.close()
                    //     });
                    var self = this
                    filter = "?kode_kab=" + self.kab_filter +
                        "&kode_kec=" + self.kec_filter +
                        "&kode_desa=" + self.desa_filter +
                        "&id_sls=" + self.sls_filter
                    var url = 'https://st23.bpssumsel.com/api/export_ruta' + filter;

                    window.open(url, "_blank");
                },
                excel_progress(event) {
                    var self = this
                    const headers = {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.api_token
                    };
                    filter = "?kab_filter=" + self.kab_filter +
                        "&kec_filter=" + self.kec_filter +
                        "&desa_filter=" + self.desa_filter +
                        "&sls_filter=" + self.sls_filter
                    fetch('https://st23.bpssumsel.com/api/export_progress' + filter, {
                            method: 'GET',
                            headers: headers,
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = "progress_16" + self.kab_filter + self.kec_filter + self.desa_filter +
                                self
                                .sls_filter +
                                ".xlsx";
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
            }

        });
    </script>
@endsection
