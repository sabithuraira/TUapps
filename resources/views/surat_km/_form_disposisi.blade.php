<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['tanggal'] }}:</label>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal" id="tanggal" v-model="tanggal">
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
            <label>Tingkat Keamanan:</label>
            <select class="form-control" v-model="tingkat_keamanan" name="tingkat_keamanan">
                <option value="">- Pilih Tingkat Keamanan -</option>
                @foreach ($model->listTingkatKeamanan as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nomor Urut:</label>
            <input type="text" class="form-control" name="nomor_urut" v-model="nomor_urut">
            <small class="text-info">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</small>
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Nomor Agenda:</label>
            <input type="text" class="form-control" name="nomor_agenda" v-model="nomor_agenda">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Tanggal Penerimaan:</label>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" v-model="tanggal_penerimaan">
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
                <input type="text" class="form-control" name="tanggal_penyelesaian" id="tanggal_penyelesaian" v-model="tanggal_penyelesaian">
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
            <input type="text" class="form-control" name="dari">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Lampiran:</label>
            <input type="text" class="form-control" name="lampiran">
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Ringkasan Isi:</label>
            <textarea id="isi" class="summernote form-control" name="isi" rows="10"></textarea>
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Isi Disposisi:</label>
            <textarea id="isi_disposisi" class="summernote form-control" name="isi_disposisi" rows="10"></textarea>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Diteruskan Kepada:</label>
            <textarea id="diteruskan_kepada" class="summernote form-control" name="diteruskan_kepada" rows="10"></textarea>
        </div>
    </div>
</div>
