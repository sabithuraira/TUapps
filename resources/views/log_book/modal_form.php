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
                            <input type="text" id="tanggal" name="tanggal" v-model="form_tanggal">
                            <div class="input-group-append">                                            
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" v-model="form_id">
                    
                <div class="form-group">
                    Jumlah
                    <div class="form-line">
                        <input type="number" v-model="form_jumlah" class="form-control" placeholder="Jumlah barang">
                    </div>
                </div>

                <div v-if="form_current_jenis==2" class="form-group">
                    Unit Kerja:
                    <div class="form-line">
                        <select class="form-control"  v-model="form_unit_kerja" autofocus>
                            <option value="">- Pilih Unit Kerja -</option>
                            @foreach ($unit_kerja as $key=>$value)
                                <option value="{{ $value->id }}">{{ $value->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div v-if="form_current_jenis==1" class="form-group">
                    Penyedia:
                    <div class="form-line">
                        <input type="text" v-model="form_nama_penyedia" class="form-control" placeholder="Nama Penyedia">
                    </div>
                </div>

                <div class="form-group">
                    Tanggal:
                    <div class="form-line">
                        <select class="form-control"  v-model="form_tanggal" autofocus>
                            <option value="">- Pilih Tanggal -</option>
                            @for($i=1;$i<=31;++$i)
                                <option value="{{ $i }}">{{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-btn">SAVE</button>
                <button  v-show="form_id_data!=''" type="button" class="btn btn-danger" id="delete-btn">DELETE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>