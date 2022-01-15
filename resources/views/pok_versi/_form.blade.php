<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['versi'] }}:</label>
    <input type="number" class="form-control {{($errors->first('versi') ? ' parsley-error' : '')}}" name="versi" value="{{ old('versi', $model->versi) }}" autofocus>
    @foreach ($errors->get('versi') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<div class="form-group">
    <label>{{ $model->attributes()['keterangan'] }}:</label>
    <textarea type="text" class="form-control {{($errors->first('keterangan') ? ' parsley-error' : '')}}" name="keterangan" rows=3>{{ old('keterangan', $model->keterangan) }}</textarea>
    @foreach ($errors->get('keterangan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>