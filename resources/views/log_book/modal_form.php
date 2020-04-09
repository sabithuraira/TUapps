<div class="modal fade" id="add_logbooks" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Log Book</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id">

                <div class="row clearfix">
                    <div class="col-md-6">
                        Tanggal:
                        <div class="form-line">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" id="form_tanggal" name="tanggal">
                                <div class="input-group-append">                                            
                                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        Pemberi tugas:
                        <div class="form-line">
                            <input type="text" v-model="form_pemberi_tugas" class="form-control">
                        </div>
                    </div>
                </div>
                    
                <div class="demo-masked-input">
                    Waktu mulai - selesai
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-line">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control time24" id="form_waktu_mulai" v-model="form_waktu_mulai" placeholder="Ex: 12:05">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            
                            <div class="form-line">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control time24" id="form_waktu_selesai" v-model="form_waktu_selesai" placeholder="Ex: 22:35">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        Volume:
                        <div class="form-line">
                            <input type="text" v-model="form_volume" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        Satuan:
                        <div class="form-line">
                            <input type="text" v-model="form_satuan" class="form-control">
                        </div>
                    </div>
                </div>

                Isi:
                <div class="form-line">
                    <textarea type="text" v-model="form_isi" class="form-control" rows=3></textarea>
                </div>
            
                Hasil:
                <div class="form-line">
                    <textarea type="text" v-model="form_hasil" class="form-control" rows=3></textarea>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="saveLogBook">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>