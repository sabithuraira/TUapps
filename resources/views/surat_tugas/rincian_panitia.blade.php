<b>Daftar Panitia</b> -
&nbsp <a href="#" data-toggle="modal" data-target="#form_pelatihan" v-on:click="setKategoriPeserta(3)">Tambah Panitia Organik &nbsp &nbsp<i class="icon-plus text-info"></i></a>
&nbsp <a href="#" data-toggle="modal" data-target="#form_pelatihan_mitra" v-on:click="setKategoriPeserta(3)">Tambah Panitia Mitra &nbsp &nbsp<i class="icon-plus text-info"></i></a>
<div class="table-responsive">
    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Pegawai/Mitra</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Unit Kerja</th>
                <th class="text-center">Asal</th>
                <th class="text-center">Tingkat Biaya</th>
                <th class="text-center">Kendaraan</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data, index) in rincian_panitia" :key="data.id">
                <td>
                    <template v-if="is_delete(data.id) && 1==0">
                        <a :data-id="data.id" v-on:click="delData(data.id,3)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    </template>

                    <template v-if="data.jenis_peserta==1">
                        <a href="#" role="button" v-on:click="updateRincian" data-toggle="modal" 
                            :data-id="data.id" :data-index="index" :data-nip="data.nip" 
                            :data-nama="data.nama" :data-gol="data.gol" :data-jabatan="data.jabatan"
                            :data-jabatan_pelatihan="data.jabatan_pelatihan" :data-asal_daerah="data.asal_daerah" 
                            :data-unit_kerja="data.unit_kerja" :data-jenis_peserta="data.jenis_peserta"     
                            :data-tingkat_biaya="data.tingkat_biaya" :data-kendaraan="data.kendaraan"
                            :data-kategori_peserta="data.kategori_peserta"
                            data-target="#form_pelatihan"> <i class="icon-pencil"></i></a>
                    </template>

                    <template v-if="data.jenis_peserta==2">
                        <a href="#" role="button" v-on:click="updateRincian" data-toggle="modal" 
                            :data-id="data.id" :data-index="index" :data-nip="data.nip" 
                            :data-nama="data.nama" :data-gol="data.gol" :data-jabatan="data.jabatan"
                            :data-jabatan_pelatihan="data.jabatan_pelatihan" :data-asal_daerah="data.asal_daerah" 
                            :data-unit_kerja="data.unit_kerja" :data-jenis_peserta="data.jenis_peserta"     
                            :data-tingkat_biaya="data.tingkat_biaya" :data-kendaraan="data.kendaraan"
                            :data-kategori_peserta="data.kategori_peserta"
                            data-target="#form_pelatihan_mitra"> <i class="icon-pencil"></i></a>
                    </template>
                    
                    <template v-if="!is_delete(data.id)">
                        <a :data-id="data.id" v-on:click="delDataTemp(index,3)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
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
                    <input type="hidden" :name="'panitia_nip'+data.id" v-model="data.nip">
                    <input type="hidden" :name="'panitia_nama'+data.id" v-model="data.nama">
                    <input type="hidden" :name="'panitia_gol'+data.id" v-model="data.gol">
                    <input type="hidden" :name="'panitia_jabatan'+data.id" v-model="data.jabatan">
                    <input type="hidden" :name="'panitia_jabatan_pelatihan'+data.id" v-model="data.jabatan_pelatihan">
                    <input type="hidden" :name="'panitia_asal_daerah'+data.id" v-model="data.asal_daerah">
                    <input type="hidden" :name="'panitia_unit_kerja'+data.id" v-model="data.unit_kerja">
                    <input type="hidden" :name="'panitia_jenis_peserta'+data.id" v-model="data.jenis_peserta">
                    <input type="hidden" :name="'panitia_tingkat_biaya'+data.id" v-model="data.tingkat_biaya">
                    <input type="hidden" :name="'panitia_kendaraan'+data.id" v-model="data.kendaraan">
                </td>
                <td class="text-center">@{{ data.jabatan_pelatihan }}</td>
                <td class="text-center">@{{ data.unit_kerja }}</td>
                <td class="text-center">@{{ data.asal_daerah }}</td>
                <td class="text-center">@{{ list_tingkat_biaya[data.tingkat_biaya] }}</td>
                <td class="text-center">@{{ list_kendaraan[data.kendaraan] }}</td>      
            </tr>
        </tbody>
    </table>
</div>