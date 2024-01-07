<div class="modal" id="add_logbooks" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Log Book</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id">
                
                <div class="row clearfix">
                    <div class="col-md-12">
                    <b>IKI yang mengacu pada pekerjaan ini:</b><br/>
                    @{{ form_label_iki }}<br/><br/>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        Tanggal: <span class="text-danger">*</span>
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
                        Pemberi tugas: <span class="text-danger">*</span>
                        <div class="form-line">
                            <!-- <input type="text" v-model="form_pemberi_tugas" class="form-control"> -->
                            <select v-model="form_pemberi_tugas" id="pemberi_tugas" class="form-control show-tick ms select2">
                                @foreach($list_pegawai as $value)
                                    <option value="{{ $value->email }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        Volume: <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="text" v-model="form_volume" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        Satuan: <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="text" v-model="form_satuan" class="form-control">
                        </div>
                    </div>
                </div>

                Isi: <span class="text-danger">*</span>
                <div class="form-line">
                    <textarea type="text" v-model="form_isi" class="form-control" rows=3></textarea>
                </div>
            
                Hasil:
                <div class="form-line">
                    <textarea type="text" v-model="form_hasil" class="form-control" rows=3></textarea>
                </div>

                <div class="row clearfix">
                    <div class="col-md-6">
                        Bukti Dukung IKI:
                        <div class="form-line">
                            <textarea type="text" v-model="form_link_bukti_dukung" class="form-control" rows=3></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        Jumlah Jam: <span class="text-danger">*</span>
                        <div class="form-line">
                            <input type="number" v-model="form_jumlah_jam" class="form-control">
                        </div>
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