<div class="modal" id="modal_pj" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><b>Pilih Penanggung Jawab</b></div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id">
                Pilih Penanggung Jawab Anggaran:
                <div class="form-line">
                    <select class="form form-control" v-model="form_pj.id_pegawai">
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