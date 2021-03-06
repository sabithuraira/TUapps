<div class="modal" id="form_rincian" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" id="defaultModalLabel">Tambah Pegawai</b>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="form-group">Pegawai:
                            <div class="form-line">
                                <select class="form-control" id="nip" v-model="cur_rincian.nip">
                                    @foreach ($list_pegawai as $value)
                                        <option value="{{ $value->nip_baru }}">{{ $value->name }} - {{ $value->nip_baru }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row clearfix">
                    <div class="col-md-6">
                        {{ $model_rincian->attributes()['tingkat_biaya'] }}
                        <div class="form-line">
                            <select class="form-control" v-model="cur_rincian.tingkat_biaya">
                                @foreach ($model_rincian->listTingkatBiaya as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{ $model_rincian->attributes()['kendaraan'] }}
                        <div class="form-line">
                            <select class="form-control" v-model="cur_rincian.kendaraan">
                                @foreach ($model_rincian->listKendaraan as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="saveRincian(1)" >SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>