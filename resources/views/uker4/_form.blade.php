<div class="form-group">
    <label>{{ $model->attributes()['is_kabupaten'] }}:</label>
    <select class="form-control {{($errors->first('is_kabupaten') ? ' parsley-error' : '')}}"  name="is_kabupaten" autofocus>
        <option value="1" @if(1==old('keterangan', $model->keterangan)) selected="selected" @endif>Ya</option>
        <option value="0" @if(2==old('keterangan', $model->keterangan)) selected="selected" @endif>Tidak</option>
    </select>
    @foreach ($errors->get('is_kabupaten') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
    
</div>

<div class="form-group">
    <label>{{ $model->attributes()['nama'] }}:</label>
    <input type="text" class="form-control {{($errors->first('nama') ? ' parsley-error' : '')}}" name="nama" value="{{ old('nama', $model->nama) }}" >
    @foreach ($errors->get('nama') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>