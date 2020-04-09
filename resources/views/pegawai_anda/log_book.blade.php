
<div class="tab-pane" id="log_book">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 left-box">

            <div class="form-group">
                <label>Rentang Waktu:</label>
                
                <div class="input-daterange input-group" data-provide="datepicker">
                    <input type="text" class="input-sm form-control" v-model="start" id="start" name="start">
                    <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                    
                    <input type="text" class="input-sm form-control" v-model="end" id="end" name="end">
                </div>
            </div>
        </div>
    </div>

    <section class="datas">
        <div class="table-responsive">
            <table class="table table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Durasi & waktu</th>
                        <th class="text-center">Isi & Hasil</th>
                        <th class="text-center">Status Penyelesaian (%)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(data, index) in datas" :key="data.id">
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
                        <td><input class="form-control  form-control-sm" type="number" min="0" max="100" :name="'u_status_penyelesaian'+data.id" v-model="data.status_penyelesaian"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>