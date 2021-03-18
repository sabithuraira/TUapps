<div class="form-group">
    <label>{{ $model->attributes()['uraian'] }}:</label>
    <input type="text" class="form-control {{($errors->first('uraian') ? ' parsley-error' : '')}}" name="uraian" value="{{ old('uraian', $model->uraian) }}" autofocus>
    @foreach ($errors->get('uraian') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
    
</div>
<br>
<button type="submit" class="btn btn-primary">Simpan</button>