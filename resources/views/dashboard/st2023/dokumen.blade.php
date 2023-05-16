<div class="p-2 d-flex justify-content-end"">

    @if ($request->kab_filter)
        <a href="#" onclick="export_alokasi();" class="btn btn-info ml-2">Export Alokasi</a>

        <a href="#" onclick="import_alokasi();" class="btn btn-info  ml-2">Import Alokasi</a>
    @endif

    <br>

</div>
<br /><br />

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
                <th>Jumlah Non Respon</th>
                <th>Dokumen BPS</th>
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
                            {{ $dt_dok['jml_nr'] }}
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
