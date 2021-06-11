<b>Daftar Participant</b>

<div class="table-responsive">
    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
        <thead>
            <tr class="text-center">
                <td rowspan="2">No</td>
                <td rowspan="2">Pegawai</td>
                <td rowspan="2">Keterangan</td>
                <td colspan="3">Jumlah</td>
                <td rowspan="2">Progres <br/>Terakhir Pada</td>
                <td rowspan="2">Skor</td>
                <td rowspan="2">Aksi</td>
            </tr>
            <tr class="text-center">
                <td>Target</td>
                <td>Dilaporkan</td>
                <td>Realisasi</td>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in participant" :key="data.user_nip_lama">
                <td>
                    @{{ index+1 }}
                </td>
                    <td>@{{ data.user_nip_baru }} - @{{ data.user_nama }}</td>  
                    <td>@{{ data.keterangan }}</td>                    
                    <td class="text-center">@{{ data.jumlah_target }}</td>
                    <td class="text-center">@{{ data.jumlah_lapor }}</td>
                    <td class="text-center">@{{ data.jumlah_selesai }}</td>
                    <td class="text-center">@{{ data.tanggal_last_progress }}</td>
                    <td></td>
                    <td class="text-center">
                        <a href="#" role="button" @click="updateProgres" data-toggle="modal" 
                                :data-id="data.id" :data-user_nama="data.user_nama" :data-keterangan="data.keterangan" 
                                :data-jumlah_target="data.jumlah_target" :data-jumlah_selesai="data.jumlah_selesai" 
                                :data-tanggal_last_progress="data.tanggal_last_progress"
                                data-target="#add_progres"> <i class="icon-pencil"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>