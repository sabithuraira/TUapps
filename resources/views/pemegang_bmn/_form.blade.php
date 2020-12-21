<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['id_pemegang'] }}:</label>
    <select class="form-control  form-control-sm  {{($errors->first('id_pemegang') ? ' parsley-error' : '')}}" name="id_pemegang">
        @foreach ($list_user as $value)
            <option value="{{ $value->id }}" 
                @if ($value->id == old('id_pemegang', $model->id_pemegang))
                    selected="selected"
                @endif >{{ $value->nip_baru }} - {{ $value->name }}</option>
        @endforeach
    </select>
    @foreach ($errors->get('id_pemegang') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['nama_barang'] }}:</label>
    <input type="text" class="form-control {{($errors->first('nama_barang') ? ' parsley-error' : '')}}" name="nama_barang" value="{{ old('nama_barang', $model->nama_barang) }}" autofocus>
    @foreach ($errors->get('nama_barang') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['serial_number'] }}:</label>
    <input type="text" class="form-control {{($errors->first('serial_number') ? ' parsley-error' : '')}}" name="serial_number" value="{{ old('serial_number', $model->serial_number) }}" autofocus>
    @foreach ($errors->get('serial_number') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<div class="form-group">
    <label>{{ $model->attributes()['deskripsi_barang'] }}:</label>
    <textarea type="text" class="form-control {{($errors->first('deskripsi_barang') ? ' parsley-error' : '')}}" name="deskripsi_barang" rows=3>{{ old('deskripsi_barang', $model->deskripsi_barang) }}</textarea>
    @foreach ($errors->get('deskripsi_barang') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>