<div class="modal" id="form_pelatihan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" v-if="cur_kategori_peserta==1">Tambah Peserta</b>
                <b class="title" v-else-if="cur_kategori_peserta==2">Tambah Pengajar</b>
                <b class="title" v-else-if="cur_kategori_peserta==3">Tambah Panitia</b>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="form-group">{{ $model_pelatihan->attributes()['unit_kerja'] }}
                            <div class="form-line">
                                <select class="form-control" v-model="cur_rincian.unit_kerja">
                                    @foreach ($list_unit_kerja as $key=>$value)
                                        <option value="{{ $value->kode }}">{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">Pegawai:
                            <div class="form-line">
                                <select class="form-control" id="nip" v-model="cur_rincian.nip">
                                    <option v-for="item in current_list_pegawai" :key="item.id" 
                                        :value="item.nip_baru">
                                        @{{ item.name }} - @{{ item.nip_baru }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="form-group">{{ $model_pelatihan->attributes()['asal_daerah'] }}
                            <div class="form-line">
                                <input class="form-control form-control-sm" type="text" v-model="cur_rincian.asal_daerah">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">{{ $model_pelatihan->attributes()['jabatan_pelatihan'] }}
                            <div class="form-line">
                                <input class="form-control form-control-sm" type="text" v-model="cur_rincian.jabatan_pelatihan" placeholder="contoh: PMS, PCS, Inda, dll">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row clearfix">
                    <div class="col-md-6">
                        {{ $model_pelatihan->attributes()['tingkat_biaya'] }}
                        <div class="form-line">
                            <select class="form-control" v-model="cur_rincian.tingkat_biaya">
                                @foreach ($model_pelatihan->listTingkatBiaya as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{ $model_pelatihan->attributes()['kendaraan'] }}
                        <div class="form-line">
                            <select class="form-control" v-model="cur_rincian.kendaraan">
                                @foreach ($model_pelatihan->listKendaraan as $key=>$value)
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