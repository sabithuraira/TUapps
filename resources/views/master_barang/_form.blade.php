<div class="form-group">
    <label>{{ $model->attributes()['nama_barang'] }}:</label>
    <input type="text" class="form-control {{($errors->first('nama_barang') ? ' parsley-error' : '')}}" name="nama_barang" value="{{ old('nama_barang', $model->nama_barang) }}">
    @foreach ($errors->get('nama_barang') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['satuan'] }}:</label>
    <input type="text" class="form-control {{($errors->first('satuan') ? ' parsley-error' : '')}}" name="satuan" value="{{ old('satuan', $model->satuan) }}">
    @foreach ($errors->get('satuan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['harga_satuan'] }}:</label>
    <input type="number" class="form-control {{($errors->first('harga_satuan') ? ' parsley-error' : '')}}" name="harga_satuan" value="{{ old('harga_satuan', $model->harga_satuan) }}">
    @foreach ($errors->get('harga_satuan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

