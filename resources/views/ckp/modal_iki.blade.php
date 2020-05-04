
    <div class="modal hide" id="select_iki" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Pilih IKI</h4>
                </div>
                <div class="modal-body">
                    <table class="table-sm table-bordered table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>IKI</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in list_iki" :key="data.id">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ data.iki_label }}</td>
                                <td class="text-center"><button class="btn btn-outline-primary btn-sm" type="button" v-on:click="pilihIki" :data-index="index">Pilih</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-outline-primary btn-sm" type="button" v-on:click="addIki"><span class="fa fa-plus"></span> &nbspTambah IKI Baru</button>
                                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>