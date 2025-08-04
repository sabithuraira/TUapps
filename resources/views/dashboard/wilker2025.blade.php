@extends('layouts.blank')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Dashboard Wilkerstat 2025</li>
</ul>
@endsection

@section('content')
    <div class="container">
        <div class="card" id="app_vue">
            <div class="body">
                <b>MONITORING WILKERSTAT 2025 :</b> <br/><br/>
                <template v-if="label=='prov'">
                SUMATERA SELATAN
                </template>
                <template v-else-if="label=='kab'">
                    <u><a :href="curr_url">SUMATERA SELATAN</a></u>
                    - @{{ label_kab }}
                </template>
                <template v-else-if="label=='kec'">
                    <u><a :href="curr_url">SUMATERA SELATAN</a></u>
                    - <u><a :href="curr_url + '?kab=' + kab">@{{ label_kab }}</a></u>
                    - @{{ label_kec }}
                </template>
                <template v-else-if="label=='desa'">
                    <u><a :href="curr_url">SUMATERA SELATAN</a></u>
                    - <u><a :href="curr_url + '?kab=' + kab">@{{ label_kab }}</a></u>
                    - <u><a :href="curr_url + '?kab=' + kab + '&kec=' + kec">@{{ label_kec }}</a></u> 
                    - @{{ label_desa }}   
                </template>
                <br/><br/>

                <div class="table-responsive">
                    <table class="table-bordered m-b-0"  style="min-width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">Wilayah</th>
                                <th colspan="3" class="text-center">SLS</th>
                                <th colspan="6" class="text-center">Jumlah</th>
                            </tr>

                            <tr>
                                <th class="text-center">Target</th>
                                <th class="text-center">Selesai</th>
                                <th class="text-center">Berubah<br/>Batas</th>
                                <th class="text-center">KK</th>
                                <th class="text-center">BTT</th>
                                <th class="text-center">BTT<br/>Kosong</th>
                                <th class="text-center">BKU</th>
                                <th class="text-center">BBTTN<br/>Non</th>
                                <th class="text-center">Perkiraan<br/>Muatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in datas" :key="data.idw">
                                <td>
                                    <template v-if="label=='prov'" >
                                        <a :href="curr_url + '?kab=' + data.idw">@{{ data.idw }} - @{{ data.nama }}</a>
                                    </template>
                                    <template v-else-if="label=='kab'" >
                                        <a :href="curr_url + '?kab=' + kab + '&kec=' + data.idw">@{{ data.idw }} - @{{ data.nama }}</a>
                                    </template>
                                    <template v-else-if="label=='kec'" >
                                        <a :href="curr_url + '?kab=' + kab + '&kec=' + kec + '&desa=' + data.idw">@{{ data.idw }} - @{{ data.nama }}</a>
                                    </template>
                                    <template v-else-if="label=='desa'" >
                                        @{{ data.idw }} - @{{ data.nama }}
                                    </template>
                                </td>
                                <td class="text-center">@{{ data.total }}</td>
                                <td class="text-center">@{{ data.jumlah_selesai }}</td>
                                <td class="text-center">@{{ data.jumlah_berubah_batas }}</td>
                                <td class="text-center">@{{ data.laporan_jumlah_kk }}</td>
                                <td class="text-center">@{{ data.laporan_jumlah_btt }}</td>
                                <td class="text-center">@{{ data.laporan_jumlah_btt_kosong }}</td>
                                <td class="text-center">@{{ data.laporan_jumlah_bku }}</td>
                                <td class="text-center">@{{ data.laporan_jumlah_bbttn_non }}</td>
                                <td class="text-center">@{{ data.laporan_perkiraan_jumlah }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


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
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        datas: [],
        kab: {!! json_encode($kab) !!},
        kec: {!! json_encode($kec) !!},
        desa: {!! json_encode($desa) !!},
        label: '',
        label_kab: '',
        label_kec: '',
        label_desa: '',
        api_url: 'https://st23.bpssumsel.com/api/dashboard/wilkerstat2025',
        curr_url: {!! json_encode(url('dashboard/data/wilker2025')) !!}
    },
    methods: {
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');

            $.ajax({
                url : self.api_url,
                method : 'get',
                dataType: 'json',
                data:{
                    kab: self.kab, 
                    kec: self.kec, 
                    desa: self.desa, 
                },
            }).done(function (data) {
                self.datas = data.datas;
                self.label = data.label;
                self.label_kab = data.label_kab;
                self.label_kec = data.label_kec;
                self.label_desa = data.label_desa;
                console.log(self.label)
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        }, 
    }
});

$(document).ready(function() {
    vm.setDatas(); 
});
</script>
@endsection