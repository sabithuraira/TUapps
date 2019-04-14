<div class="form-group">
    <label>{{ $model->attributes()['jenis'] }}:</label>
    <select class="form-control {{($errors->first('jenis') ? ' parsley-error' : '')}}"  name="jenis" autofocus>
        <option>- Pilih Peruntukan -</option>
        @foreach ($item_jenis as $ijenis)
            <option value="{{ $ijenis['id'] }}">{{ $ijenis['jenis'] }}</option>
        @endforeach
    </select>
    @foreach ($errors->get('jenis') as $msg)<p class="text-danger">{{ $msg }}</p>@endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['kode'] }}:</label>
    <input type="text" class="form-control {{($errors->first('kode') ? ' parsley-error' : '')}}" name="kode" value="{{ old('kode', $model->kode) }}">
    @foreach ($errors->get('kode') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['butir_kegiatan'] }}:</label>
    <input type="text" class="form-control {{($errors->first('butir_kegiatan') ? ' parsley-error' : '')}}" name="butir_kegiatan" value="{{ old('butir_kegiatan', $model->butir_kegiatan) }}">
    @foreach ($errors->get('butir_kegiatan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['satuan_hasil'] }}:</label>
    <input type="text" class="form-control {{($errors->first('satuan_hasil') ? ' parsley-error' : '')}}" name="satuan_hasil" value="{{ old('satuan_hasil', $model->satuan_hasil) }}">
    @foreach ($errors->get('satuan_hasil') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>


<div class="form-group">
    <label>{{ $model->attributes()['surat_km'] }}:</label>
    <input type="text" class="form-control {{($errors->first('surat_km') ? ' parsley-error' : '')}}" name="surat_km" value="{{ old('surat_km', $model->surat_km) }}">
    @foreach ($errors->get('surat_km') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>


<div class="form-group">
    <label>{{ $model->attributes()['batas_penilaian'] }}:</label>
    <input type="text" class="form-control {{($errors->first('batas_penilaian') ? ' parsley-error' : '')}}" name="batas_penilaian" value="{{ old('batas_penilaian', $model->batas_penilaian) }}">
    @foreach ($errors->get('batas_penilaian') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>


<div class="form-group">
    <label>{{ $model->attributes()['pelaksana'] }}:</label>
    <input type="text" class="form-control {{($errors->first('pelaksana') ? ' parsley-error' : '')}}" name="pelaksana" value="{{ old('pelaksana', $model->pelaksana) }}">
    @foreach ($errors->get('pelaksana') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>


<div class="form-group">
    <label>{{ $model->attributes()['bukti_fisik'] }}:</label>
    <input type="text" class="form-control {{($errors->first('bukti_fisik') ? ' parsley-error' : '')}}" name="bukti_fisik" value="{{ old('bukti_fisik', $model->bukti_fisik) }}">
    @foreach ($errors->get('bukti_fisik') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>
<br>
<button type="submit" class="btn btn-primary">Simpan</button>