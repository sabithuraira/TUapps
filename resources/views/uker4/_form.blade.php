<div class="form-group">
    <label>{{ $model->attributes()['is_kabupaten'] }}:</label>
    <select class="form-control {{($errors->first('is_kabupaten') ? ' parsley-error' : '')}}"  name="is_kabupaten" autofocus>
        <option value="1" @if($model->is_kabupaten==1) selected="selected" @endif>Ya</option>
        <option value="0" @if($model->is_kabupaten==0) selected="selected" @endif>Tidak</option>
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

<div class="form-group">
    <label>Tampilkan pada pilihan Barang Persediaan:</label>
    <select class="form-control {{($errors->first('is_persediaan') ? ' parsley-error' : '')}}"  name="is_persediaan" autofocus>
        <option value="1" @if($model->is_persediaan==1) selected="selected" @endif>Ya</option>
        <option value="0" @if($model->is_persediaan==0) selected="selected" @endif>Tidak</option>
    </select>
    @foreach ($errors->get('is_persediaan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>