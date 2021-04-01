
    <label>{{ $model->attributes()['keperluan'] }}:</label>
    <input type="text" class="form-control {{($errors->first('keperluan') ? ' parsley-error' : '')}}" name="keperluan" value="{{ old('keperluan', $model->keperluan) }}">
    @foreach ($errors->get('keperluan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach


    <label>{{ $model->attributes()['tanggal'] }}:</label>
    <input type="date" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal" value="{{ old('tanggal', $model->tanggal) }}">
    @foreach ($errors->get('ketua') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach


    <label>{{ $model->attributes()['ketua'] }}:</label>
    <input type="text" class="form-control {{($errors->first('ketua') ? ' parsley-error' : '')}}" name="ketua" value="{{ old('ketua', $model->ketua) }}">
    @foreach ($errors->get('keperluan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach


    <label>{{ $model->attributes()['jamawalguna'] }}:</label>
    <input type="time" class="form-control {{($errors->first('jamawalguna') ? ' parsley-error' : '')}}" name="jamawalguna" value="{{ old('jamawalguna', date('H:i', strtotime($model->jamawalguna))) }}"> 
    @foreach ($errors->get('jamawalguna') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach


    <label>{{ $model->attributes()['jamakhirguna'] }}:</label>
    <input type="time" class="form-control {{($errors->first('jamakhirguna') ? ' parsley-error' : '')}}" name="jamakhirguna" value="{{ old('jamakhirguna', date('H:i', strtotime($model->jamakhirguna))) }}">
    @foreach ($errors->get('jamakhirguna') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach

    <div class="form-group">
        <label>{{ $model->attributes()['status'] }}:</label>
        <select class="form-control {{($errors->first('status') ? ' parsley-error' : '')}}" name="status" {{ (!$model->exists) ? "disabled" : "" }}>
            @foreach ($model->listStatus as $key=>$value)
                <option  value="{{ $key }}" 
                    @if ($key == old('status', $model->status))
                        selected="selected"
                    @endif>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

