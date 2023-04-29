<a href="#" onclick="tableToExcel();" class="btn btn-info float-right">Unduh Excel</a>
<br /><br />

@if (!$request->sls_filter)
    <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Wilayah</th>
                <th>Selesai</th>
                <th>Jumlah</th>
                <th>%</th>

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
                            {{ $data['selesai'] }}
                        </td>
                        <td>
                            {{ $data['jumlah'] }}
                        </td>
                        <td>
                            @if ($data['jumlah'])
                                {{ $data['selesai'] / $data['jumlah'] }} %
                            @endif
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
                <th>Nama Wilayah</th>


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
                                {{ '[' . $data['kode_wilayah'] . '] ' . $data['nama_wilayah'] }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
        @endif
    </table>

@endif
