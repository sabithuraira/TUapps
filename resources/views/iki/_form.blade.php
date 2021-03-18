<div class="form-group">
    <label>{{ $model->attributes()['iki_label'] }}:</label>
    <input type="text" class="form-control {{($errors->first('iki_label') ? ' parsley-error' : '')}}" name="iki_label" value="{{ old('iki_label', $model->iki_label) }}">
    @foreach ($errors->get('iki_label') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

