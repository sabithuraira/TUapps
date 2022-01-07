
<div class="tab-pane" id="rencana_kerja">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 left-box">

            <div class="form-group">
                <label>Rentang Waktu:</label>
                
                <div class="input-daterange input-group" data-provide="datepicker">
                    <input type="text" class="input-sm form-control" v-model="start_rencana" id="start_rencana" name="start_rencana">
                    <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                    
                    <input type="text" class="input-sm form-control" v-model="end_rencana" id="end_rencana" name="end_rencana">
                </div>
            </div>
        </div>
    </div>

    <section class="datas">
        <div class="table-responsive">
            <table class="table-bordered m-b-0" style="min-width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Durasi & waktu</th>
                        <th class="text-center">Isi & Hasil</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(data, index) in datas_rencana" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td class="text-center">
                            Pemberi Tugas: @{{ data.pemberi_tugas }}
                            <p class="text-muted">Volume(satuan): @{{ data.volume }} (@{{ data.satuan }})</p>
                            <span class="text-muted">Progres: @{{ data.status_penyelesaian }} %</span>
                        </td>

                        <td class="text-center">
                            <span class="badge badge-pill badge-dark">@{{ durasi(data.waktu_selesai, data.waktu_mulai) }}</span>
                            <br/>
                            @{{ data.tanggal }}
                            <p class="text-muted">Pukul: @{{ data.waktu_mulai }} - @{{ data.waktu_selesai }}</p>
                        </td>
                        <td>
                            @{{ data.isi }}
                            <p class="text-muted">Hasil: @{{ data.hasil }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>