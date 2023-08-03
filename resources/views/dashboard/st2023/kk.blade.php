{{-- <a href="#" onclick="tableToExcel();" class="btn btn-info float-right">Unduh Excel</a> --}}
<br /><br />

<table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
    <thead>
        <tr></tr>
        <tr class="text-center">
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Wilayah</th>
            <th colspan="3">Sektor 1</th>
            <th colspan="3">Sektor 2</th>
            <th colspan="3">Sektor 3</th>
            <th colspan="3">Sektor 4</th>
            <th colspan="3">Sektor 5</th>
            <th colspan="3">Sektor 6</th>
        </tr>
        <tr>
            <th>Regsosek</th>
            <th>ST2023</th>
            <th>%</th>
            <th>Regsosek</th>
            <th>ST2023</th>
            <th>%</th>
            <th>Regsosek</th>
            <th>ST2023</th>
            <th>%</th>
            <th>Regsosek</th>
            <th>ST2023</th>
            <th>%</th>
            <th>Regsosek</th>
            <th>ST2023</th>
            <th>%</th>
            <th>Regsosek</th>
            <th>ST2023</th>
            <th>%</th>
        </tr>
    </thead>
    @if (sizeof($data_kk) > 0)
        <tbody>
            @foreach ($data_kk as $index => $dt_kk)
                <tr class="text-center">
                    <td>
                        {{ ++$index }}
                    </td>
                    <td class="text-left">
                        {{ '[' . $dt_kk['kode_wilayah'] . '] ' . $dt_kk['nama_wilayah'] }}

                        {{-- <a
                                href="{{ url(
                                    'dashboard/index?kab_filter=' .
                                        (isset($dt_kk['kode_kab']) ? $dt_kk['kode_kab'] : '') .
                                        '&kec_filter=' .
                                        (isset($dt_kk['kode_kec']) ? $dt_kk['kode_kec'] : '') .
                                        '&desa_filter=' .
                                        (isset($dt_kk['kode_desa']) ? $dt_kk['kode_desa'] : '') .
                                        '&sls_filter=' .
                                        (isset($dt_kk['id_sls']) ? $dt_kk['id_sls'] : ''),
                                ) }}">
                                {{ '[' . $dt_kk['kode_wilayah'] . '] ' . $dt_kk['nama_wilayah'] }}</a> --}}
                    </td>
                    <td>
                        {{ $dt_kk['reg_sektor1'] }}
                    </td>
                    <td>
                        {{ $dt_kk['st_sektor1'] }}
                    </td>
                    <td>
                        @if ($dt_kk['reg_sektor1'] != '0')
                            {{ $dt_kk['st_sektor1'] / $dt_kk['reg_sektor1'] . '%' }}
                        @else
                            0%
                        @endif
                    </td>
                    <td>
                        {{ $dt_kk['reg_sektor2'] }}
                    </td>
                    <td>
                        {{ $dt_kk['st_sektor2'] }}
                    </td>
                    <td>
                        @if ($dt_kk['reg_sektor2'] != '0')
                            {{ $dt_kk['st_sektor2'] / $dt_kk['reg_sektor2'] . '%' }}
                        @else
                            0%
                        @endif
                    </td>

                    <td>
                        {{ $dt_kk['reg_sektor3'] }}
                    </td>
                    <td>
                        {{ $dt_kk['st_sektor3'] }}
                    </td>
                    <td>
                        @if ($dt_kk['reg_sektor3'] != '0')
                            {{ $dt_kk['st_sektor3'] / $dt_kk['reg_sektor3'] . '%' }}
                        @else
                            0%
                        @endif
                    </td>

                    <td>
                        {{ $dt_kk['reg_sektor4'] }}
                    </td>
                    <td>
                        {{ $dt_kk['st_sektor4'] }}
                    </td>
                    <td>
                        @if ($dt_kk['reg_sektor4'] != '0')
                            {{ $dt_kk['st_sektor4'] / $dt_kk['reg_sektor4'] . '%' }}
                        @else
                            0%
                        @endif
                    </td>

                    <td>
                        {{ $dt_kk['reg_sektor5'] }}
                    </td>
                    <td>
                        {{ $dt_kk['st_sektor5'] }}
                    </td>
                    <td>
                        @if ($dt_kk['reg_sektor5'] != '0')
                            {{ $dt_kk['st_sektor5'] / $dt_kk['reg_sektor5'] . '%' }}
                        @else
                            0%
                        @endif
                    </td>

                    <td>
                        {{ $dt_kk['reg_sektor6'] }}
                    </td>
                    <td>
                        {{ $dt_kk['st_sektor6'] }}
                    </td>
                    <td>
                        @if ($dt_kk['reg_sektor6'] != '0')
                            {{ $dt_kk['st_sektor6'] / $dt_kk['reg_sektor6'] . '%' }}
                        @else
                            0%
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    @else
    @endif
</table>
