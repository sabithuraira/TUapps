<b>Daftar Participant</b>

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
                    
                    @{{ index+1 }}
                </td>
                    <td>@{{ data.user_nip_baru }} - @{{ data.user_nama }}</td>
                    <td><input class="form-control form-control-sm" type="text" size="3" v-model="data.jumlah_target"></td>
                    <td>@{{ data.jumlah_realisasi }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>