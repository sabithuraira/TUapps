<b>Daftar Pegawai</b> -
&nbsp <a href="#" id="add-utama" data-toggle="modal" data-target="#form_rincian">Tambah Rincian Pegawai &nbsp &nbsp<i class="icon-plus text-info"></i></a>
<div class="table-responsive">
    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Pegawai</th>
                <th class="text-center">Tujuan</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Pejabat Penandatangan</th>
                <th class="text-center">Tingkat Biaya</th>
                <th class="text-center">Kendaraan yg digunakan</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in rincian" :key="data.id">
                <td>
                    <template v-if="is_delete(data.id)">
                        <a :data-id="data.id" v-on:click="delData(data.id)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    </template>
                    
                    <a href="#" role="button" v-on:click="updateRincian" data-toggle="modal" 
                                :data-id="data.id" :data-index="index" :data-nip="data.nip" 
                                :data-tujuan_tugas="data.tujuan_tugas" 
                                :data-tanggal_mulai="data.tanggal_mulai" :data-tanggal_selesai="data.tanggal_selesai" 
                                :data-pejabat_ttd_nip="data.pejabat_ttd_nip" :data-pejabat_ttd_nama="data.pejabat_ttd_nama"
                                :data-tingkat_biaya="data.tingkat_biaya" :data-kendaraan="data.kendaraan"
                                data-target="#form_rincian"> <i class="icon-pencil"></i></a>
                    
                    <template v-if="!is_delete(data.id)">
                        <a :data-id="data.id" v-on:click="delDataTemp(index)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    </template>
                    @{{ index+1 }}
                </td>

                    <td>
                        @{{ data.nip }} - @{{ data.nama }}
                        <input type="hidden" :name="'u_nip'+data.id" v-model="data.nip">
                        <input type="hidden" :name="'u_nama'+data.id" v-model="data.nama">
                        <input type="hidden" :name="'u_jabatan'+data.id" v-model="data.jabatan">
                    </td>
                    <td>@{{ data.tujuan_tugas }}<input type="hidden" :name="'u_tujuan_tugas'+data.id" v-model="data.tujuan_tugas"></td>
                    <td>
                        <b>@{{ data.tanggal_mulai }}</b> sd <b>@{{ data.tanggal_selesai }}</b>
                        <input type="hidden" :name="'u_tanggal_mulai'+data.id" v-model="data.tanggal_mulai">
                        <input type="hidden" :name="'u_tanggal_selesai'+data.id" v-model="data.tanggal_selesai">
                    </td>
                    <td>
                        @{{ data.pejabat_ttd_nip }} - @{{ data.pejabat_ttd_nama }}
                        <input type="hidden" :name="'u_pejabat_ttd_nip'+data.id" v-model="data.pejabat_ttd_nip">
                        <input type="hidden" :name="'u_pejabat_ttd_nama'+data.id" v-model="data.pejabat_ttd_nama">
                        <input type="hidden" :name="'u_pejabat_ttd_jabatan'+data.id" v-model="data.pejabat_ttd_jabatan">
                    </td>
                    <td class="text-center">@{{ list_tingkat_biaya[data.tingkat_biaya] }}<input type="hidden" :name="'u_tingkat_biaya'+data.id" v-model="data.tingkat_biaya"></td>
                    <td class="text-center">@{{ list_kendaraan[data.kendaraan] }}<input type="hidden" :name="'u_kendaraan'+data.id" v-model="data.kendaraan"></td>      
                </tr>
            </tbody>
        </table>
    </div>