<div class="row clearfix">
    <div class="col-md-12 left">
        <div class="form-group">
            <label>{{ $model->attributes()['perihal'] }}:</label>
            <input type="text" class="form-control {{($errors->first('perihal') ? ' parsley-error' : '')}}" name="perihal1"  v-model="form.perihal">
            @foreach ($errors->get('perihal') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6 left">
        <div class="form-group">
            <div class="form-group">
                <label>{{ $model->attributes()['tanggal'] }}:</label>
                <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                    <input type="text" class="datepicker form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal1" id="tanggal" v-model="form.tanggal">
                    <div class="input-group-append">                                            
                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                    </div>
                </div>
                @foreach ($errors->get('tanggal') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>{{ $model->attributes()['penerima'] }}:</label>
            <input type="text" class="form-control {{($errors->first('penerima') ? ' parsley-error' : '')}}" name="penerima1" value="{{ old('penerima', $model->penerima) }}">
            @foreach ($errors->get('penerima') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <label>Nomor Surat:</label>
        <input type="text" class="form-control {{($errors->first('nomor') ? ' parsley-error' : '')}}" name="nomor1" value="{{ old('nomor', $model->nomor) }}">
        @foreach ($errors->get('nomor') as $msg)
            <p class="text-danger">{{ $msg }}</p>
        @endforeach
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>{{ $model->attributes()['alamat'] }} / Pengirim:</label>
            <input type="text" class="form-control {{($errors->first('alamat') ? ' parsley-error' : '')}}" name="alamat1" value="{{ old('alamat', $model->alamat) }}">
            @foreach ($errors->get('alamat') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>