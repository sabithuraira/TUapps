<div class="modal" id="add_progres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Isian Progres</b>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        Pegawai:
                        <div class="form-line">
                            <input type="text" disabled v-model="detail_participant.user_name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        Jumlah Target:
                        <div class="form-line">
                            <input type="text" disabled v-model="detail_participant.jumlah_target" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        Jumlah Selesai:
                        <div class="form-line">
                            <input type="text" v-model="detail_participant.jumlah_selesai" class="form-control">
                        </div>
                    </div>
                </div>
                    
                <div class="demo-masked-input">
                    Progres Terakhir Data
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-line">
                                <div class="input-group">
                                    <input type="text" id="tanggal_last_progress" class="form-control datepicker form-control-sm">
                                    <div class="input-group-append">                                            
                                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="saveProgres">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>