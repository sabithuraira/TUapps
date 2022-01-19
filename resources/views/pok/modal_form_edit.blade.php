<div class="modal" id="modal_form_edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><b>Perbaharu Rincian Anggaran</b></div>
            <div class="modal-body">
                <div class="form-group">
                    Program: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_program + ' - ' + form_edit.program">
                    </div>
                </div>
                
                <div class="form-group">
                    Aktivitas: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_aktivitas + ' - ' + form_edit.aktivitas">
                    </div>
                </div>
                
                <div class="form-group">
                    KRO: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_kro + ' - ' + form_edit.kro">
                    </div>
                </div>
                
                <div class="form-group">
                    RO: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_ro + ' - ' + form_edit.ro">
                    </div>
                </div>
                
                <div class="form-group">
                    Komponen: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_komponen + ' - ' + form_edit.komponen">
                    </div>
                </div>
                
                <div class="form-group">
                    Sub Komponen: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_sub_komponen + ' - ' + form_edit.sub_komponen">
                    </div>
                </div>
                
                <div class="form-group">
                    Mata Anggaran: 
                    <div class="form-line">
                        <input type="text" class="form form-control" disabled :value="form_edit.kode_mata_anggaran + ' - ' + form_edit.mata_anggaran">
                    </div>
                </div>
                    
                <div class="form-group">
                    Rincian yang ditambahkan: 
                    <div class="form-line">
                        <input type="text" class="form form-control" v-model="form_edit.label" >
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-4">
                        Volume:
                        <div class="form-line">
                            <input type="number" v-model="form_edit.volume" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        Satuan:
                        <div class="form-line">
                            <input type="text" v-model="form_edit.satuan" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        Harga Satuan:
                        <div class="form-line">
                            <input type="number" v-model="form_edit.harga_satuan" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="savePok">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>