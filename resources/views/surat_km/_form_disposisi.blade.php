<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['tanggal'] }}:</label>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal5" id="tanggal" v-model="form.tanggal">
                <div class="input-group-append">                                            
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                </div>
            </div>
            @foreach ($errors->get('tanggal') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>Nomor Surat:</label>
            <input type="text" class="form-control" v-model="form.nomor" name="nomor5">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nomor Urut:</label>
            <input type="text" class="form-control" name="nomor_urut5" v-model="form.nomor_urut">
            <small class="text-info">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</small>
        </div>
    </div>
    
    <div class="col-md-4 left">
        <div class="form-group">
            <label>Nomor Agenda:</label>
            <input type="text" class="form-control" name="nomor_agenda5" v-model="form_disposisi.nomor_agenda">
        </div>
    </div>

    <div class="col-md-4 left">
        <div class="form-group">
            <label>Tingkat Keamanan:</label>
            <select class="form-control" v-model="form.tingkat_keamanan" name="tingkat_keamanan5">
                <option value="">- Pilih Tingkat Keamanan -</option>
                @foreach ($model->listTingkatKeamanan as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Tanggal Penerimaan:</label>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control" name="tanggal_penerimaan5" id="tanggal_penerimaan">
                <div class="input-group-append">                                            
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Tanggal Penyelesaian:</label>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control" name="tanggal_penyelesaian5" id="tanggal_penyelesaian">
                <div class="input-group-append">                                            
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Dari:</label>
            <input type="text" class="form-control" name="dari5" v-model="form_disposisi.dari">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Lampiran:</label>
            <input type="text" class="form-control" name="lampiran5" v-model="form_disposisi.lampiran">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Ringkasan Isi:</label>
            <textarea id="isi5" class="form-control" v-model="form_disposisi.isi" name="isi5" rows="5"></textarea>
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Isi Disposisi:</label>
            <textarea id="isi_disposisi" class="form-control" v-model="form_disposisi.isi_disposisi" name="isi_disposisi5" rows="5"></textarea>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Diteruskan Kepada:</label>
            <textarea id="diteruskan_kepada" class="form-control" name="diteruskan_kepada5" v-model="form_disposisi.diteruskan_kepada" rows="5"></textarea>
        </div>
    </div>
</div>
