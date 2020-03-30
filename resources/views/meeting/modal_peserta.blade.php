<div class="modal hide" id="select_peserta" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Pilih Pegawai</h4>
            </div>
            <div class="modal-body">

                <div class="input-group mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="keyword_peserta" placeholder="Cari berdasarkan nama pegawai.." v-on:keydown.enter="setDataPeserta">
                    </div>

                    <div class="col-md-6">
                        <select class="form-control  form-control-sm" v-model="kab_peserta" @change="setDataPeserta">
                            @foreach ( config('app.unit_kerjas') as $key=>$value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="text-center">
                            <th></th>
                            <th>No</th>
                            <th>NIP (Lama/Baru)</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in list_peserta" :key="data.id" style="word-break: break-all;">
                            <td>
                                <a href="#" role="button" class="btn-org" :data-index="index"
                                    v-on:click="pilihPeserta"><i class="fa fa-plus-circle"></i> </a>
                            </td>
                            <td>@{{ index+1 }}</td>
                            <td>@{{ data.email }} / @{{ data.nip_baru }}</td>
                            <td>@{{ data.name }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>