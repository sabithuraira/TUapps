<div class="modal" id="add_logbooks" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Log Book</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id">

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
                <br/>

                Isi: <span class="text-danger">*</span>
                <a href="#" role="button" data-toggle="modal" data-target="#select_kegiatan"> 
                    <i class="icon-magnifier"></i>
                    <b class='text-muted small'>Pilih Kegiatan</b>
                </a>
                <div class="form-line">
                    <textarea disabled type="text" v-model="form_isi" class="form-control" rows=3></textarea>
                </div>
            
                Hasil:
                <div class="form-line">
                    <textarea type="text" v-model="form_hasil" class="form-control" rows=3></textarea>
                </div>
                
                Pilih IKI yang mengacu pada pekerjaan ini:
                <div class="row clearfix">
                    <select v-model="form_id_iki" id="id_iki" class="form-control show-tick ms select2">
                        @foreach($list_iki as $value)
                            <option value="{{ $value->id }}">({{ $value->tahun }}) - {{ $value->ik }}</option>
                        @endforeach
                    </select>
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

<div class="modal" id="select_kegiatan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Pilih Kegiatan</b>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" @keypress.enter="searchKegiatan" v-model="keyword_kegiatan" placeholder="Search..">

                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="searchKegiatan"><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                    <table class="table-bordered m-b-0" style="width:100%;min-width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th></th>
                                <th class="text-center">Sub Kegiatan</th>
                                <th class="text-center">Uraian Pekerjaan</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(data, index) in list_kegiatan" :key="data.id">
                                <td>
                                    @{{ index+1 }}
                                </td>
                                <td>
                                    <a href="#" role="button" v-on:click="selectKegiatan" 
                                        class="ml-2 mr-2" 
                                        :data-id="data.id" :data-subkegiatan="data.subkegiatan"
                                        :data-uraian_pekerjaan="data.uraian_pekerjaan"
                                        > <i class="icon-check"></i></a>
                                </td>
                                <td>@{{ data.subkegiatan }}</td>
                                <td>@{{ data.uraian_pekerjaan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>