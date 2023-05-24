{{-- <div class="p-2 d-flex justify-content-end">
    <a href="#" onclick="tableToExcel();" class="btn btn-info float-right">Unduh Excel</a>
</div> --}}
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
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Latitude, Longitude</th>
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
                        <td class="text-left">
                            {{ $data['start_time'] }}
                        </td>
                        <td class="text-left">
                            {{ $data['end_time'] }}
                        </td>
                        <td class="text-left">
                            {{ $data['end_latitude'] }} , {{ $data['end_longitude'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
        @endif
    </table>
@endif
