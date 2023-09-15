<style>
    .c3-axis-x text {
        font-size: 10px;
    }
</style>

<div class="card" id="data-container">
    <div class="body profilepage_2 blog-page">
        <b>MONITORING PL-KUMKM 2023:</b>
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
    </div>
    {{-- <br> --}}
    <div class="m-1">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#umkm_table">Wilayah</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="umkm_table">
                <h6>Menunjukkan progress pencacahan berdasarkan filter wilayah</h6>
                <div class="p-2 d-flex justify-content-end" id="wilayah_container">
                    <button type="button" class="btn btn-info mr-2" @click="excel_umkm()">Export</button>
                </div>
                <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Wilayah</th>
                            <th>Jumlah SLS</th>
                            <th>SLS Selesai (persen)</th>
                            <th>Jumlah KK</th>
                            <th>Jumlah Usaha</th>
                            <th>Jumlah Koperasi</th>
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
                                        <a
                                            href="{{ url(
                                                'dashboard/index?kab_filter=' .
                                                    (isset($dt['kode_kab']) ? $dt['kode_kab'] : '') .
                                                    '&kec_filter=' .
                                                    (isset($dt['kode_kec']) ? $dt['kode_kec'] : '') .
                                                    '&desa_filter=' .
                                                    (isset($dt['kode_desa']) ? $dt['kode_desa'] : ''),
                                            ) }}">
                                            {{ '[' . $dt['kode_wilayah'] . '] ' . $dt['nama_wilayah'] }}</a>
                                    </td>
                                    <td>
                                        {{ $dt['jml_sls'] }}
                                    </td>
                                    <td>
                                        {{ $dt['status_selesai'] }}
                                        @if ($dt['jml_sls'])
                                            {{ '(' . round(100 * ($dt['status_selesai'] / $dt['jml_sls']), 3) . '%)' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $dt['jml_kk'] }}
                                    </td>
                                    <td>
                                        {{ $dt['jml_usaha'] }}
                                    </td>
                                    <td>
                                        {{ $dt['jml_koperasi'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                    @endif
                </table>
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
                    kab_filter: {!! json_encode($request->kab_filter) != 'null' ? json_encode($request->kab_filter) : '""' !!},
                    kec_filter: {!! json_encode($request->kec_filter) != 'null' ? json_encode($request->kec_filter) : '""' !!},
                    desa_filter: {!! json_encode($request->desa_filter) != 'null' ? json_encode($request->desa_filter) : '""' !!},

                }
            },
            mounted() {
                const self = this;
                const auth = {!! json_encode($auth) !!}
            },
            methods: {

                excel_umkm(event) {

                    var self = this
                    filter = "?kode_kab=" + self.kab_filter +
                        "&kode_kec=" + self.kec_filter +
                        "&kode_desa=" + self.desa_filter +
                        "&id_sls=" + self.sls_filter
                    var url = 'https://st23.bpssumsel.com/api/export_ruta' + filter;

                    window.open(url, "_blank");
                },
            }

        });
    </script>
@endsection
