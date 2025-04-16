<div class="modal" id="add_bulletin" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Bulletin</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id">


                <div class="row clearfix mb-2">
                    <div class="col-md-12">
                        Judul <span class="text-danger">*</span>
                        <select v-model="form_judul" id="form_judul" class="form-control show-tick ms">
                            <option value="">Pilih Judul</option>
                            @foreach ($list_judul as $judul)
                                <option value="{{ $judul }}">{{ $judul }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row clearfix mb-2">
                    <div class="col-md-12">
                        Pegawai <span class="text-danger">*</span>
                        <div class="form-line">
                            {{-- <option value="">Pilih Pegawai</option> --}}
                            <select v-model="form_user" id="form_user" class="form-control show-tick ms select2">
                                @foreach ($list_pegawai as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row clearfix mb-2">
                    <div class="col-md-6">
                        Tanggal Mulai: <span class="text-danger">*</span>
                        <div class="form-line">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" id="form_waktu_mulai"
                                    name="waktu_mulai" v-model="form_waktu_mulai">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button"><i
                                            class="fa fa-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        Tanggal Selesai: <span class="text-danger">*</span>
                        <div class="form-line">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" id="form_waktu_selesai"
                                    name="waktu_selesai" v-model="form_waktu_selesai">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button"><i
                                            class="fa fa-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row clearfix mb-2">
                    <div class="col-md-12">
                        Isi: <span class="text-danger">*</span>
                        <div class="form-line">
                            <textarea type="text" v-model="form_deskripsi" class="form-control" rows=3></textarea>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="saveBulletin">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
