<div class="modal" id="modal_form_realisasi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" id="defaultModalLabel">Form Input REALISASI</b> @{{ form_transaksi.rincian_label }}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Judul: 
                    <div class="form-line">
                        <input type="text" v-model="form_transaksi.label" class="form-control" placeholder="Judul penggunaan anggaran">
                    </div>
                </div>
                <div class="form-group">
                    Biaya Realisasi
                    <div class="form-line">
                        <input type="number" v-model="form_transaksi.total_realisasi" class="form-control" placeholder="Jumlah biaya">
                    </div>
                </div> 
                
                <div class="form-group">
                    Keterangan Realisasi
                    <div class="form-line">
                        <input type="text" v-model="form_transaksi.ket_realisasi" class="form-control" placeholder="Keterangan">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-btn" @click="saveTransaksi(2)">SAVE</button>
                <button  v-show="form_transaksi.id!=''" type="button" class="btn btn-danger" id="delete-btn" @click="delTransaksi()">DELETE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>