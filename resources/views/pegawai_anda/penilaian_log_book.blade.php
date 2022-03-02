
<div class="tab-pane" id="log_book">
    <section class="datas">
        <div class="table-responsive">
            <button type="button" class="btn btn-primary float-right mb-2" @click="saveData">Simpan</button>
            <table class="table-bordered m-b-0" style="min-width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Pegawai</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Durasi & waktu</th>
                        <th class="text-center">Isi & Hasil</th>
                        <th class="text-center">Status Penyelesaian (%)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(data, index) in logbooks" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td class="text-center">
                            @{{ data.user_name }}<br/>
                            @{{ data.user_nmjab }}
                        </td>
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
            <button type="button" class="btn btn-primary float-right mt-2" @click="saveData">Simpan</button>
        </div>
    </section>
</div>