<div id="load">
    <div class="table-responsive">
        <table class="table-bordered  m-b-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama/NIP</th>
                    <td>% Kuantitas</td>
                    <td>Kualitas</td>
                    <td>Kecepatan</td>
                    <td>Ketepatan</td>
                    <td>Ketuntasan</td>
                    <td>Penilaian Pimpinan</td>
                    <th>NILAI CKP</th>
                    <th>Terakhir Diperbaharui</th>
                </tr>
            </thead>

            <tbody>
            
                <tr v-for="(data, index) in datas" :key="data.id">
                    <td>@{{ index+1 }} </td>
                    <td>@{{ data.name }} / @{{ data.nip_baru }}</td>
                    <td class="text-center">@{{ (data.realisasi_kuantitas==0) ? 0 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(2) }}</td>
                    <td class="text-center">@{{ data.kualitas }}</td>
                    <td class="text-center">@{{ data.kecepatan }}</td>
                    <td class="text-center">@{{ data.ketepatan }}</td>
                    <td class="text-center">@{{ data.ketuntasan }}</td>
                    <td class="text-center">@{{ data.penilaian_pimpinan }}</td>
                    <td class="text-center">@{{ (data.realisasi_kuantitas==0) ? 0 : (((data.realisasi_kuantitas/data.target_kuantitas*100)+data.kualitas)/2).toFixed(2) }}</td>
                    <td class="text-center">@{{ data.last_updated }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>