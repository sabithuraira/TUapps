<b>Daftar Anggota Tim</b>

<select id="participant_select" class="ms" multiple="multiple">
    @foreach($list_pegawai as $data)
        <option value="{{ $data->nip_baru }}">{{ $data->nip_baru }} - {{ $data->name }}</option>
    @endforeach
</select>
<br/>

<div class="table-responsive">
    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
        <thead>
            <tr class="text-center">
                <td>No</td>
                <td>Pegawai</td>
                <td>Status Keanggotaan</td>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in participant" :key="data.user_nip_lama">
                <td>
                    @{{ index+1 }}
                </td>
                <td>@{{ data.nik_anggota }} - @{{ data.nama_anggota }}</td>
                <td>
                    <select class="form-control form-control-sm" v-model="data.status_keanggotaan">
                        <option value="1">Ketua Tim</option>
                        <option value="2">Anggota Tim</option>
                    </select>
                </td>
            </tr>
        </tbody>
        </table>
    </div>