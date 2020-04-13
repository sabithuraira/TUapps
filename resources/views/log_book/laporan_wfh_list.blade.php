<div id="load">
    <div class="table-responsive">
        <table class="table-bordered m-b-0">
            <thead>
                <tr class="text-center">
                    <th rowspan="2">NO</th>
                    <th rowspan="2">DESKRIPSI PEKERJAAN/PENUGASAN</th>
                    <th colspan="2">KUANTITAS</th>
                    <th rowspan="2">DURASI WAKTU PENGERJAAN</th>
                    <th rowspan="2">PEMBERI TUGAS</th>
                    <th rowspan="2">STATUS PENYELESAIAN</th>
                </tr>
                
                <tr class="text-center">
                    <th>VOLUME</th>
                    <th>SATUAN</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(data, index) in datas" :key="data.id">
                    <td>@{{ index+1 }}</td>
                    <td>@{{ data.isi }}</td>
                    <td>@{{data.volume }}</td>
                    <td>@{{data.satuan }}</td>
                    <td>@{{ durasi(data.waktu_selesai, data.waktu_mulai) }}</td>
                    <td>@{{data.pemberi_tugas }}</td>
                    <td>@{{data.status_penyelesaian }} %</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>