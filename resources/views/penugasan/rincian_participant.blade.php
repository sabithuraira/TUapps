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
                <td>No</td>
                <td>Pegawai</td>
                <td>Keterangan</td>
                <td>Jumlah Target</td>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in participant" :key="data.user_nip_lama">
                <td>
                    @{{ index+1 }}
                </td>
                <td>@{{ data.user_nip_baru }} - @{{ data.user_nama }}</td>
                <td><textarea class="form form-control" v-model="data.keterangan"></textarea></td>
                <td><input class="form-control form-control-sm" type="text" size="3" v-model="data.jumlah_target"></td>
                </tr>
            </tbody>
        </table>
    </div>