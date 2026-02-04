
            <div class="row clearfix">
                <div class="card p-4">
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
                    
                    <a :href="api_download_url+'?kab=' + kab + '&kec=' + kec + '&desa=' + desa" class="'btn btn-info btn-sm"><i class='fa fa-file-excel-o'></i> Download Data SLS</a>
                    <br /><br />

                    <div class="table-responsive">
                        <table class="table-bordered m-b-0"  style="min-width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Wilayah</th>
                                    <th colspan="4" class="text-center">SLS</th>
                                    <th colspan="7" class="text-center">Jumlah</th>
                                </tr>

                                <tr>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Selesai</th>
                                    <th class="text-center">Berubah<br/>Batas</th>
                                    <th class="text-center">% Selesai</th>
                                    <th class="text-center">KK</th>
                                    <th class="text-center">BTT</th>
                                    <th class="text-center">BTT<br/>Kosong</th>
                                    <th class="text-center">BKU</th>
                                    <th class="text-center">BBTTN<br/>Non</th>
                                    <th class="text-center">Perkiraan<br/>Muatan<br/>Usaha</th>
                                    <th class="text-center">Total Muatan<br/>(Maks(KK, BTT) + BTT Kosong +<br/>BBTT NonUsaha + Muatan Usaha)</th>
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
                                    <td class="text-center"><b>@{{ (data.jumlah_selesai/data.total*100).toFixed(2) }} %</b></td>
                                    <td class="text-center">@{{ data.laporan_jumlah_kk }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_btt }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_btt_kosong }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_bku }}</td>
                                    <td class="text-center">@{{ data.laporan_jumlah_bbttn_non }}</td>
                                    <td class="text-center">@{{ data.laporan_perkiraan_jumlah }}</td>
                                    <td class="text-center">
                                        <b>
                                            @{{ parseInt(data.laporan_jumlah_maks)+parseInt(data.laporan_jumlah_btt_kosong)+parseInt(data.laporan_jumlah_bbttn_non)+parseInt(data.laporan_perkiraan_jumlah) }}
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>