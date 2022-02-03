<div class="modal" id="modal_pj" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><b>Penanggung Jawab : @{{ form_pj.rincian_label }}</b></div>
            <div class="modal-body">
                Pilih Penanggung Jawab Anggaran:
                <div class="form-line">
                    <select class="form form-control show-tick ms select2" id="id_pegawai" v-model="form_pj.id_pegawai" data-placeholder="Pilih">
                        @foreach($list_pegawai as $value)
                            <option value="{{ $value->id }}">{{ $value->nip_baru }} - {{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="savePj">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>