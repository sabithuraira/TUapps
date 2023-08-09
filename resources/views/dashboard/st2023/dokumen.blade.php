<div id="exportcontainer">
    <div class="p-2 d-flex justify-content-end">
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
                    @if (!$request->kab_filter)
                        <th>Diterima BPS Kab/Kota (SIPMEN)</th>
                        <th>Terpakai (SIPMEN)</th>
                        <th>Dok. Rusak/Kosong (SIPMEN)</th>
                    @endif
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
                                        'dashboard/st2023?kab_filter=' .
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
                            @if (!$request->kab_filter)
                                <td>
                                    <span id="{{ 'sipmen' . $dt_dok['kode_kab'] }}"></span>
                                </td>
                                <td>
                                    <span id="{{ 'sipmen_terpakai' . $dt_dok['kode_kab'] }}"></span>
                                </td>
                                <td>
                                    <span id="{{ 'sipmen_rusak' . $dt_dok['kode_kab'] }}"></span>
                                </td>
                            @endif
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
                                        'dashboard/st2023?kab_filter=' .
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

    <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200"
                            alt="Loading..."></div>
                    <h4 class="text-center">Please wait...</h4>
                </div>
            </div>
        </div>
    </div>
</div>
