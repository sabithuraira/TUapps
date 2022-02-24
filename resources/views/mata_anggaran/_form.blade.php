<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Pilih Tahun:</label>
            <select class="form form-control" name="tahun">
                @for($i=2021;$i <= date('Y')+1;++$i)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['kode_program'] }}:</label>
            <input type="text" class="form-control {{($errors->first('kode_program') ? ' parsley-error' : '')}}" name="kode_program" value="{{ old('kode_program', $model->kode_program) }}" autofocus>
            @foreach ($errors->get('kode_program') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['label_program'] }}:</label>
            <input type="text" class="form-control {{($errors->first('label_program') ? ' parsley-error' : '')}}" name="label_program" value="{{ old('label_program', $model->label_program) }}" >
            @foreach ($errors->get('label_program') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['kode_aktivitas'] }}:</label>
            <input type="text" class="form-control {{($errors->first('kode_aktivitas') ? ' parsley-error' : '')}}" name="kode_aktivitas" value="{{ old('kode_aktivitas', $model->kode_aktivitas) }}" autofocus>
            @foreach ($errors->get('kode_aktivitas') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['label_aktivitas'] }}:</label>
            <input type="text" class="form-control {{($errors->first('label_aktivitas') ? ' parsley-error' : '')}}" name="label_aktivitas" value="{{ old('label_aktivitas', $model->label_aktivitas) }}" >
            @foreach ($errors->get('label_aktivitas') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['kode_kro'] }}:</label>
            <input type="text" class="form-control {{($errors->first('kode_kro') ? ' parsley-error' : '')}}" name="kode_kro" value="{{ old('kode_kro', $model->kode_kro) }}" autofocus>
            @foreach ($errors->get('kode_kro') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['label_kro'] }}:</label>
            <input type="text" class="form-control {{($errors->first('label_kro') ? ' parsley-error' : '')}}" name="label_kro" value="{{ old('label_kro', $model->label_kro) }}" >
            @foreach ($errors->get('label_kro') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['kode_ro'] }}:</label>
            <input type="text" class="form-control {{($errors->first('kode_ro') ? ' parsley-error' : '')}}" name="kode_ro" value="{{ old('kode_ro', $model->kode_ro) }}" autofocus>
            @foreach ($errors->get('kode_ro') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['label_ro'] }}:</label>
            <input type="text" class="form-control {{($errors->first('label_ro') ? ' parsley-error' : '')}}" name="label_ro" value="{{ old('label_ro', $model->label_ro) }}" >
            @foreach ($errors->get('label_ro') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['kode_komponen'] }}:</label>
            <input type="text" class="form-control {{($errors->first('kode_komponen') ? ' parsley-error' : '')}}" name="kode_komponen" value="{{ old('kode_komponen', $model->kode_komponen) }}" autofocus>
            @foreach ($errors->get('kode_komponen') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['label_komponen'] }}:</label>
            <input type="text" class="form-control {{($errors->first('label_komponen') ? ' parsley-error' : '')}}" name="label_komponen" value="{{ old('label_komponen', $model->label_komponen) }}" >
            @foreach ($errors->get('label_komponen') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">

        <div class="form-group">
            <label>{{ $model->attributes()['kode_subkomponen'] }}:</label>
            <input type="text" class="form-control {{($errors->first('kode_subkomponen') ? ' parsley-error' : '')}}" name="kode_subkomponen" value="{{ old('kode_subkomponen', $model->kode_subkomponen) }}" autofocus>
            @foreach ($errors->get('kode_subkomponen') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
 
    <div class="col-md-6">
    
        <div class="form-group">
            <label>{{ $model->attributes()['label_subkomponen'] }}:</label>
            <input type="text" class="form-control {{($errors->first('label_subkomponen') ? ' parsley-error' : '')}}" name="label_subkomponen" value="{{ old('label_subkomponen', $model->label_subkomponen) }}" >
            @foreach ($errors->get('label_subkomponen') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>