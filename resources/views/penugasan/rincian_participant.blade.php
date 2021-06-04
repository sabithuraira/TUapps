<b>Daftar Participant</b> -
&nbsp <a href="#" id="add-participant" data-toggle="modal" data-target="#form_rincian2">Tambah Participant &nbsp &nbsp<i class="icon-plus text-info"></i></a>

<select id="participant_select" class="ms" multiple="multiple">
    @foreach($list_pegawai as $data)
        <option value="{{ $data->email }}">{{ $data->nip_baru }} - {{ $data->name }}</option>
    @endforeach
</select>
<br/>
<div class="table-responsive">
    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
        <thead>
            <tr class="text-center">
                <td rowspan="2">No</td>
                <td rowspan="2">Pegawai</td>
                <td colspan="2">Jumlah</td>
                <td rowspan="2">Status</td>
                <td rowspan="2">Skor</td>
                <td rowspan="2" colspan="2">Aksi</td>
            </tr>
            <tr class="text-center">
                <td>Target</td>
                <td>Realisasi</td>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in participant" :key="data.user_nip_lama">
                <td>
                    <template v-if="is_delete(data.id)">
                        <a :data-id="data.id" v-on:click="deleteParticipant(data.id)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    </template>
                    
                    <a href="#" role="button" v-on:click="updateParticipant" data-toggle="modal" 
                                :data-id="data.id" :data-index="index" 
                                :data-user_nip_lama="data.user_nip_lama" :data-user_id="data.user_id" 
                                :data-jumlah_target="data.jumlah_target" :data-unit_kerja="data.unit_kerja" 
                                :data-nilai_waktu="data.nilai_waktu" :data-nilai_penyelesaian="data.nilai_penyelesaian" 
                                data-target="#form_rincian"> <i class="icon-pencil"></i></a>
                    
                    <template v-if="!is_delete(data.id)">
                        <a :data-id="data.id" v-on:click="deleteTempParticipant(index)"><i class="fa fa-trash text-danger"></i>&nbsp </a>
                    </template>
                    @{{ index+1 }}
                </td>
                    <td>@{{ data.user_nip_baru }} - @{{ data.user_nama }}</td>
                    <td><input class="form-control form-control-sm" type="text" v-model="data.jumlah_target"></td>
                    <td><input class="form-control form-control-sm" type="text" v-model="data.jumlah_selesai"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>