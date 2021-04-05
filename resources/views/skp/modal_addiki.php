
    <div class="modal fade" id="add_iki" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">Tambah IKI Baru</div>
                <div class="modal-body">
                    <div class="form-group">
                        Judul:
                        <div class="form-line">
                            <input type="text" v-model="form_iki_label" class="form-control" placeholder="masukkan judul...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="saveIki">SAVE</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>