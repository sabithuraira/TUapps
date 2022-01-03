<div class="modal" id="modal_form_estimasi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" id="defaultModalLabel">Form Input ESTIMASI</b> @{{ form_transaksi.rincian_label }}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Judul: 
                    <div class="form-line">
                        <input type="text" v-model="form_transaksi.label" class="form-control" placeholder="Judul penggunaan anggaran">
                    </div>
                </div>
                <div class="form-group">
                    Biaya Estimasi
                    <div class="form-line">
                        <input type="number" v-model="form_transaksi.total_estimasi" class="form-control" placeholder="Jumlah biaya">
                    </div>
                </div> 
                
                <div class="form-group">
                    Keterangan Estimasi
                    <div class="form-line">
                        <input type="text" v-model="form_transaksi.ket_estimasi" class="form-control" placeholder="Keterangan">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-btn" @click="saveTransaksi(1)">SAVE</button>
                <button  v-show="form_transaksi.id!=''" type="button" class="btn btn-danger" id="delete-btn" @click="delTransaksi()">DELETE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>