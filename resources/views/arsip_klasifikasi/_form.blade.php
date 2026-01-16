<div class="form-group">
    <label>Kode:</label>
    <input type="text" class="form-control {{($errors->first('kode') ? ' parsley-error' : '')}}" name="kode" maxlength="2" value="{{ old('kode', $model->kode) }}">
    @foreach ($errors->get('kode') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>Kode 2:</label>
    <input type="text" class="form-control {{($errors->first('kode_2') ? ' parsley-error' : '')}}" name="kode_2" maxlength="3" value="{{ old('kode_2', $model->kode_2) }}">
    @foreach ($errors->get('kode_2') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>Kode 3:</label>
    <input type="text" class="form-control {{($errors->first('kode_3') ? ' parsley-error' : '')}}" name="kode_3" maxlength="3" value="{{ old('kode_3', $model->kode_3) }}">
    @foreach ($errors->get('kode_3') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>Kode 4:</label>
    <input type="text" class="form-control {{($errors->first('kode_4') ? ' parsley-error' : '')}}" name="kode_4" maxlength="3" value="{{ old('kode_4', $model->kode_4) }}">
    @foreach ($errors->get('kode_4') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>Kode Gabung:</label>
    <input type="text" class="form-control {{($errors->first('kode_gabung') ? ' parsley-error' : '')}}" name="kode_gabung" value="{{ old('kode_gabung', $model->kode_gabung) }}">
    @foreach ($errors->get('kode_gabung') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>Judul:</label>
    <textarea class="form-control {{($errors->first('judul') ? ' parsley-error' : '')}}" name="judul" rows="4">{{ old('judul', $model->judul) }}</textarea>
    @foreach ($errors->get('judul') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

