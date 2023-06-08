<div class="p-2 d-flex justify-content-end" id="wilayah_container">
    @if ($request->kab_filter)
        <button type="button" class="btn btn-info mr-2" @click="excel_ruta()">Export Ruta</button>
    @endif
    @if (!$request->sls_filter)
        <button type="button" class="btn btn-info mr-2" @click="excel_progress()">Export Progress</button>
    @endif
</div>
@if (!$request->sls_filter)
    <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Wilayah</th>
                <th>Jumlah</th>
                <th>Selesai (persen)</th>
                <th>Perkiraan Ruta Tani</th>
                <th>Ruta Tani pencacahan</th>
            </tr>
        </thead>
        @if (sizeof($data_wilayah) > 0)
            <tbody>
                @foreach ($data_wilayah as $index => $data)
                    <tr class="text-center">
                        <td>
                            {{ ++$index }}
                        </td>
                        <td class="text-left">
                            <a
                                href="{{ url(
                                    'dashboard/index?kab_filter=' .
                                        (isset($data['kode_kab']) ? $data['kode_kab'] : '') .
                                        '&kec_filter=' .
                                        (isset($data['kode_kec']) ? $data['kode_kec'] : '') .
                                        '&desa_filter=' .
                                        (isset($data['kode_desa']) ? $data['kode_desa'] : '') .
                                        '&sls_filter=' .
                                        (isset($data['id_sls']) ? $data['id_sls'] : ''),
                                ) }}">
                                {{ '[' . $data['kode_wilayah'] . '] ' . $data['nama_wilayah'] }}</a>
                        </td>
                        <td>
                            {{ $data['jumlah'] }}
                        </td>
                        <td>
                            {{ $data['selesai'] }} @if ($data['jumlah'])
                                {{ '(' . round($data['selesai'] / $data['jumlah'], 3) . '%)' }}
                            @endif
                        </td>

                        <td>
                            {{ $data['perkiraan_ruta'] }}
                        </td>
                        <td>
                            {{ $data['ruta_selesai'] }}
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
            <tr class="text-center">
                <th>No</th>
                <th>Nu RT</th>
                <th>Nama</th>
                <th>Jumlah Usaha</th>
                <th>Waktu</th>
                <th>Jarak titik <br> mulai & selesai</th>
            </tr>
        </thead>
        @if (sizeof($data_wilayah) > 0)
            <tbody>
                @foreach ($data_wilayah as $index => $data)
                    <tr class="text-center">
                        <td>
                            {{ ++$index }}
                        </td>
                        <td>
                            {{ $data['nurt'] }}
                        </td>
                        <td class="text-left">
                            {{ $data['kepala_ruta'] }}
                        </td>
                        <td>
                            {{ $data['jumlah_unit_usaha'] }}
                        </td>
                        <td class="">
                            @php
                                $start = new DateTime($data['start_time']);
                                $end = new DateTime($data['end_time']);
                                $duration = $start->diff($end);
                                $days = $duration->days;
                                $hours = $duration->h; // Jam
                                $minutes = $duration->i; // Menit
                                $seconds = $duration->s; // Detik
                                if ($days) {
                                    $durationString = $days . ' hari ' . $hours . ':' . $minutes . ':' . $seconds;
                                } else {
                                    $durationString = $hours . ':' . $minutes . ':' . $seconds;
                                }
                                
                                // $minutes = $duration->days * 24 * 60; // Mengubah jumlah hari menjadi menit
                                // $minutes += $duration->h * 60; // Menambahkan jumlah jam menjadi menit
                                // $minutes += $duration->i; // Menambahkan jumlah menit
                                
                            @endphp
                            {{ htmlspecialchars($durationString) }}
                        </td>
                        <td class="text-right">
                            @php
                                $earthRadius = 6371; // Radius bumi dalam kilometer
                                
                                $latDiff = deg2rad($data['end_latitude'] - $data['start_latitude']);
                                $lonDiff = deg2rad($data['end_longitude'] - $data['start_longitude']);
                                
                                $a = sin($latDiff / 2) * sin($latDiff / 2) + cos(deg2rad($data['start_latitude'])) * cos(deg2rad($data['end_latitude'])) * sin($lonDiff / 2) * sin($lonDiff / 2);
                                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                
                                $distance = $earthRadius * $c * 1000; // Mengubah jarak ke meter
                                
                            @endphp
                            {{ round($distance, 2) . ' m' }}
                        </td>
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
        el: "#wilayah_container",
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
            excel_ruta(event) {
                var self = this
                const headers = {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.api_token
                };
                filter = "?kode_kab=" + self.kab_filter +
                    "&kode_kec=" + self.kec_filter +
                    "&kode_desa=" + self.desa_filter +
                    "&id_sls=" + self.sls_filter
                fetch('https://st23.bpssumsel.com/api/export_ruta' + filter, {
                        method: 'GET',
                        headers: headers,
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        var url = window.URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = "ruta_16" + self.kab_filter + self.kec_filter + self.desa_filter + self
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
