<div class="modal fade" id="add_logbooks" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Log Book</b>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Tanggal:
                    <div class="form-line">
                        <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
                            <input type="text" id="form_tanggal" name="tanggal">
                            <div class="input-group-append">                                            
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" v-model="form_id">
                    
                <div class="form-group demo-masked-input">
                    Waktu mulai - selesai
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-line">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="time" class="form-control" v-model="form_waktu_mulai" placeholder="12:05 AM">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            
                            <div class="form-line">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="time" class="form-control" v-model="form_waktu_selesai" placeholder="12:05 AM">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    Isi:
                    <div class="form-line">
                        <textarea type="text" v-model="form_isi" class="form-control" rows=3></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    Hasil:
                    <div class="form-line">
                        <textarea type="text" v-model="form_hasil" class="form-control" rows=3></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="saveLogBook">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>