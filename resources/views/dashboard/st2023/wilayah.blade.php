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
                <th>Jumlah SLS</th>
                <th>SLS Selesai (persen)</th>
                <th>Prelist Ruta</th>
                {{-- <th>Prelist Ruta Pertanian</th> --}}
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
                                    'dashboard/st2023?kab_filter=' .
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
                            {{ $data['selesai'] }}
                            @if ($data['jumlah'])
                                {{ '(' . round(100 * ($data['selesai'] / $data['jumlah']), 3) . '%)' }}
                            @endif
                        </td>
                        <td>
                            {{ $data['prelist_ruta'] }}
                        </td>

                        {{-- <td>
                            {{ $data['prelist_ruta_tani'] }}
                        </td> --}}
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
