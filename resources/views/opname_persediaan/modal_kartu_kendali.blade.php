<div class="modal" id="update_dibuat_oleh" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Informasi Pembuat Daftar</b>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        Nama : <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="text" v-model="form.nama" class="form-control">
                        </div>
                    </div>
                </div>

                <br/>
                <div class="row clearfix">
                    <div class="col-md-12">
                        NIP : <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="text" v-model="form.nip" class="form-control">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="savePembuatDaftar">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>