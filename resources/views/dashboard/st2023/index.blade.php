<style>
    .c3-axis-x text {
        font-size: 10px;
    }
</style>

<div class="card">
    <div class="body profilepage_2 blog-page">
        <b>MONITORING ST 2023 :</b>
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
        @if ($request->sls_filter)
            -<u><a
                    href="{{ url(
                        'dashboard/index?kab_filter=' .
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

        <br /><br />
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#st_wilayah">SLS</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#st_kk">KK</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#st_dokumen">Dokumen</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane show active" id="st_sls">
                    <h6>Wilayah</h6>
                    @include('dashboard.st2023.wilayah')
                </div>
                <div class="tab-pane  " id="st_kk">
                    <h6>Keluarga</h6>
                    {{-- @include('dashboard.st2023.table') --}}
                </div>
                <div class="tab-pane  " id="st_dokumen">
                    <h6>Dokumen</h6>
                    {{-- @include('dashboard.st2023.table') --}}
                </div>
            </div>

        </div>
    </div>
</div>

@section('scriptsasd')
    {{-- <script src="{!! asset('assets/bundles/c3.bundle.js') !!}"></script>
    <script>
        var series = {!! json_encode($persens) !!};
        var chart = c3.generate({
            bindto: '#chart-bar', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1'].concat(series),
                ],
                type: 'bar',
                colors: {
                    'data1': lucid.colors["blue"]
                },
                names: {
                    'data1': 'Persentase dilaporkan: '
                }
            },
            axis: {
                x: {
                    type: 'category',
                    categories: {!! json_encode($labels) !!},
                },
                y: {
                    max: 100,
                },
            },
            bar: {
                ratio: 0.5
            },
            legend: {
                show: false, //hide legend
            },
            padding: {
                bottom: 100,
                top: 10
            },
        });

        var tableToExcel = (function() {
            var uri = "data:application/vnd.ms-excel;base64,",
                template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http:\/\/www.w3.org\/TR\/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}<\/x:Name><x:WorksheetOptions><x:DisplayGridlines\/><\/x:WorksheetOptions><\/x:ExcelWorksheet><\/x:ExcelWorksheets><\/x:ExcelWorkbook><\/xml><![endif]--><\/head><body><table>{table}<\/table><\/body><\/html>',
                base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)));
                },
                format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    });
                };

            return function() {
                table = 'initabel';
                fileName = 'rekap_pemutakhiran.xls';
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {
                    worksheet: fileName || 'Worksheet',
                    table: table.innerHTML
                }

                $("<a id='dlink'  style='display:none;'></a>").appendTo("body");
                document.getElementById("dlink").href = uri + base64(format(template, ctx))
                document.getElementById("dlink").download = fileName;
                document.getElementById("dlink").click();
            }

        })();
    </script> --}}
@endsection
