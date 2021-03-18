<b>Daftar Pegawai</b> -
&nbsp <a href="#" id="add-utama" data-toggle="modal" data-target="#form_rincian">Tambah Pegawai Organik &nbsp &nbsp<i class="icon-plus text-info"></i></a>
&nbsp <a href="#" id="add-utama" data-toggle="modal" data-target="#form_rincian2">Tambah Mitra &nbsp &nbsp<i class="icon-plus text-info"></i></a>
<div class="small text-mute">(rincian pertama merupakan ketua tim)</div>
<div class="table-responsive">
    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Pegawai/Mitra</th>
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
                                :data-nama="data.nama" :data-jenis_petugas="data.jenis_petugas" 
                                :data-tingkat_biaya="data.tingkat_biaya" :data-kendaraan="data.kendaraan"
                                data-target="#form_rincian"> <i class="icon-pencil"></i></a>
                    
                    <template v-if="!is_delete(data.id)">
                        <a :data-id="data.id" v-on:click="delDataTemp(index)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    </template>
                    @{{ index+1 }}
                </td>

                    <td>
                        <div v-if="data.nip!=''">
                            @{{ data.nip }} - @{{ data.nama }}
                        </div>
                        <div v-else>
                            @{{ data.nama }}
                        </div>
                        <input type="hidden" :name="'u_nip'+data.id" v-model="data.nip">
                        <input type="hidden" :name="'u_nama'+data.id" v-model="data.nama">
                        <input type="hidden" :name="'u_jabatan'+data.id" v-model="data.jabatan">
                        <input type="hidden" :name="'u_jenis_petugas'+data.id" v-model="data.jenis_petugas">
                    </td>
                    <td class="text-center">@{{ list_tingkat_biaya[data.tingkat_biaya] }}<input type="hidden" :name="'u_tingkat_biaya'+data.id" v-model="data.tingkat_biaya"></td>
                    <td class="text-center">@{{ list_kendaraan[data.kendaraan] }}<input type="hidden" :name="'u_kendaraan'+data.id" v-model="data.kendaraan"></td>      
                </tr>
            </tbody>
        </table>
    </div>