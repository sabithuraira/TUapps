<div class="tab-pane show active" id="ckp_penilaian">
    <section class="datas">
        <div class="table-responsive">
            <table class="table-sm table-bordered m-b-0" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th width="40%">Uraian</th>
                        
                        <th width="30%">AK & IKI</th>
                        <th width="30%">Penilaian</th>
                    </tr>
                </thead>

                <tbody>
                    <template v-for="(data, index) in ckps">
                        <tr class="align-middle" :key="'identitas'+data.id">
                            <td colspan="3">
                                <div class="float-left pt-2 pr-2">
                                    <b class="m-b-0">@{{ data.name }} - @{{ data.nmjab }}</b>
                                </div>
                            </td>
                        </tr>
                        <tr class="align-top" :key="'konten'+data.id">
                            <td>
                                <span class="badge badge-info m-l-10 hidden-sm-down">Satuan: @{{ data.satuan }}</span>
                                <span class="badge badge-success m-l-10 hidden-sm-down">Realisasi: @{{ data.target_kuantitas }}/@{{ data.realisasi_kuantitas }} @{{ (data.target_kuantitas/data.realisasi_kuantitas)*100 }}%</span><br/>
                                <span>@{{ data.uraian }}</span>
                            </td>
                            <td>
                                <span v-if="(data.kode_butir!='' && data.kode_butir!=null) || (data.angka_kredit!='' && data.angka_kredit!=null)" class="badge badge-info m-l-10 hidden-sm-down">@{{ data.kode_butir }} : @{{ data.angka_kredit }}</span>
                                <span v-else class="badge badge-warning m-l-10 hidden-sm-down">Tidak tersedia informasi AK</span>
                                
                                <span v-if="data.iki_label!='' && data.iki_label!=null">@{{ data.iki_label }}</span>
                                <span v-else class="badge badge-warning m-l-10 hidden-sm-down mt-2">Tidak tersedia informasi IKI</span>
                            </td>
                            <td>
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <span>Kecepatan:</span>
                                        <input class="form-control form-control-sm" v-model="data.kecepatan" type="number" max="100">
                                    </div>

                                    <div class="col-md-4">
                                        <span>Ketuntasan:</span>
                                        <input class="form-control form-control-sm" v-model="data.ketuntasan" type="number" max="100">
                                    </div>

                                    <div class="col-md-4">
                                        <span>Ketepatan:</span>
                                        <input class="form-control form-control-sm" v-model="data.ketepatan" type="number" max="100">
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="badge badge-success m-l-10 hidden-sm-down">RATA-RATA: 100</span>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>    
    </section>
</div>