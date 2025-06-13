<div class="modal" id="add_izin_keluars" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Form Permohonan Izin Keluar</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form.id">

                <div class="row clearfix">
                    <div class="col-md-6">
                        Pegawai: <span class="text-danger">*</span>
                        <div class="form-line">
                            <div class="input-group">
                                <select class="form-control  form-control-sm show-tick ms select2" v-model="form.pegawai_nip" id="form_pegawai_nip" >
                                    @foreach ($list_pegawai as $value)
                                        <option value="{{ $value->nip_baru }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
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
                </div>
                <br/>
                <div class="row clearfix">
                    <div class="col-md-6">
                        Jenis Keperluan <span class="text-danger">*</span>
                        <select v-model="form.jenis_keperluan" class="form-control">
                            <option value="">- Pilih -</option>
                            <option value="1">Keperluan Dinas</option>
                            <option value="2">Keperluan Pribadi</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                    </div>
                </div>
                <br/>

                <div class="demo-masked-input">
                    Waktu Keluar - Kembali
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-line">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control time24" id="form_start" v-model="form.start" placeholder="Ex: 12:05">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-line">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control time24" id="form_end" v-model="form.end" placeholder="Ex: 22:35">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                Keterangan: <span class="text-danger">*</span>
                <div class="form-line">
                    <textarea type="text" v-model="form.keterangan" class="form-control" rows=3></textarea>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="saveIzinKeluar">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>