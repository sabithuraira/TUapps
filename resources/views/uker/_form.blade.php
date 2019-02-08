<div class="form-group">
    <label>{{ $model->attributes()['kode'] }}:</label>
    <input type="text" class="form-control {{($errors->first('kode') ? ' parsley-error' : '')}}" name="kode" value="{{ old('kode', $model->kode) }}" autofocus>
    @foreach ($errors->get('kode') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
    
</div>

<div class="form-group">
    <label>{{ $model->attributes()['nama'] }}:</label>
    <!-- <input type="text" class="form-control {{($errors->first('nama') ? ' parsley-error' : '')}}" name="nama" value="{{ old('nama', $model->nama) }}" > -->
    <input type="file" class="form-control {{($errors->first('nama') ? ' parsley-error' : '')}}" name="nama" value="{{ old('nama', $model->nama) }}">    
    @foreach ($errors->get('nama') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>