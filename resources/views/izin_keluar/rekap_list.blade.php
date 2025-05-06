<div id="load">
    <div class="table-responsive">
        <table class="table-bordered  m-b-0" style="min-width:100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama/NIP</th>
                    <td>Total Waktu (jam)</td>
                    <td>Keterangan</td>
                </tr>
            </thead>

            <tbody>
            
                <tr v-for="(data, index) in datas" :key="data.id">
                    <td class="text-center">@{{ index+1 }} </td>
                    <td>@{{ data.name }} / @{{ data.nip_baru }}</td>
                    <td class="text-center">@{{ (data.jumlah_menit==null) ? 0 : (data.jumlah_menit/60).toFixed(2) }}</td>
                    <td ><div v-html="data.keterangan"></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>