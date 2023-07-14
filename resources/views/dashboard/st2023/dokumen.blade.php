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
                    @if(!$request->kab_filter)
                    <th>Diterima BPS Kab/Kota (SIPMEN)</th>
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
                            @if(!$request->kab_filter)
                            <td>
                                <span id="{{ 'sipmen'.$dt_dok['kode_kab'] }}">

                                </span>
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

    <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                    <h4 class="text-center">Please wait...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
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
                total_sipmen: {},
                list_kab: [
                    '01', '02', '03', '04', '05', '06', '07', '08', '09'
                    , '10', '11', '12', '13', '71', '72', '73', '74'
                ],
            }
        },
        mounted() {
            const self = this;
            const auth = {!! json_encode($auth) !!}
            this.getSipmenData();
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
            getSipmenData(){
                var self = this;

                for (let i=0;i< self.list_kab.length;++i) {
                    let currKab = self.list_kab[i];
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                    $.ajax({
                        url :  'https://sipmen.bps.go.id/st2023/apigetdataterima?clientid=16&token=4A6C252C118BB7C69D8EA2A3022429&kd_kab=' + currKab,
                        method : 'get',
                        dataType: 'json',
                    }).done(function (data) {
                        $('#wait_progress').modal('hide');
                        let total = data.data
                                        .filter(item => item.kd_dokumen=="ST2023.L2-UTP")
                                        .reduce((sum, x) => {
                                                if(typeof x === 'object'){
                                                    if('jml_terima' in x) sum += parseInt(x.jml_terima)
                                                }
                                                return sum;
                                            }, 0)
                        const element = document.getElementById("sipmen" + currKab);
                        element.innerHTML = total;
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progres').modal('hide');
                    });

                }
            }
        }

    });
</script>
@endsection
