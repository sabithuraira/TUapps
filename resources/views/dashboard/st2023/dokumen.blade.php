<div class="p-2 d-flex justify-content-end" id="exportcontainer">
    <button type="button" class="btn btn-info mr-2" @click="excel_dokumen()">Export Dashboard Dokumen</button>
</div>
@if (!$request->desa_filter)
    <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
        <thead>
            <tr></tr>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Wilayah</th>
                <th>Dokumen PCL</th>
                <th>Dokumen PML</th>
                <th>Dokumen Koseka</th>
                <th>Dokumen Telah di Kantor BPS</th>
            </tr>
        </thead>
        @if (sizeof($data_dokumen) > 0)
            <tbody>
                @foreach ($data_dokumen as $index => $dt_dok)
                    <tr class="text-center">
                        <td>
                            {{ ++$index }}
                        </td>
                        <td class="text-left">
                            <a
                                href="{{ url(
                                    'dashboard/index?kab_filter=' .
                                        (isset($dt_dok['kode_kab']) ? $dt_dok['kode_kab'] : '') .
                                        '&kec_filter=' .
                                        (isset($dt_dok['kode_kec']) ? $dt_dok['kode_kec'] : '') .
                                        '&desa_filter=' .
                                        (isset($dt_dok['kode_desa']) ? $dt_dok['kode_desa'] : '') .
                                        '&sls_filter=' .
                                        (isset($dt_dok['id_sls']) ? $dt_dok['id_sls'] : ''),
                                ) }}">
                                {{ '[' . $dt_dok['kode_wilayah'] . '] ' . $dt_dok['nama_wilayah'] }}</a>
                        </td>
                        <td>
                            {{ $dt_dok['dok_pcl'] }}
                        </td>
                        <td>
                            {{ $dt_dok['dok_pml'] }}
                        </td>
                        <td>
                            {{ $dt_dok['dok_koseka'] }}
                        </td>
                        <td>
                            {{ $dt_dok['dok_bps'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
        @endif
    </table>
@else
    <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
        <thead>
            <tr></tr>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Wilayah</th>

                <th>Kode PCL</th>
                <th>Dokumen PCL</th>

                <th>Kode PML</th>
                <th>Dokumen PML</th>

                <th>Kode Koseka</th>
                <th>Dokumen Koseka</th>
            </tr>
        </thead>
        @if (sizeof($data_dokumen) > 0)
            <tbody>
                @foreach ($data_dokumen as $index => $dt_dok)
                    <tr class="text-center">
                        <td>
                            {{ ++$index }}
                        </td>
                        <td class="text-left">
                            <a
                                href="{{ url(
                                    'dashboard/index?kab_filter=' .
                                        (isset($dt_dok['kode_kab']) ? $dt_dok['kode_kab'] : '') .
                                        '&kec_filter=' .
                                        (isset($dt_dok['kode_kec']) ? $dt_dok['kode_kec'] : '') .
                                        '&desa_filter=' .
                                        (isset($dt_dok['kode_desa']) ? $dt_dok['kode_desa'] : '') .
                                        '&sls_filter=' .
                                        (isset($dt_dok['id_sls']) ? $dt_dok['id_sls'] : ''),
                                ) }}">
                                {{ '[' . $dt_dok['kode_wilayah'] . '] ' . $dt_dok['nama_wilayah'] }}</a>
                        </td>

                        <td>{{ $dt_dok['kode_pcl'] }}</td>
                        <td>{{ $dt_dok['dok_pcl'] }}</td>
                        <td>{{ $dt_dok['kode_pml'] }}</td>
                        <td>{{ $dt_dok['dok_pml'] }}</td>
                        <td>{{ $dt_dok['kode_koseka'] }}</td>
                        <td>{{ $dt_dok['dok_koseka'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        @else
        @endif
    </table>

@endif
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
    var vm = new Vue({
        el: "#exportcontainer",
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
            const auth = {!! json_encode($auth) !!}
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
        }

    });
</script>
